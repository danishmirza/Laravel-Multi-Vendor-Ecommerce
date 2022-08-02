<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreArea  extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    public $table = 'stores_areas';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];

    protected $fillable = [
        'area_id',
        'store_id',
        'price'
    ];

    public function area(){
        return $this->belongsTo(City::class, 'area_id');
    }
}
