<?php


namespace App\DTO;


use App\Http\Requests\SaveCityAreaRequest;
use App\Http\Requests\SaveStoreRequest;
use App\Http\Requests\SaveUserRequest;
use Spatie\DataTransferObject\DataTransferObject;

class SaveStoreDTO extends DataTransferObject
{
    public string $user_type = 'store';
    public array $store_name = ['en' => '', 'ar' => ''];
    public array $detail = ['en' => '', 'ar' => ''];
    public int $city_id;
    public string $email;
    public string $phone;
    public ?string $password;
    public string $address;
    public float $latitude;
    public float $longitude;
    public int $is_active = 1;
    public int $email_verified = 1;
    public $trade_license_verified = null;
    public ?string $image = null;
    public ?string $trade_license = null;


    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromRequest(SaveStoreRequest $params): self
    {
        $self = collect([
            'store_name' => $params->get('store_name', ['en' => '', 'ar' => '']),
            'detail' => $params->get('detail', ['en' => '', 'ar' => '']),
            'email' => $params->input('email'),
            'phone' => $params->input('phone'),
            'address' => $params->input('address'),
            'latitude' => $params->input('latitude'),
            'longitude' => $params->input('longitude'),
            'is_active' => (int)(!($params->get('is_active', 0) == 0)),
            'email_verified' => (int)(!($params->get('email_verified', 0) == 0)),
            'trade_license_verified' => (int)(!($params->get('trade_license_verified', 0) == 0)),
            'city_id' => $params->input('city_id'),
        ]);
        if ($params->filled('password')){
             $self->put('password', bcrypt($params->get('password')));
        }
        if ($params->filled('image')){
            $self->put('image', $params->get('image'));
        }
        if ($params->filled('trade_license')){
             $self->put('trade_license', $params->get('trade_license'));
        }
        return new self($self->toArray());

    }

}
