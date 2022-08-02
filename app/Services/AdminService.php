<?php

namespace App\Services;

use App\DTO\SaveAdminProfileDTO;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminService
{
    /**
     * @throws \Exception
     */
    public function save(SaveAdminProfileDTO $params)
    {
        DB::beginTransaction();
        try {
            $paramsArray = $params->only('name', 'email')->toArray();
            if (!is_null($params->password) ) {
                $paramsArray['password'] = bcrypt($params->password);
            }
            if (!is_null($params->imageUrl) ) {
                $paramsArray['image'] = $params->imageUrl;
            }
            $admin = Admin::updateOrCreate(['id'=>$params->id],$paramsArray);
            DB::commit();
            return $admin;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
