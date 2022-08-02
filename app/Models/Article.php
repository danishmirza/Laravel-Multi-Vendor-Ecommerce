<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, Sluggable;

    protected $dateFormat = 'U';

    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'author' => 'array'
    ];

    protected $fillable = [
        'title', 'content', 'image', 'slug', 'author'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title.en'
            ]
        ];
    }


    public function getInitialObject(){
        $obj = new Article();
        $obj->title = ['en' => '', 'ar' => ''];
        $obj->author = ['en' => '', 'ar' => ''];
        $obj->content = ['en' => '', 'ar' => ''];
        return $obj;
    }

}
