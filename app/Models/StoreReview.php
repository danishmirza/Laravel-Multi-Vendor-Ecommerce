<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StoreReview extends Model
{
    protected $dateFormat = 'U';

    protected $hidden = [
        'updated_at',
    ];

    protected $fillable = [
        'store_id', 'user_id', 'order_id', 'rating', 'comment', 'is_given'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }



}
