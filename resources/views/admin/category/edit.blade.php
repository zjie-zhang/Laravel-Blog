@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 修改分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/category/'.$info['id'])}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_pid">
                                <option value="0">顶级分类</option>
                                @foreach($data as $v)
                                    @if($v['id'] == $info['cate_pid'])
                                        <option value="{{$v['id']}}" selected="selected">{{str_repeat('---',$v['level'])}}{{$v['cate_name']}}</option>
                                    @else
                                        <option value="{{$v['id']}}">{{str_repeat('---',$v['level'])}}{{$v['cate_name']}}</option>
                                    @endif

                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类名称：</th>
                        <td>
                            <input type="text"  name="cate_name" value="{{$info['cate_name']}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" class="lg" name="cate_title" value="{{$info['cate_title']}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>描述：</th>
                        <td>
                            <textarea name="cate_description"> {{$info['cate_description']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>关键词：</th>
                        <td><input type="text" class="lg" name="cate_keywords" value="{{$info['cate_keywords']}}"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td><input type="text" name="cate_order"  value="{{$info['cate_order']}}"></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection