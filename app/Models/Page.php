<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'content' => 'array',
        'name' => 'array',
    ];

    protected $fillable = [
        'slug',
        'image',
        'page_type',
        'icon',
        'name',
        'name->en',
        'name->ar',
        'content',
        'content->en',
        'content->ar'
    ];

}
