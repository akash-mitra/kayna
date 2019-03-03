<?php

namespace App\Http\Controllers;

use Cache;
use App\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::table('parameters')->where('key', $key)->update(['value' => $value]);
        }

        return [
            "status" => "success",
            "message" => "Parameters updated"
        ];
    }
}
