<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel学习之路</title>

    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/demo.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/zTreeStyle/zTreeStyle.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/toastr.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/common.css') }}" rel="stylesheet">
	<script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/dataTables_zh.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.ztree.core.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.ztree.exedit.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/toastr.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.validate.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/messages_zh.js') }}"></script>


</head>
<body id="app-layout">
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">laravel学习之路</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-nav1">
//自定义菜单
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	      		<li><a href="{{ asset('admin/index') }}">后台管理</a></li>
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
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
    @yield('content')

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script type="text/javascript">
    	$(function(){
    		$.ajax(
    			{
	    			url: '{{ URL("home/permission/all") }}',
					type: 'GET',
					async: false,
					success:function(e){
							console.log(e);
							console.log(fns(e,0));
							$(".navbar-nav1").html(sf(fns(e,0)));
						},
					error:function(msg){
							console.log(msg.responseText);
						}
	    		}
    		);
    	})
    </script>
</body>
</html>
