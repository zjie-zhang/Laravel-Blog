@extends('layouts.home')
@section('info')
  <title>{{$art_info->art_title}} - {{Config::get('web.web_title')}}</title>
  <meta name="keywords" content="{{$art_info->cate_keywords}}"  />
  <meta name="description"  content="{{$art_info->art_desc}}" />
@endsection
@section('content')
<article class="blogs">
  <h1 class="t_nav">
    <span>您当前的位置：
      <a href="{{url('/')}}" style="float: none; color: #000; display: inline;">首页</a>&nbsp;&gt;&nbsp;
      <a href="{{url('cate/'.$art_info->cat_id)}}" style="float: none; color: #000; display: inline;">{{$art_info->cate_name}}</a>
    </span>
    <a href="{{url('/')}}" class="n1">网站首页</a>
    <a href="{{url('cate/'.$art_info->cat_id)}}" class="n2">{{$art_info->cate_name}}</a>
  </h1>

  <div class="index_about">
    <h2 class="c_titile">{{$art_info->art_title}}</h2>
    <p class="box_c">
      <span class="d_time">发布时间：{{date('Y-m-d',$art_info['art_time'])}}</span>
      <span>编辑：{{$art_info->art_editor}}</span>
      <span>查看次数：{{$art_info->art_view}}</span></p>
    <ul class="infos">
      {!! $art_info->art_content !!}
    </ul>
    <div class="keybq">
    <p><span>关键字词</span>：{{$art_info->art_tag}}</p>
    
    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
      <p>上一篇：
        @if($art_arr['pre'])
        <a href="{{url('art/'.$art_arr['pre']->id)}}">{{$art_arr['pre']->art_title}}</a>
        @else
        没有上一篇了
        @endif
      </p>
      <p>下一篇：
        @if($art_arr['nex'])
          <a href="{{url('art/'.$art_arr['nex']->id)}}">{{$art_arr['nex']->art_title}}</a>
        @else
          没有下一篇了
        @endif
      </p>
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        @foreach($relevant_art as $relevant)
        <li><a href="{{url('art/'.$relevant->id)}}" title="{{$relevant->art_title}}">{{$relevant->art_title}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  <aside class="right">
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script> 
    <!-- Baidu Button END -->
    <div class="blank"></div>
    <div class="news">
      @parent
    <div class="visitors">
      <h3>
        <p>最近访客</p>
      </h3>
      <ul>
      </ul>
    </div>
  </aside>
</article>
@endsection