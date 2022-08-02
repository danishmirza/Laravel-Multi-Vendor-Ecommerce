<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $dateFormat = 'U';
    protected  $table = "cart";

    protected $hidden = [
        'updated_at','created_at'
    ];


    protected $fillable = [
        'store_id', 'user_id', 'service_id'
    ];

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function store(){
        return $this->belongsTo(User::class, 'store_id');
    }
}
