<?php


namespace App\Models;


use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes, Sluggable;
    protected $dateFormat = 'U';

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
    ];

    protected $fillable = [
        'title', 'content', 'image', 'slug', 'price', 'category_id', 'subcategory_id', 'has_offer',
        'discount_percentage', 'discount_expiry_date', 'store_id', 'package_id', 'package_expire_on'
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
        $obj = new self();
        $obj->title = ['en' => '', 'ar' => ''];
        $obj->content = ['en' => '', 'ar' => ''];
        return $obj;
    }

    public function getDiscountExpiryDateAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function getPackageExpireOnAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory(){
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function store(){
        return $this->belongsTo(User::class, 'store_id');
    }

    public function featured(){
        return !is_null($this->package_id);
    }

    public function serviceReview(){
        return $this->hasOne(ServiceReview::class, 'service_id');
    }


}
