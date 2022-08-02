<?php


namespace App\DTO;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class SaveCouponDTO extends DataTransferObject
{
    public array $name = ['en'=>'', 'ar'=>''];
    public string $coupon_code;
    public string $coupon_type;
    public int $end_date;
    public int $coupon_number;
    public int $discount;

    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromCollection(Collection $collection): self
    {
        $self = [
            'name' => $collection->get('name', ['en'=>'', 'ar'=>'']),
            'coupon_code' => $collection->get('coupon_code'),
            'discount' => (int)$collection->get('discount'),
            'coupon_type' => $collection->get('coupon_type'),
            'end_date' => Carbon::parse($collection->get('end_date', null))->timestamp,
        ];
        if($self['coupon_type'] == 'number'){
            $self['coupon_number'] = $collection->get('coupon_number');
        }else{
            $self['coupon_number'] = 0;
        }
//        dd($self);
        return new self($self);
    }
}
