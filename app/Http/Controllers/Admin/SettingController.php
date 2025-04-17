<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Setting;
use Auth;
use Storage;

class SettingController extends Controller
{
    public function site()
    {
        $page_title = 'Site Settings';
        return view('admin/setting/site', compact('page_title'));
    }

    public function account()
    {
        $page_title = 'Account Settings';
        return view('admin/setting/account', compact('page_title'));
    }

    public function dcMaster()
    {
        $page_title = 'DC Master Settings';
        return view('admin/setting/dc_master', compact('page_title'));
    }

    public function passwordUpdate()
    {
        $page_title = 'Password Change';
        return view('admin/setting/password', compact('page_title'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_name' => 'required|in:account,dc_master,password,site',
            'pl_start_no' => 'required_if:form_name,dc_master',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'location' => 'required_if:form_name,account|string|min:3|max:3',
            'old_password' => ['required_if:form_name,password', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('The old password does not match our records.');
                    }
                }],
            'password' => 'required_if:form_name,password|min:6',
            'confirm_password' => 'required_if:form_name,password|same:password',
        ]);

        if ($validator->fails()) {
            // return self::sentResponse(422, [], $validator->messages());
            if($request->form_name == 'dc_master') {
                return redirect()->route('admin.setting.dc-master')->with('error', $validator->messages()->first());
            } else if($request->form_name == 'site') {
                return redirect()->route('admin.setting.site')->with('error', $validator->messages()->first());
            } else if($request->form_name == 'password') {
                return redirect()->route('admin.setting.password')->with('error', $validator->messages()->first());
            } else {
                return redirect()->route('admin.setting.account')->with('error', $validator->messages()->first());
            }
        }

        $auth = Auth::user();
        $settingArray = [];

        if($request->form_name == 'dc_master') {

            $settingArray['pl_start_no'] = $request->pl_start_no;

        } else if($request->form_name == 'site') {

            $settingArray['site_name'] = $request->site_name;
            $settingArray['report_email'] = $request->report_email;

            $settingArray['email_driver'] = $request->email_driver;
            $settingArray['email_host'] = $request->email_host;
            $settingArray['email_port'] = $request->email_port;
            $settingArray['email_encryption'] = $request->email_encryption;
            $settingArray['email_username'] = $request->email_username;
            $settingArray['email_password'] = $request->email_password;

            if ($request->hasFile('site_logo')) {

                if(!blank(setting('site_logo'))) {
                    Storage::disk('public')->delete(setting('site_logo'));
                }
                $path = $request->file('site_logo')->store('logos', 'public');
                $settingArray['site_logo'] = $path;
            }

        } else if($request->form_name == 'password') {

            $auth->password = $request->password;
            $auth->save();

        } else {

            if(!blank($request->first_name)) {
                $auth->first_name = $request->first_name;
            }

            if(!blank($request->last_name)) {
                $auth->last_name = $request->last_name;
            }

            if(!blank($request->email)) {
                $auth->email = $request->email;
            }

            if(!blank($request->country_code)) {
                $auth->country_code = $request->country_code;
            }

            if(!blank($request->mobile)) {
                $auth->mobile = $request->mobile;
            }

            if(!blank($request->address)) {
                $auth->address = $request->address;
            }

            if(!blank($request->location)) {
                $auth->location = strtoupper($request->location);
            }

            if ($request->hasFile('profile_image')) {

                if(!blank($auth->profile_image)) {
                    Storage::disk('public')->delete($auth->profile_image);
                }
                $path = $request->file('profile_image')->store('profile_images', 'public');
                $auth->profile_image = $path;
            }

            $auth->save();
        }
        
        if(!blank($settingArray)) {

            Setting::set($settingArray);
            Setting::save();
        }

        if($request->form_name == 'dc_master') {
            return redirect()->route('admin.setting.dc-master')->with('success', 'DC Master settings updated successfully!');
        } else if($request->form_name == 'site') {
            return redirect()->route('admin.setting.site')->with('success', 'Site settings updated successfully!');
        } else if($request->form_name == 'password') {
            return redirect()->route('admin.setting.password')->with('success', 'Password updated successfully!');
        } else {
            return redirect()->route('admin.setting.account')->with('success', 'Account settings updated successfully!');
        }
    }
}
