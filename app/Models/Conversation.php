<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{

    protected $dateFormat = 'U';

    public static $snakeAttributes = false;

    protected $hidden =[
         'updated_at', 'user_removed', 'store_removed'
    ];

    protected $fillable = [
        'user_id',
        'store_id',
        'store_removed',
        'user_removed'
    ];

    public function lastMessage(){
        return $this->hasOne(Message::class, 'conversation_id')->latest();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id' );
    }

    public function store(){
        return $this->belongsTo(User::class, 'store_id');
    }

}
