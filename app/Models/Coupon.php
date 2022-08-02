<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $dateFormat = 'U';

    public static $snakeAttributes = false;

    protected $hidden =[
      'created_at', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'name'          => 'array',
        'coupon_code'   => 'string',
        'discount'      => 'int',
        'status'        => 'string',
        'coupon_type'   => 'string',
        'coupon_number' => 'int',
    ];

    protected $fillable = [
        'name',
        'coupon_code',
        'discount',
        'end_date',
        'status',
        'coupon_type',
        'coupon_number',
    ];

    public function getInitialObject(){
        $obj = new self();
        $obj->name = ['en' => '', 'ar' => ''];
        $obj->coupon_code = $this->generateRandomString();
        $obj->end_date = Carbon::now()->addDay()->startOfDay();
        $obj->coupon_type = 'infinite';
        return $obj;
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

    public function isNumber(){
        return $this->coupon_type == 'number';
    }

}
