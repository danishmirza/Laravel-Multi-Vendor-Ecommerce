<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];

    protected $fillable = [
        'user_id',
        'store_id',
        'order_id',
        'service_id',
        'price',
        'image',
    ];

    public function service(){
        return $this->belongsTo(Service::class)->withTrashed();
    }

}
