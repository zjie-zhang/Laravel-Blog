<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Conf;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfController extends CommonController
{
    //index
    public function index(){
        $data = Conf::orderBy('conf_order','desc')->get();
        foreach ($data as $v){
            switch ($v['field_type']){
                case 'input':
                    $v['html'] = "<input type='text' class='lg' name='conf_content[]' value='". $v['conf_content'] ."'>";
                    break;
                case 'textarea':
                    $v['html'] = "<textarea type='text' class='lg' name='conf_content[]' >". $v['conf_content'] ."</textarea>";
                    break;
                case 'radio':
                    //  1|开启,0|关闭
                    $conf_radio = explode(',',$v['field_value']);
                    foreach ($conf_radio as $m){
                        $radio_value = explode('|',$m);
                        $v['html'] .= "<input type='radio' name='conf_content[]' value='". $radio_value[0] ."'";
                        if($v['conf_content'] == $radio_value[0]) {
                            $v['html'] .= 'checked';
                        }
                        $v['html'] .= ">" . $radio_value[1] . "&nbsp; | &nbsp;";
                    }
                    break;
            }
        }
        return view('admin.Conf.index')->with('data',$data);
    }

    // ajax排序
    public function changeOrder(){
        $model = new Conf();
        $input = Input::all();
        $id = $input['id'];
        $order = $input['conf_order'];
        $links_rs = $model->where('id', $id)->update(['conf_order' => $order]);
        if($links_rs){
            $data = ['num'=>0,'msg'=>'更新成功'];
        }else{
            $data = ['num'=>-1,'msg'=>'更新失败'];
        }
        return $data;
    }

    // get - admin/links/create 添加链接
    public function create(){
        return view('admin.conf.add');
    }

    // post - admin/links
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'conf_title'=>'required',
            'conf_name'=>'required',
        ];
        $message = [
            'conf_title.required'=>'配置标题不能为空',
            'conf_name.required'=>'配置名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $model = new Conf();
            if($model->insert($input)){
                return redirect('admin/conf');
            }else{
                return back()->with('errors','添加失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    // get - admin/links/{links}/edit   修改
    public function edit($conf_id){
        $info = Conf::find($conf_id);
        return view('admin.conf.edit')->with('info',$info);
    }

    // 更新
    public function update($conf_id){
        $input = Input::except('_token','_method');
        $res = DB::table('conf')->where('id',$conf_id)->update($input);
        if($res){
            $this->putFile(); // 更新配置项到哦诶之文件
            return redirect('admin/conf');
        }else{
            return back()->with('errors','更新失败');
        }
    }

    // 删除
    public function destroy($conf_id){
        if($re = Conf::where(['id'=>$conf_id])->delete()){
            $data = ['num'=>0,'msg'=>'删除成功'];
            $this->putFile(); // 更新配置项到哦诶之文件
        }else{
            $data = ['num'=>-1,'msg'=>'删除失败'];
        }
        return $data;
    }

    // ajax 更改配置内容
    public function changeContent(){
        $input = Input::except('_token','ord');
        foreach ($input['id'] as $k => $v){
            Conf::where('id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile(); // 更新配置项到哦诶之文件
        return back()->with('errors','配置修改成功');
    }

    // 将配置项数据写入配置文件
    public function putFile(){
        $config_arr = Conf::pluck('conf_content','conf_name')->all();
        $conf_str = "<?php \nreturn ";
        $conf_str .= var_export($config_arr,true); // 转为字符串
        $conf_str .= ";";
        $file_path = base_path() . '\config\web.php';
        file_put_contents($file_path,$conf_str);

    }


}
