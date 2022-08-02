<?php


namespace App\Services;


use App\Models\Setting;

class SettingService
{

    public function save($settingKey, $settingValue, $id = 0)
    {
        try {
            $data = ['setting_key' => $settingKey, 'setting_value' => $settingValue];
            if($id > 0){
                $data = ['setting_value' => $settingValue];
            }
            return Setting::updateOrCreate(['id' => $id], $data);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
