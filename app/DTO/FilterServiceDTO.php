<?php


namespace App\DTO;


use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class FilterServiceDTO extends DataTransferObject
{
    public ?bool $is_featured = null;
    public ?bool $is_offered = null;
    public ?int $store_id = null;
    public ?float $max_price = null;
    public ?float $min_price = null;
    public ?string $keyword = null;
    public ?int $category_id = null;
    public ?int $subcategory_id = null;
    public ?int $areaId = null;
    public ?array $subcategories = [];



    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromCollection(Collection $collection){
        $self = [];
        if($collection->has('store_id')){
            $self['store_id'] = $collection->get('store_id', null);
        }
        if($collection->has('is_offered')){
            $self['is_offered'] = 1;
        }
        if($collection->has('is_featured')){
            $self['is_featured'] = 1;
        }
        $self['keyword'] = $collection->get('keyword', null);
        $self['category_id'] = $collection->get('category_id', null);
        $self['subcategory_id'] = $collection->get('subcategory_id', null);
        $self['min_price'] = $collection->get('min_price', null);
        $self['max_price'] = $collection->get('max_price', null);
        $self['areaId'] = $collection->get('area_id', null);
        $self['subcategories'] = array_filter($collection->get('subcategories', []), function($v) { return !is_null($v);});
       ;
        return new self($self);
    }
}
