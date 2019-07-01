<?php

namespace App\Http\Controllers;

use App\Page;


class FeedController extends Controller
{

    /**
     * Display a feed in specific format
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = 'RSS')
    {
        switch (strtoupper($type)) {
            case 'RSS': return $this->rssFeed();
            case 'ATOM': return $this->atomFeed();
            case 'SITEMAP': return $this->siteMapFeed();
            default: return $this->rssFeed();
        }
    }



    /**
     * Invokes the view for rss feed
     */
    private function rssFeed() {
        return response()->view('feeds.rss', $this->getFeedData())->header('Content-Type', 'text/xml');
    }


    /**
     * Invokes the view for sitemap
     */
    private function siteMapFeed() {
        
        return response()
            ->view('feeds.sitemap', $this->getFeedData())
            ->header('Content-Type', 'text/xml');
    }


    /**
     * Invokes the view for atom feed
     */
    private function atomFeed() {
        return view('feeds.atom', $this->getFeedData());
    }



    /**
     * A handy function to provide the relevant data
     */
    private function getFeedData ()
    {
        return [
            'site' => [
                'name' => param('sitename'),
                'url' => url('/'),
                'description' => param('sitedesc'),
                'language' => 'en-US',
                'lastBuildDate' => now(),
            ],
            'pages' => Page::where('status', 'Live')->get()
        ];
    }
}
