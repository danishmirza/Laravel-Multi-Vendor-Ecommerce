<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Requests\AdminStoreSettingRequest;
use App\Http\Requests\SaveSettingRequest;
use App\Services\DatatableService;
use App\Services\SettingService;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.settings.index');
    }

    public function all(DatatableService $datatableService){
        $settings = $datatableService->settingsDatatable();
        return response($settings);
    }

    public function create() {
        return view('admin.dashboard.settings.edit', [
            'method' => 'PUT',
            'settingId' => 0,
            'action' => route('admin.dashboard.settings.update', 0),
            'heading' => 'Add Setting',
            'setting' => new Setting()
        ]);
    }

    public function edit(Setting $setting) {
        return view('admin.dashboard.settings.edit', [
            'method' => 'PUT',
            'settingId' => $setting->id,
            'action' => route('admin.dashboard.settings.update', $setting->id),
            'heading' => 'Update Setting',
            'setting' => $setting
        ]);
    }

    public function update(SaveSettingRequest $request, $id, SettingService $pageService) {
        try {
            $pageService->save($request->get('setting_key'), $request->get('setting_value'), $id);
            return redirect(route('admin.dashboard.settings.index'))->with('status', ($id == 0) ? 'Setting added successfully.': 'Setting updated successfully.');
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }

    public function destroy(Setting $setting) {
        try {
            $setting->delete();
            return response(['msg' => 'Setting deleted']);
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }
}
