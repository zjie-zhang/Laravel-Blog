<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    //index
    public function index(){
        $data = Navs::all();
        return view('admin.navs.index')->with('data',$data);
    }

    // 分类ajax排序
    public function changeOrder(){
        $model = new Navs();
        $input = Input::all();
        $id = $input['id'];
        $order = $input['navs_order'];
        $links_rs = $model->where('id', $id)->update(['navs_order' => $order]);
        if($links_rs){
            $data = ['num'=>0,'msg'=>'更新成功'];
        }else{
            $data = ['num'=>-1,'msg'=>'更新失败'];
        }
        return $data;
    }

    // get - admin/links/create 添加链接
    public function create(){
        return view('admin.navs.add');
    }


    // post - admin/links
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'navs_name'=>'required',
            'navs_url'=>'required',
        ];
        $message = [
            'navs_name.required'=>'链接名称不能为空',
            'navs_url.required'=>'链接不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $model = new Navs();
            if($model->insert($input)){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','添加失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    // get - admin/links/{links}/edit   修改
    public function edit($navs_id){
        $info = Navs::find($navs_id);
        return view('admin.navs.edit')->with('info',$info);
    }

    // 更新
    public function update($navs_id){
        $input = Input::except('_token','_method');
        $res = DB::table('navs')->where('id',$navs_id)->update($input);
        if($res){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','更新失败');
        }
    }

    public function destroy($navs_id){
        if($re = Navs::where(['id'=>$navs_id])->delete()){
            $data = ['num'=>0,'msg'=>'删除成功'];
        }else{
            $data = ['num'=>-1,'msg'=>'删除失败'];
        }
        return $data;
    }



}
