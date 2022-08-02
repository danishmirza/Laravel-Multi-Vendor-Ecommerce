<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden =['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'phone',
        'user_id',
        'city_id',
        'area_id',
        'address',
        'latitude',
        'longitude',
        'detail'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'user_id' => 'int',
        'city_id' => 'int',
        'area_id' => 'int'
    ];

    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }

    public function area(){
        return $this->belongsTo(City::class, 'area_id');
    }
}
