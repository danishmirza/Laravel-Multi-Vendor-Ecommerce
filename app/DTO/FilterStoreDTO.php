<?php


namespace App\DTO;


use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class FilterStoreDTO extends DataTransferObject
{
    public ?string $keyword = null;
    public ?array $subcategories = [];
    public ?float $latitude = 0;
    public ?float $longitude = 0;
    public ?int $areaId = 0;


    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromCollection(Collection $collection){
        $self = [];
        $self['keyword'] = $collection->get('keyword', null);
        $self['subcategories'] = $collection->get('subcategory_id', []);
        $self['latitude'] = (double)$collection->get('latitude', 0);
        $self['longitude'] =(double) $collection->get('longitude', 0);
        $self['areaId'] =(int) $collection->get('area_id', 0);
        return new self($self);
    }
}
