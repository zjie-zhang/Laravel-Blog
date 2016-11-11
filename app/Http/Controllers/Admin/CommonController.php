<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传方法
    public function upload(){
//        $file = $_FILES['Filedata'];
        $file = Input::file('Filedata');
        if($file->isValid()){
//            $file_name = $file->getClientOriginalName(); // 获取原始文件名称
//            $temp_name = $file->getFileName(); // 获取临时文件名称
//            $save_path = $file->getRealPath(); // 临时文件绝对路径
//            $mime_type = $file->getMimeType(); // 获取mime类型
            $entension = $file->getClientOriginalExtension(); // 上传文件的后缀
            $new_name = mt_rand(100,999) . substr(time(),-3) .'.'. $entension;
            $path = $file->move(base_path() . '/uploads' , $new_name); // 上传文件 | app_path 是app文件夹所在路径 | base_path 是根目录
            $file_path  = "uploads/" . $new_name;
            return $file_path;
        }
    }
}
