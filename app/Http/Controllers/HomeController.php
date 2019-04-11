<?php

namespace App\Http\Controllers;

use DB;
use App\Page;
use App\Category;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with('category')->orderBy('updated_at', 'desc')->paginate(5);
        $data['pages'] = $pages->toArray();

        $categories = Category::take(10)->get();
        $data['categories'] = $categories->toArray();

        $data['common'] = [
            "sitename" => "Kayna",
            "sitetitle" => "A BlogTheory site",
            "metadesc" => "A friendly website",
            "metakey" => ""
        ];
        // return $data;
        return compiledView('home', $data);
    }

    public function dashboard()
    {
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
}
