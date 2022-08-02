<?php


namespace App\DTO;


use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class SaveAdDTO extends DataTransferObject
{
    public array $title = ['en'=>'', 'ar'=>''];
    public array $content = ['en'=>'', 'ar'=>''];
    public array $sub_title = ['en'=>'', 'ar'=>''];
    public string $image;
    public int $store_id;

    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromCollection(Collection $collection){
        $self = [
            'store_id' => $collection->get('store_id'),
            'title' => $collection->get('title'),
            'content' => $collection->get('content'),
            'sub_title' => $collection->get('sub_title'),
        ];
        if($collection->has('image')){
            if($collection->has('old_image') && $collection->get('image') !== $collection->get('old_image')){
                removeImage($collection->get('old_image'));
            }
            $self['image'] = moveImage($collection->get('image'), 'ads');
        }
        return new self($self);


    }
}
