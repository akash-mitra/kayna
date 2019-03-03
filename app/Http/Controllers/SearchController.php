<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $needle = $request->input('find');
        $type = $request->input('in');

        if (empty($type)) {
            $category_search = $this->getCategoryQueryBuilder($needle);
            $page_search = $this->getPageQueryBuilder($needle);
            
            return $category_search->unionAll($page_search)->get();
        }

        if ($type === 'category') {
            return $this->getCategoryQueryBuilder($needle)->get();
        }

        if ($type === 'page') {
            return $this->getPageQueryBuilder($needle)->get();
        }
    }


    private function getCategoryQueryBuilder($needle)
    {
        return DB::table('categories')
            ->selectRaw('"Category" as content_type, categories.id as content_id, categories.name as content_title')
            ->where('name', 'like', '%' . $needle . '%');
    }

    private function getPageQueryBuilder($needle)
    {
        return DB::table('pages')
            ->selectRaw('"Page" as content_type, pages.id as content_id, pages.title as content_title')
            ->where('title', 'like', '%' . $needle . '%');
    }
}
