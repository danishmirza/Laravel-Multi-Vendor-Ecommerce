<?php


namespace App\DTO;


use App\Http\Requests\SaveServiceRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class SaveServiceDTO extends DataTransferObject
{
    public array $title = ['en'=>'', 'ar'=>''];
    public array $content = ['en'=>'', 'ar'=>''];
    public ?string $image = null;
    public ?int $store_id = null;
    public int $price = 0;
    public int $category_id;
    public int $subcategory_id;
    public int $has_offer = 0;
    public int $is_active = 1;
    public ?int $discount_percentage = null;
    public ?int $discount_expiry_date = null;
    public ?int $package_id = null;

    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromRequest(SaveServiceRequest $params): self
    {
        $subcategory = Category::where('id', $params->input('subcategory_id'))->with('category')->first();
        $self = [
            'title' => $params->input('title', ['en'=>'', 'ar'=>'']),
            'content' => $params->input('content', ['en'=>'', 'ar'=>'']),
            'price' => $params->input('price', 0),
            'category_id' => $subcategory->category->id,
            'subcategory_id' => $params->input('subcategory_id', 0),
            'has_offer' => $params->input('has_offer', null),
            'image' => $params->filled('image')? $params->input('image') : null,
        ];
        if($self['has_offer']){
            $self['discount_percentage'] = $params->get('discount_percentage');
            $self['discount_expiry_date'] = Carbon::parse($params->get('discount_expiry_date', null))->timestamp;
        }else{
            $self['discount_percentage'] = 0;
            $self['discount_expiry_date'] = 0;
        }
        return new self($self);
    }

    public static function fromCollection(Collection $collection){
        $subcategory = Category::where('id', $collection->get('subcategory_id'))->with('category')->firstOrFail();
        $self = [
          'store_id' => $collection->get('store_id'),
          'title' => $collection->get('title'),
          'content' => $collection->get('content'),
          'price' => $collection->get('price'),
          'category_id' => $subcategory->category->id,
          'subcategory_id' => $collection->get('subcategory_id'),
          'has_offer' => $collection->get('has_offer', 0),
        ];
        if($self['has_offer']){
            $self['discount_percentage'] = $collection->get('discount_percentage');
            $self['discount_expiry_date'] = Carbon::parse($collection->get('discount_expiry_date', null))->timestamp;
        }else{
            $self['discount_percentage'] = 0;
            $self['discount_expiry_date'] = 0;
        }
        if($collection->has('image') && !is_null($collection->get('image'))){
            if($collection->has('old_image') && $collection->get('image') != $collection->get('old_image')){
                removeImage($collection->get('old_image'));
            }
            $self['image'] = moveImage($collection->get('image'), 'services');
        }
        if($collection->has('package_id')){
            $self['package_id'] = $collection->get('package_id');
        }

        return new self($self);


    }
}
