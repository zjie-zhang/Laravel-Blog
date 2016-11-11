@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-refresh"></i>更新排序</a>
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
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>关键词</th>
                        <th>描述</th>
                        <th>点击次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v['cate_order']}}" onchange="changeOrder(this,{{$v['id']}})">
                        </td>
                        <td class="tc">{{$v['id']}}</td>
                        <td>
                            <a href="#"> {{str_repeat('---',$v['level'])}}{{$v['cate_name']}}</a>
                        </td>
                        <td>{{$v['cate_title']}}</td>
                        <td>{{$v['cate_keywords']}}</td>
                        <td>{{$v['cate_description']}}</td>
                        <td>{{$v['cate_view']}}</td>
                        <td>
                            <a href="{{url("admin/category/$v->id/edit")}}">修改</a>
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
        $.post( "{{url('admin/cate/changeorder')}}", {'_token':"{{csrf_token()}}",'id':id,'cate_order':order},function (data) {
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
            $.post("{{url('admin/category/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
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