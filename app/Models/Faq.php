<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $dateFormat = 'U';
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'question' => 'array',
        'answer' => 'array',
    ];

    protected $fillable = [
        'question', 'answer'
    ];

    public function getInitialObject(){
        $obj = new self();
        $obj->question = ['en' => '', 'ar' => ''];
        $obj->answer = ['en' => '', 'ar' => ''];
        return $obj;
    }
}
