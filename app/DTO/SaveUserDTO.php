<?php


namespace App\DTO;


use App\Http\Requests\SaveCityAreaRequest;
use App\Http\Requests\SaveUserRequest;
use Spatie\DataTransferObject\DataTransferObject;

class SaveUserDTO extends DataTransferObject
{
    public string $user_type = 'user';
    public string $name;
    public string $email;
    public string $phone;
    public ?string $password;
    public string $address;
    public float $latitude;
    public float $longitude;
    public bool $is_active = true;
    public bool $email_verified = true;
    public ?string $image = null;


    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromRequest(SaveUserRequest $params): self
    {
        $self = collect([
            'name' => $params->input('name'),
            'email' => $params->input('email'),
            'phone' => $params->input('phone'),
            'address' => $params->input('address'),
            'latitude' => $params->input('latitude'),
            'longitude' => $params->input('longitude'),
            'is_active' => $params->input('is_active'),
            'email_verified' => $params->input('email_verified'),
        ]);
        if ($params->filled('password')){
            $self = $self->put('password', bcrypt($params->get('password')));
        }
        if ($params->filled('image')){
            $self = $self->put('image', $params->get('image'));
        }
        return new self($self->toArray());

    }

}
