<?php


namespace App\Services;


use App\DTO\SavePageDTO;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class PageService
{

    public function save(SavePageDTO $params)
    {
        DB::beginTransaction();
        try {
            $data = $params->except('id', 'image', 'icon')->toArray();
            if (!is_null($params->image)) {
                $data['image'] = $params->image;
            }
            if (!is_null($params->icon)) {
                $data['icon'] = $params->icon;
            }
            $page = Page::updateOrCreate(['id' => $params->id], $data);
            DB::commit();
            return $page;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getAboutUs(){
        return Page::whereIn('slug', [
            config('project_settings.about_us_slug'),
            config('project_settings.mission_and_vision')
        ])->orderBy('slug', 'asc')->get();
    }
}
