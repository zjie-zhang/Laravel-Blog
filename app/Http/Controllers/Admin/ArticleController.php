<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    // get - admin/article  列表
    public function index(){
        $data = Article::orderBy('id','desc')->paginate(10);
        return view('admin.article.index',compact('data'));
    }

    // get - admin/article/create 添加文章
    public function create(){
        $cate_model = new Category();
        $data = $cate_model->getCategorys();
        return view('admin.article.add')->with('data',$data);
    }

    // post - admin/category
    public function store(){
        $input = Input::except('_token');
        $input['art_time'] = time();
        $rules = [
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'文章标题不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->passes()){
           $re =  Article::create($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','添加失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    // get - admin/article/{article}/edit
    public function edit($art_id){
        $cate_model = new Category();
        $data = $cate_model->getCategorys();
        $info = Article::find($art_id);
        return view('admin.article.edit',compact('data','info'));
    }

    // PUT|PATCH - admin/article/{article}
    public function update($art_id){
        $info = Input::except('_token','_method');
        $rs = Article::where('id',$art_id)->update($info);
        if($rs){
            return redirect('admin/article');
        }else{
            return back()->with('errors','更新失败');
        }
    }

    // delete - admin/article/{article}
    public function destroy($art_id){
        if($re = Article::where(['id'=>$art_id])->delete()){
            $data = ['num'=>0,'msg'=>'删除成功'];
        }else{
            $data = ['num'=>-1,'msg'=>'删除失败'];
        }
        return $data;
    }


}
