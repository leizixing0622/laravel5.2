<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<title>Laravel</title>

	<link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/demo.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/zTreeStyle/zTreeStyle.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/toastr.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/common.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/select2.css') }}" rel="stylesheet">
	<script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/dataTables_zh.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.ztree.all.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.ztree.core.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.ztree.exedit.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.ztree.excheck.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/toastr.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.validate.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/messages_zh.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/select2.full.js') }}"></script>
	<!-- Fonts -->


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-nav1">

				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{ asset('') }}">返回前台</a></li>
					<!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
	                    <li>
	                    	<select name="" id="" style="margin-top:16px;">
	                    		@foreach(Auth::user()->organizations as $organization)
	                    			<option value="">{{$organization->name}}</option>
	                			@endforeach
	                    	</select>
	                    </li>
	                    <li style="padding-top:4px;padding-left:20px;">
	                    	<img class="img-circle" src="{{ asset('/uploadfiles/avatar').'/'.Auth::user()->avatar->filename }}" alt="" height="40px" width="40px">
	                    </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>注销</a></li>
                            </ul>
                        </li>
                    @endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
</body>
<script type="text/javascript">
	$(function(){
		$.ajax(
			{
    			url: '{{ URL("index/permission/all") }}',
				type: 'GET',
				async: false,
				success:function(e){
						$(".navbar-nav1").html(sf(fns(e,36)));
					},
				error:function(msg){
						console.log(msg.responseText);
					}
    		}
		);
	})
</script>
</html>
