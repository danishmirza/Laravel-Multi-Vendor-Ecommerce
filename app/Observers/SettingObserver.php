<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingObserver
{
    public function saved(Setting $setting)
    {
        $settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        $parsable_string = var_export($settings, true);
        $content = "<?php return {$parsable_string};";
        File::put(config_path('project_settings.php'), $content);
    }
}
