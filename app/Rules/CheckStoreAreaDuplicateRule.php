<?php

namespace App\Rules;

use App\Models\StoreArea;
use Illuminate\Contracts\Validation\Rule;

class CheckStoreAreaDuplicateRule implements Rule
{
    private int $skipId = 0;
    private int $storeId = 0;
    public function __construct($skipId, $storeId)
    {
        $this->skipId = $skipId;
        $this->storeId = $storeId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $query = StoreArea::where($attribute, $value)->where('store_id', $this->storeId);
        if($this->skipId > 0){
            $query->where('id', '!=', $this->skipId);
        }
        $data = $query->first();
        if($data){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Selected area is already in delivery area list');
    }
}
