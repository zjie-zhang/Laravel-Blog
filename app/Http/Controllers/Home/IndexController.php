<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Requests;

class IndexController extends CommonController
{
    //
    public function index(){
        // 图文列表-5篇
        $art_lst_arr = Article::orderBy('id','desc')->paginate(5);
        
        // 友情链接
        $links_arr = Links::orderBy('link_order','desc')->get();
        
        return view('home.index',compact('art_hot_arr','art_lst_arr','art_new_arr','links_arr'));
    }

    public function cate($cate_id){
        // 分类信息
        $cate_info = Category::find($cate_id);
        // 子分类
        $cate_child = Category::where('cate_pid',$cate_id)->get();
        // 当前分类文章-4篇
        $art_lst_arr = Article::where('cat_id',$cate_id)->paginate(4);

        // 查看自增1
        Category::where('id',$cate_id)->increment('cate_view',1);

        return view('home.list',compact('cate_info','cate_child','art_lst_arr'));
    }

    public function art($art_id){
        // 获取当前ID文章信息
//        $art_info = Article::Join('category','article.cat_id','=','category.id')->find($art_id);
        $art_info = Article::Join('category','article.cat_id','=','category.id')->where('article.id',$art_id)->first();

        // 查看自增1
        Article::where('id',$art_id)->increment('art_view',1);

        //上一篇，下一篇
        $art_arr['pre'] = Article::where('id','<',$art_id)->orderBy('id','desc')->first();
        $art_arr['nex'] = Article::where('id','>',$art_id)->orderBy('id','asc')->first();

        // 相关文章
        $relevant_art = Article::where('cat_id',$art_info->cat_id)->orderBy('id','desc')->take(6)->get();
//        dd($relevant_art);
        return view('home.art',compact('art_info','art_arr','relevant_art'));
    }
}
