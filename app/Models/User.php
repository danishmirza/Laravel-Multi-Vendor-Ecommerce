<?php

namespace App\Models;

use Attribute;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable, SoftDeletes;
    protected $dateFormat = 'U';
    public static $USER = 'user';
    public static $STORE = 'store';

    protected $casts = [
        'store_name' => 'array',
        'detail' => 'array',
        'email_verified' => 'boolean',
        'trade_license_verified' => 'boolean',
        'is_active' => 'boolean',
        'subscription_ends_date' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int',
    ];

    protected $fillable = [
        'city_id',
        'user_type',
        'name',
        'store_name',
        'slug',
        'detail',
        'email',
        'phone',
        'address',
        'latitude',
        'longitude',
        'image',
        'trade_license',
        'password',
        'password_reset_code',
        'email_verified',
        'email_verification_code',
        'trade_license_verified',
        'is_active',
        'cart_store_id',
        'subscription_ends_date',
        'is_notification_enabled',
        'default_address_id',
        'applied_coupon_id',
        'total_earnings',
        'amount_remaining',
        'amount_on_hold',
        'amount_withdrawn',

    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'password'
    ];

    public function getInitialObject(){
        $obj = new self();
        $obj->store_name = ['en' => '', 'ar' => ''];
        $obj->detail = ['en' => '', 'ar' => ''];
        return $obj;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'store_name.en'
            ]
        ];
    }

    public function isUser(){
        return $this->user_type == User::$USER;
    }

    public function isStore(){
        return $this->user_type == User::$STORE;
    }

    public function scopeStores($query){
       return $query->where('user_type', self::$STORE);
    }

    public function isNotSubscribed(){
        return is_null($this->subscription_ends_date) ;
    }

    public function isSubscribed(){
        return !is_null($this->subscription_ends_date) ;
    }

    public function isSubscriptionExpired(){
        return Carbon::parse($this->subscription_ends_date)->endOfDay()->diffInDays(Carbon::now()->startOfDay()) <= 0;
    }

    public function isTradeLicenseVerified(){
        return $this->trade_license_verified == 1 ;
    }

    public function isEmailVerified(){
        return $this->email_verified == 1;
    }

    public function isNotificationEnabled(){
        return $this->is_notification_enabled == 1;
    }

    public function cartStoreId(){
        return $this->cart_store_id;
    }

    public function isCouponApplied(){
        return !is_null($this->applied_coupon_id);
    }

    public function portfolio(){
        return $this->hasMany(Portfolio::class, 'store_id');
    }

    public function fcmTokens(){
        return $this->hasMany(Fcm::class, 'user_id');
    }

    public function packageSubscribed(){
        return $this->hasOne(StoreSubscription::class, 'store_id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'store_id');
    }

    public function storeAreas(){
        return $this->hasMany(StoreArea::class, 'store_id');
    }

    public function storeReviews(){
        return $this->hasMany(StoreReview::class, 'store_id');
    }

    public function storeReview(){
        return $this->hasOne(StoreReview::class, 'store_id');
    }

    public function conversations(){
        return $this->hasMany(Conversation::class);
    }



}
