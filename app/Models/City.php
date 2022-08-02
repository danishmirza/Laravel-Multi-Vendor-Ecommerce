<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $table = 'cities';

    protected $fillable = [
        'parent_id',
        'title',
        'polygon',
        'latitude',
        'longitude',
        'address'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'title' => 'array',
        'parent_id' => 'int'
    ];

    public function getInitialObject(){
        $obj = new self();
        $obj->title = ['en' => '', 'ar' => ''];
        return $obj;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function areas()
    {
        return $this->hasMany(City::class, 'parent_id');
    }

    public function scopeParent($query){
        return $query->where('parent_id', 0);
    }


}
