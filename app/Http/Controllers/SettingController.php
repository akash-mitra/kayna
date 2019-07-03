<?php

namespace App\Http\Controllers;

use Cache;
use App\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $settings = Parameter::getObject();

        return view('admin.settings.index', compact('settings'));
    }


    /**
     * Updates the value of a key in the parameter table.
     */
    public function update(Request $request)
    {
        foreach ($request->input() as $key => $value) {
            
            Cache::forget($key);

            $value = Parameter::checkForEncryption($key, $value);

            DB::table('parameters')->where('key', $key)->update([
                'value' => alt ($value, '')
            ]);
        }

        return [
            "status" => "success",
            "message" => "Parameters updated"
        ];
    }


    /**
     * Clears caches and configs
     */
    public function clearAppCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        session()->flash('message', 'Application Cache has been cleared!');
        return back();
    }


    /**
     * Updates the blog application with the latest version.
     */
    public function appUpdate ()
    {
        Artisan::call('blog:update');

        session()->flash('message', 'Application has been updated to the latest version!');

        return back();
    }
}
