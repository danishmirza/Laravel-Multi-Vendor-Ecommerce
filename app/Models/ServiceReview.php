<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ServiceReview extends Model
{
    protected $dateFormat = 'U';

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'service_id', 'user_id', 'order_id', 'rating', 'comment', 'is_given'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
