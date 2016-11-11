@extends('layouts.home')
@section('info')
    <title>{{$cate_info->cate_name}} - {{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$cate_info->cate_keywords}}" />
    <meta name="description" content="{{$cate_info->cate_description}}" />
@endsection
@section('content')
<article class="blogs">
<h1 class="t_nav">
    <a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$cate_info->id)}}" class="n2">{{$cate_info->cate_name}}</a>
    <span>{{$cate_info->cate_title}}</span>
</h1>
<div class="newblog left">
   @foreach($art_lst_arr as $art)
   <h2><a href="{{url('art/'.$art->id)}}" target="_blank">{{$art->art_title}}</a></h2>
   <p class="dateview">
       <span>&nbsp;发布时间：{{date('Y-m-d',$art->art_time)}}</span>
       <span>作者：{{$art->art_editor}}</span>
       <span>分类：[<a href="{{url('cate/'.$art->cat_id)}}">{{$cate_info->cate_name}}</a>]</span>
   </p>
    <figure><a href="{{url('art/'.$art->id)}}" target="_blank"><img src="{{url($art->art_thumb)}}"></a></figure>
    <ul class="nlist">
        <a href="{{url('art/'.$art->id)}}" target="_blank"><p>{{$art->art_desc}}...</p></a>
        <a title="{{$art->art_title}}" href="{{url('art/'.$art->id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
   @endforeach

    <div class="blank"></div>
    <div class="ad">  
    <img src="images/ad.png">
    </div>
        <div class="page">
            {{$art_lst_arr->links()}}
        </div>
</div>
<aside class="right">

    @if($cate_child->all())
   <div class="rnav">
      <ul>
          @foreach($cate_child as $k => $child)
       <li class="rnav{{$k+1}}"><a href="{{url('cate/'.$child->id)}}" target="_blank">{{$child->cate_name}}</a></li>
          @endforeach
     </ul>      
   </div>
    @endif
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
        <a class="bds_tsina"></a>
        <a class="bds_qzone"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
        <span class="bds_more"></span>
        <a class="shareCount"></a>
    </div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
    </script>
    <!-- Baidu Button END -->

    <div class="news" style="float: left">
        @parent
    </div>

    <div class="visitors" style="float: left">
      <h3><p>最近访客</p></h3>
      <ul>

      </ul>
    </div>


</aside>
</article>
@endsection