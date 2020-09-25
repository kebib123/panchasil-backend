<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings;

class SettingController extends Controller
{
    use Settings;

    public function setting(Request $request)
    {
        if ($request->isMethod('get')) {
            $data['site_title'] = $this->getConfiguration('site_title');
            $data['site_description'] = $this->getConfiguration('site_description');
            $data['site_primary_email'] = $this->getConfiguration('site_primary_email');
            $data['site_secondary_email'] = $this->getConfiguration('site_secondary_email');
            $data['site_primary_phone'] = $this->getConfiguration('site_primary_phone');
            $data['site_address'] = $this->getConfiguration('site_address');
            $data['site_editor'] = $this->getConfiguration('site_editor');
            $data['registration_number'] = $this->getConfiguration('registration_number');
            $data['editor_contact'] = $this->getConfiguration('editor_contact');
            $data['facebook_link'] = $this->getConfiguration('facebook_link');
            $data['twitter_link'] = $this->getConfiguration('twitter_link');
            return response()->json($data);
        }
        if ($request->isMethod('post')) {
            $save = $this->save_settings($request);
            if ($save) {
                return response()->json(['status' => 'success', 'message' => 'Settings Saved Successfully']);
            }
        }
        return false;
    }

}
