@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">

    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增导航</a>
                    <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc">ID</th>
                        <th>导航名称</th>
                        <th>导航别名</th>
                        <th>URL</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v['navs_order']}}" onchange="changeOrder(this,{{$v['id']}})">
                        </td>
                        <td class="tc">{{$v['id']}}</td>
                        <td>{{$v['navs_name']}}</td>
                        <td>{{$v['navs_alias']}}</td>
                        <td>{{$v['navs_url']}}</td>
                        <td>
                            <a href="{{url("admin/navs/$v->id/edit")}}">修改</a>
                            <a href="#" onclick="deleteCate({{$v['id']}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
<script>
    function changeOrder(obj,id) {
        var id = id;
        var order = $(obj).val();
        $.post( "{{url('admin/navs/changeorder')}}", {'_token':"{{csrf_token()}}",'id':id,'navs_order':order},function (data) {
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
            $.post("{{url('admin/navs/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
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