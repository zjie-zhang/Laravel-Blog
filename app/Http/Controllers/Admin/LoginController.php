<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once('resources/org/code/Code.class.php');  // 引入验证码类

class LoginController extends CommonController
{
    //登陆验证
    public function login(){
        if($input = Input::all()){
            // 获取验证码session
            $code_obj = new \Code();
            $code_session = $code_obj->get();
            // 判断验证码
            if(strtoupper($input['code']) != $code_session){
                return back()->with('msg','验证码错误');
            }
            // 判断用户名密码完整性
            $user_name = $input['user_name'];
            $user_pwd = $input['user_pwd'];
            if(empty($user_name) || empty($user_pwd)){
                return back()->with('msg','请正确填写用户名及密码');
            }
            // 判断用户名密码正确性
            $user_info = User::first();
            if($user_name != $user_info['user_name'] || $user_pwd != Crypt::decrypt($user_info['user_pwd'])){
                return back()->with('msg','用户名或密码错误');
            }
            // 登陆成功
            session(['user'=>$user_info]);
            return redirect('admin/index');
        }else{
//            session(['user'=>null]);  // 清除session
            return view('admin.login');
        }
    }

    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }

    // 制作验证码
    public function code(){
        $code_obj = new \Code();
        $code = $code_obj->make();
        return $code;
    }
    // 获取验证码session
    public function get(){
        $code_obj = new \Code();
        $code_session = $code_obj->get();
        return $code_session;
    }

    // crypt加密
    public function crypt(){

        $str = "admin";
        $crypt = Crypt::encrypt($str);
        echo $crypt;
    }



}
