<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    // 导航栏
    public function __construct()
    {
        $navs_model = new Navs();
        $navs_arr = $navs_model->orderBy('navs_order','desc')->get();

        // 推荐-6篇
        $art_hot_arr = Article::orderBy('art_view','desc')->take(6)->get();
        // 最新发布-8篇
        $art_new_arr = Article::orderBy('art_time','desc')->take(8)->get();


        View::share('navs',$navs_arr);
        View::share('art_hot_arr',$art_hot_arr);
        View::share('art_new_arr',$art_new_arr);
    }
}
