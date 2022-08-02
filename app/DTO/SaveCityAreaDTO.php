<?php


namespace App\DTO;


use App\Http\Requests\SaveCityAreaRequest;
use Spatie\DataTransferObject\DataTransferObject;

class SaveCityAreaDTO extends DataTransferObject
{
    public int $id = 0;
    public array $title = ['en'=>'', 'ar'=>''];
    public ?string $polygon = '';
    public ?string $address;
    public ?int $latitude =0;
    public ?int $longitude = 0;

    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromRequest(SaveCityAreaRequest $params): self
    {
        $self = collect([
            'title' => $params->input('title', ['en'=>'', 'ar'=>'']),
            'address' => $params->input('address', null),
            'polygon' => $params->input('polygon',  null),
            'latitude' => $params->input('latitude', 0),
            'longitude' => $params->input('longitude', 0)
        ]);
        return new self($self->toArray());
    }
}
