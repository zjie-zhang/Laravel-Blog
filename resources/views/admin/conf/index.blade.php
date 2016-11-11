@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部配置项
    </div>
    <!--面包屑配置项 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <div class="result_title">
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $v)
                        <p>{{$v}}</p>
                    @endforeach
                @else
                    {{$errors}}
                @endif
            </div>
        @endif
        </div>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/conf/create')}}"><i class="fa fa-plus"></i>新增配置项</a>
                    <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="{{url('admin/conf')}}"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/conf/changecontent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th>配置</th>
                        <th>说明</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v['conf_order']}}" onchange="changeOrder(this,{{$v['id']}})">
                        </td>
                        <td class="tc">{{$v['id']}}</td>
                        <td>
                            <a href="#">{{$v['conf_title']}}</a>
                        </td>
                        <td>{{$v['conf_name']}}</td>
                        <td>{!! $v['html'] !!}</td>
                        <td>{{ $v['conf_tips'] }}</td>
                        <input type="hidden" name="id[]" value="{{$v->id}}" >
                        <td>
                            <a href="{{url("admin/conf/$v->id/edit")}}">修改</a>
                            <a href="#" onclick="deleteCate({{$v['id']}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                    <div class="btn_group">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                    </div>
                </form>
            </div>
        </div>

    <!--搜索结果页面 列表 结束-->
<script>
    function changeOrder(obj,id) {
        var id = id;
        var order = $(obj).val();
        $.post( "{{url('admin/conf/changeorder')}}", {'_token':"{{csrf_token()}}",'id':id,'conf_order':order},function (data) {
            if(data.num == 0){
                layer.msg(data.msg, {icon: 6});
            }else{
                layer.msg(data.msg, {icon: 5});
            }
        });
    }
    
    function deleteCate(id) {
        //询问框
        layer.confirm('确定删除？', {
            btn: ['确认','取消'] //按钮
        }, function(){
            $.post("{{url('admin/conf/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                    if(data.num == 0){
                        layer.msg(data.msg, {icon: 6});
                        location.reload();
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
            });
        }, function(){

        });
    }
</script>

@endsection