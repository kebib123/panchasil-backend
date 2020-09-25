<?php

namespace App;
use App\Model\Setting;
use Illuminate\Support\Facades\File;

trait Settings
{
    public function save_settings($request)
    {
        $onlykeys = $request->only(
            ['site_description', 'site_title', 'site_primary_email', 'site_secondary_email', 'site_primary_phone','site_address', 'site_editor','editor_contact','registration_number','facebook_link','twitter_link',]);
        if ($request->hasfile('site_logo')) {
            $this->delete_site_logo();
            $image = $request->file('site_logo');
            $ext = time() . '.' . $image->getClientOriginalExtension();
            if (!File::isDirectory(public_path('images/settings/'))) {
                $makedirectory = File::makeDirectory(public_path('images/settings/'));
            }
            $destinationPath = public_path('images/settings/');
//            $makefile = Image::make($image);
//            $save = $makefile->resize(1200, 418, function ($ar) {
//                $ar->aspectRatio();
//            })->save($destinationPath . '/' . $ext);
            $image->move($destinationPath, $ext);
            $updateorcreate = Setting::updateorcreate(['configuration_key' => 'site_logo'], ['configuration_value' => $ext]);
        } else {
            foreach ($onlykeys as $key => $value) {

                $updateorcreate = Setting::updateorcreate(['configuration_key' => $key], ['configuration_value' => $value]);

            }
        }
        return true;
    }

    public function delete_site_logo()
    {
        $filecheck = Setting::where('configuration_key', 'site_favicon')->first();
        if ($filecheck == null) {
            return true;
        }
        $filename = $filecheck->configuration_value;
        $filepath = public_path('images/settings/' . $filename);
        if (file_exists($filepath) && is_file($filepath)) {
            unlink($filepath);
        }
        return true;


    }
    function getConfiguration($key)
    {
        $config = Setting::where('configuration_key', '=', $key)->first();
        if ($config != null) {
            return $config->configuration_value;
        }

        return null;
    }
}
