<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, HasFactory;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $table = 'categories';

    protected $fillable = [
        'title',
        'content',
        'image',
        'parent_id'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'title' => 'array',
        'content' => 'array',
        'parent_id' => 'int'
    ];

    public function scopeParent($query){
        return $query->where('parent_id', 0);
    }

    public function getInitialObject(){
        $obj = new Category();
        $obj->title = ['en' => '', 'ar' => ''];
        $obj->content = ['en' => '', 'ar' => ''];
        return $obj;
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'category_id');
    }

}
