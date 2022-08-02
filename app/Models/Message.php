<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $dateFormat = 'U';

    public static $snakeAttributes = false;

    protected $hidden = [
         'updated_at', 'user_removed', 'store_removed'
    ];

    protected $fillable = [
        'sender_id',
        'conversation_id',
        'message',
        'message_type',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
