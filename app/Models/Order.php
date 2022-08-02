<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];

    protected $fillable = [
        'user_id',
        'store_id',
        'order_number',
        'address',
        'visit_time',
        'subtotal',
        'coupon_discount',
        'coupon',
        'vat_percentage',
        'vat',
        'service_fees',
        'total',
        'payment_method',
        'services_count',
        'image',
        'order_status'
    ];

    public function store(){
        return $this->belongsTo(User::class, 'store_id')->withTrashed();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function getAddressAttribute($value) {
        return json_decode($value);
    }

    public function getCouponAttribute($value) {
        return json_decode($value);
    }

    public function isConfirmed(){
        return $this->order_status == 'confirmed';
    }

    public function isInprogress(){
        return $this->order_status == 'in-progress';
    }

    static function generateRandomString($length = 8)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
