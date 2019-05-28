<?php

namespace App\Http\Controllers;

use Cache;
use App\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{

    private $registeredParameters = ['login_facebook_app_secret'];

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $settings = Parameter::getObject();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->input() as $key => $value) {
            Cache::forget($key);
            DB::table('parameters')->where('key', $key)->update([
                'value' => $value===null ? '' : $value
            ]);
        }

        return [
            "status" => "success",
            "message" => "Parameters updated"
        ];
    }


    public function clearAppCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        session()->flash('message', 'Application Cache has been cleared!');
        return back();
    }
}
