<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    public function index()
    {
        
        $setting = Setting::find(1);
        //dd($setting->monthly);
        return view('user.setting', compact('setting'));
    }

    public function show($request)
    {
        $settingID = $request->id;
        $setting = Setting::find($settingID);
        // dd($user);
        return view('user.setting', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $form_data = array(
            'daily'            =>   $request->daily,
            'monthly'          =>   $request->monthly,    
        );
        //dd($form_data);
        $setting= Setting::find($id)->update($form_data);
        return redirect()->route('list_setting');
    }
}
