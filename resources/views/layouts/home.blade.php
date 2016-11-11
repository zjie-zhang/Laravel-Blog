<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k => $v)<a href="{{$v->navs_url}}" @if($k ==0) id="topnav_current" @endif><span>{{$v->navs_name}}</span><span class="en">{{$v->navs_alias}}</span></a>@endforeach
        {{--
        <a href="index.html"><span>首页</span><span class="en">Protal</span></a>
        <a href="about.html"><span>关于我</span><span class="en">About</span></a>
        <a href="newlist.html"><span>慢生活</span><span class="en">Life</span></a>
        <a href="moodlist.html"><span>碎言碎语</span><span class="en">Doing</span></a>
        <a href="share.html"><span>模板分享</span><span class="en">Share</span></a>
        <a href="knowledge.html"><span>学无止境</span><span class="en">Learn</span></a>
        <a href="book.html"><span>留言版</span><span class="en">Gustbook</span></a>
        --}}
    </nav>
</header>

{{--@yield('content')--}}
@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($art_new_arr as $new)
            <li><a href="{{url('art/'.$new->id)}}" title="{{$new->art_title}}" target="_blank">{{$new->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($art_hot_arr as $k=> $hot)
            @if($k<5)
                <li><a href="{{url('art/'.$hot->id)}}" title="{{$hot->art_title}}" target="_blank">{{$hot->art_title}}</a></li>
            @endif
        @endforeach
    </ul>
@show

<footer>
    <p>{!! Config::get('web.copyright') !!} {!! Config::get('web.web_count') !!} </p>
</footer>

</body>
</html>