<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    // 列表
    public function index(){
        $data = Links::orderBy('link_order','DESC')->get();
        return view('admin.links.index',compact('data'));
    }

    // 分类ajax排序
    public function changeOrder(){
        $links_model = new Links();
        $input = Input::all();
        $id = $input['id'];
        $link_order = $input['link_order'];
        $links_rs = $links_model->where('id', $id)->update(['link_order' => $link_order]);
        if($links_rs){
            $data = ['num'=>0,'msg'=>'更新成功'];
        }else{
            $data = ['num'=>-1,'msg'=>'更新失败'];
        }
        return $data;
    }

    // get - admin/links/create 添加链接
    public function create(){
        return view('admin.links.add');
    }


    // post - admin/links
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required',
            'link_url'=>'required',
        ];
        $message = [
            'link_name.required'=>'链接名称不能为空',
            'link_url.required'=>'链接不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $lnik_model = new Links();
            if($lnik_model->insert($input)){
                return redirect('admin/links');
            }else{
                return back()->with('errors','添加失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    // get - admin/links/{links}/edit   修改
    public function edit($link_id){
        $info = Links::find($link_id);
        return view('admin.links.edit')->with('info',$info);
    }

    // 更新
    public function update($link_id){
        $input = Input::except('_token','_method');
        $res = DB::table('links')->where('id',$link_id)->update($input);
        if($res){
            return redirect('admin/links');
        }else{
            return back()->with('errors','更新失败');
        }
    }

    public function destroy($link_id){
        if($re = Links::where(['id'=>$link_id])->delete()){
            $data = ['num'=>0,'msg'=>'删除成功'];
        }else{
            $data = ['num'=>-1,'msg'=>'删除失败'];
        }
        return $data;
    }

}
