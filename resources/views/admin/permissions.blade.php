@extends('app')

@section('content')
<div class="container">
  <div class="row">
  	<div class="col-md-3">
  		<div class="panel panel-info">
  		      <div class="panel-heading">
			    <h3 class="panel-title">菜单管理</h3>
			  </div>
			  <div class="panel-body">
			    	<div id="tree" class="ztree">  
	  
	  			</div>
			  </div>
  		</div>
  	</div>
  </div>
</div>
<script type="text/javascript">
var zTreeObj;
var curStatus = "init", curAsyncCount = 0, goAsync = false; 
var org_id = 1,org_name = "总经理",user_id = 0;
var setting = {
		view: {
		},
		edit: {  
	        enable: true, 
	        editNameSelectAll: true, 
	        showRemoveBtn: true,  
	        showRenameBtn: true   
	    }, 
		async: {
			enable: true,
			type: "GET",
			url: "{{ URL("permissions/all-permissions/") }}",
			autoParam: ["id", "name"]
		},
		data: {
			simpleData: {
				enable: true,
				idKey: "id",
				pIdKey: "pid",
				rootPId: 0,
			},
			key: {
				name: "display_name"
			}
		},
		callback: {  
        }  
};
	$(function(){
		zTreeObj = $.fn.zTree.init($(".ztree"), setting);
	});
</script>
@endsection