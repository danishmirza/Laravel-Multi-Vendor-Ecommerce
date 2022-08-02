<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ad extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'content' => 'array',
        'title' => 'array',
        'sub_title' => 'array',
    ];

    protected $fillable = [
        'image',
        'title',
        'sub_title',
        'content',
        'ad_status',
        'store_id',
        'is_active'
    ];

    public function getInitialObject(){
        $obj = new self();
        $obj->title = ['en' => '', 'ar' => ''];
        $obj->sub_title = ['en' => '', 'ar' => ''];
        $obj->content = ['en' => '', 'ar' => ''];
        return $obj;
    }

    public function store(){
        return $this->belongsTo(User::class, 'store_id');
    }

}
