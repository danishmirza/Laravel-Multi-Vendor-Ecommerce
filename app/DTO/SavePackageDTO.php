<?php


namespace App\DTO;


use App\Http\Requests\SavePackageRequest;
use Spatie\DataTransferObject\DataTransferObject;

class SavePackageDTO extends DataTransferObject
{
    public int $id = 0;
    public array $title = ['en'=>'', 'ar'=>''];
    public array $description = ['en'=>'', 'ar'=>''];
    public int $duration;
    public string $duration_type;
    public string $package_type;
    public int $is_free;
    public int $price;
    public int $total_days;

    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromRequest(SavePackageRequest $params): self
    {
        $self = [
            'title' => $params->input('title', ['en'=>'', 'ar'=>'']),
            'description' => $params->input('description', ['en'=>'', 'ar'=>'']),
            'duration' => $params->input('duration', 0),
            'duration_type' => $params->input('duration_type', 'days'),
            'package_type' => $params->input('package_type', 'subscription'),
            'is_free' => $params->input('is_free', 0),
            'price' => ($params->filled('price')) ? $params->input('price', 0) : 0,
            'total_days' => $params->input('duration', 0)

        ];
        if($self['is_free'] == 1){
            $self['price'] = 0;
        }
        if($self['duration_type'] == 'months'){
            $self['total_days'] = $self['total_days'] * 30;
        }
        if($self['duration_type'] == 'years'){
            $self['total_days'] = $self['total_days'] * 365;
        }
        return new self($self);
    }
}
