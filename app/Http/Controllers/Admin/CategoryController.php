<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    // get - admin/category  列表
    public function index(){
        $cate_model = new Category();
        $tree_arr = $cate_model->getCategorys();
        return view('admin.category.index')->with('data',$tree_arr);
    }

    // 分类ajax排序
    public function changeOrder(){
        $cate_model = new Category();
        $input = Input::all();
        $id = $input['id'];
        $cate_order = $input['cate_order'];
        $cate_rs = $cate_model->where('id', $id)->update(['cate_order' => $cate_order]);
        if($cate_rs){
            $data = ['num'=>0,'msg'=>'更新成功'];
        }else{
            $data = ['num'=>-1,'msg'=>'更新失败'];
        }
        return $data;
    }

    // post - admin/category
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'cate_name'=>'required',
            'cate_title'=>'required|between:0,255',
            'cate_description'=>'required|between:0,255',
            'cate_keywords'=>'required|between:0,255',
        ];
        $message = [
            'cate_name.required'=>'分类名称不能为空',
            'cate_name.between'=>'分类名称不能超过255',
            'cate_title.required'=>'分类标题不能为空',
            'cate_title.between'=>'分类标题不能超过255',
            'cate_description.required'=>'分类描述不能为空',
            'cate_keywords.required'=>'分类关键词不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->passes()){
//            Category::create($input);
            $cate_model = new Category();
            if($cate_model->insert($input)){
                return redirect('admin/category');
            }else{
                return back()->with('errors','添加失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    // get - admin/category/create 添加分类
    public function create(){
        $cate_model = new Category();
        $tree_arr = $cate_model->getCategorys();
        return view('admin.category.add')->with('data',$tree_arr);
    }

    // get - admin/category/{category}
    public function show(){
        $cate_model = new Category();
        $tree_arr = $cate_model->getCategorys();
        return view('admin.category.add')->with('data',$tree_arr);
    }

    // delete - admin/category/{category}
    public function destroy($cate_id){
        $cate_model = new Category();
        $categorys = $cate_model->orderBy('id','asc')->get();
        $child_arr = $cate_model->getChilds($categorys,$cate_id);
        if(count($child_arr)>0){
            $data = ['num'=>-2,'msg'=>'当前分类下有子分类未删除，请先删除其子分类'];
        }else{
            if($re = $cate_model->where(['id'=>$cate_id])->delete()){
                $data = ['num'=>0,'msg'=>'删除成功'];
            }else{
                $data = ['num'=>-1,'msg'=>'删除失败'];
            }
        }
        return $data;
    }

    // PUT|PATCH - admin/category/{category}
    public function update($cate_id){
        $info = Input::except('_token','_method');
        $rs = Category::where('id',$cate_id)->update($info);
        if($rs){
            return redirect('admin/category');
        }else{
            return back()->with('errors','更新失败');
        }
    }

    // get - admin/category/{category}/edit
    public function edit($cate_id){
        $cate_model = new Category();
        $data = $cate_model->getCategorys();
        $info = Category::find($cate_id);
        return view('admin.category.edit',compact('info','data'));
    }
}
