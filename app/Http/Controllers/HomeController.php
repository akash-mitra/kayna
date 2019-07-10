<?php

namespace App\Http\Controllers;


use DB;

use App\Page;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Jobs\SendEmailJob;
use App\Mail\WelcomeOnboard;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with('category')->where('status', '=', 'Live')->orderBy('updated_at', 'desc')->paginate(10);

        $categories = Category::take(10)->get();

        return view('home', [
            "resource" => (object)[
                "pages" => $pages,
                "categories" => $categories
            ],
            "common" => (object)[
                "sitename" => param('sitename'),
                "sitetitle" => param('sitedesc'),
                "metadesc" => param('sitedesc'),
                "metakey" => ''
            ]
        ]);

    }


    public function dashboard()
    {
        if (param('installation') === '1') {
            if (empty(param('installation_done_till_step'))) {
                // return redirect()->route('installation', 1);
                //TODO 
                // Above we are skipping the first step of user creation
                // as the user has already been created in the 
                // current setup. Later on plan to use this step
                // for some other configuration purpose.

                return redirect()->route('installation', 2);
            } else {
                if (param('installation_done_till_step') === '1') {
                    return redirect()->route('installation', 2);
                } else {
                    return redirect()->route('installation', 3);
                }
            }
        }
        /**
         *----------------------------------------------------------------------------
         * This query calculates the cumulative sums of post and users growth over time
         * ----------------------------------------------------------------------------
         *
         * select d.dt as date, cast((sum(d.p) over(order by d.dt)) as unsigned) as pages, cast((sum(d.u) over(order by d.dt)) as unsigned) as users
         * from (
         *    select c.dt as dt, sum(c.p) over(order by c.dt) p, 0 as u
         *    from (
         *        select date(created_at) as dt, count(1) as p
         *        from pages
         *        group by date(created_at)
         *    ) c
         *    union all
         *    select c.dt as dt, 0 as p, sum(c.u) over(order by c.dt) u
         *    from (
         *        select date(created_at) as dt, count(1) as u
         *        from users
         *        group by date(created_at)
         *    ) c
         * ) d
         * group by d.dt;
         **/
        $sql = 'select x.dt as date, x.p as pages_added, sum(x.p) over(order by x.dt) as pages_total, x.u as users_added, sum(x.u) over(order by x.dt) as users_total from (select d.dt as dt, sum(d.p) as p, sum(d.u) as u from (select date(created_at) as dt, 1 as p, 0 as u from pages union all select date(created_at) as dt, 0 as p, 1 as u from users) d group by d.dt) x order by 1';

        $growth = DB::select(DB::raw($sql));

        $last7days = array_filter($growth, function ($perDay) {
            return \Carbon\Carbon::parse($perDay->date)->greaterThanOrEqualTo(now()->subDays(7));
        });

        $recentGrowth = array_reduce($last7days, function ($accumulator, $item) {
            $accumulator['pages'] += $item->pages_added;
            $accumulator['users'] += $item->users_added;

            return $accumulator;
        }, ['pages' => 0, 'users' => 0]);

        return view('admin.dashboard')->with('growth', $growth)->with('recentGrowth', $recentGrowth);
    }



    public function install($step)
    {
        return view('admin.installation.step' . $step);
    }

    public function installProcess($step, Request $request)
    {
        if (empty($step)) return abort(422, 'Invalid data');

        if ($step === '1') {
            $request->validate([
                'admin_name' => 'required|string',
                'admin_email' => 'required|email|confirmed|unique:users,email',
                'admin_password' => 'required|min:8',
            ]);

            // this is temporarily commented out as users are now being pre-created
            // DB::table('users')->insert([
            //     'name' => $request->input('admin_name'),
            //     'email' => $request->input('admin_email'),
            //     'type' => 'admin',
            //     'password' => bcrypt($request->input('admin_password')),
            //     'slug' => uniqid(mt_rand(0, 9999), true),
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]);

            set_param('installation_done_till_step', '1');

            return redirect()->route('installation', 2);
        }

        if ($step === '2') {

            $request->validate([
                'sitename' => 'required|string',
                'about' => 'required|max:255'
            ]);

            $loginEnable = $request->input('enable_registration') === "true" ? 'yes' : 'no';

            set_param('sitename', $request->input('sitename'));
            set_param('sitedesc', $request->input('about'));
            set_param('login_native_active', $loginEnable);
            set_param('installation_done_till_step', '2');

            // create a folder for storing user profile photos
            if(! Storage::disk('public')->exists('media/profile') ) {
                Storage::disk('public')->makeDirectory('media/profile');
            }

            return redirect()->route('installation', 3);
        }

        if ($step === '3') {
            // send email
            
            param('installation', '4');
            delete_param('installation_done_till_step');
            return redirect()->route('dashboard');
        }
    }


    /**
     * Shows a login form for the admin users
     */
    public function adminLogin()
    {
        return view('admin.login.form');
    }



    public function test (Request $request) 
    {
        
        
           
        // SendEmailJob::dispatch('akash.mitra@gmail.com', new WelcomeOnboard(), $parameters);
        SendEmailJob::dispatch(Auth::user()->email, new WelcomeOnboard(Auth::user()));    

        return 'mail queued';

    }
}
