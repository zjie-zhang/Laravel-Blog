<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class IndexController extends CommonController
{
    //
    public function index(){
//        $pdo = DB::conection()->getPdo();
//        dd($pdo);
//        dd($_SERVER);
//        dd(session('user'));
        return view('admin/index');
    }

    public function info(){
        return view('admin.info');
    }

    //更改密码
    public function pass(){
        if($input = Input::all()){
            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];
            $message = [
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码必须是6-20位',
                'password.confirmed'=>'两次密码不一致',
            ];
            $validator =  Validator::make($input,$rules,$message);
            if($validator->passes()){
                $user = User::first();
                $user_pwd = Crypt::decrypt($user->user_pwd);
                if($user_pwd == $input['password_o']){
                    $user->user_pwd = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密码修改成功');
                }else{
                    return back()->with('errors','原密码不正确');
                }
            }else{
                return back()->withErrors($validator);
            }
//            dd($validator);
        }else{
            return view('admin.pass');
        }
    }
    
    
}
