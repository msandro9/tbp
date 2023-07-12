<?php

namespace App\Helper;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class Helper
{
    public static function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        $route = '/' . Route::current()->uri;
        $paginated = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        $paginated->setPath($route);

        return $paginated;
    }

    public static function formatAddressToArray($string)
    {
        $string = trim($string, '()');
        $array = explode(',', $string);
        $array = array_map(function ($s) {
            $s = str_replace('"', '', $s);
            $s = trim($s);
            return $s;
        }, $array);

        return implode(', ', $array);
    }
}
