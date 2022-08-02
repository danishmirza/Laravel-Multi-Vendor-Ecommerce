<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $dateFormat = 'U';

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'store_id' => 'int',
    ];

    protected $fillable = [
        'store_id', 'image'
    ];
}
