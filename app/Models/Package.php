<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    public static $SUBSCRIPTION_KEY = 'subscription';
    public static $PACKAGE_KEY = 'featured';
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'total_days' => 'int',
        'title' => 'array',
        'description' => 'array',
        'is_free' => 'bool',
    ];
    protected $fillable = [
        'title',
        'duration',
        'duration_type',
        'is_free',
        'price',
        'description',
        'package_type',
        'total_days'

    ];

    public function scopeSubscriptions($query)
    {
        return $query->where('package_type', self::$SUBSCRIPTION_KEY);
    }

    public function scopeFeatured($query)
    {
        return $query->where('package_type', self::$PACKAGE_KEY);
    }

    public function getInitialObject(){
        $obj = new self();
        $obj->title = ['en' => '', 'ar' => ''];
        $obj->description = ['en' => '', 'ar' => ''];
        return $obj;
    }

    public function isSubscription(): bool
    {
        return $this->attributes['package_type'] == self::$SUBSCRIPTION_KEY;
    }

    public function isFeatured(): bool
    {
        return $this->attributes['package_type'] == self::$PACKAGE_KEY;
    }

    public function isFree(): bool
    {
        return $this->attributes['is_free'];
    }

    public function purchasedPackages(){
        return $this->hasMany(StorePurchasedPackage::class, 'package_id');
    }


}
