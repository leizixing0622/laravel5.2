@extends('app')

@section('content')
<div class="container">
  <div class="row">
  	<div class="col-md-8">
  		<div class="panel panel-info">
  		      <div class="panel-heading">
			    <h3 class="panel-title">角色列表</h3>
			  </div>
			  <div class="panel-body">
		  		<table id="example" class="demo hover dataTable" role="grid" aria-describedby="demo1_info">
                       <thead>
                            <tr role="row">
                                <th>编号</th>
                                <th>角色名</th>
                                <th>代号</th>
                                <th>描述</th>
                                <th>创建时间</th>
                                <th>修改时间</th>
                            </tr>
                        </thead>
                  </table>
			  </div>
  		</div>
  	</div>
  	<div class="col-md-4">
  		<div class="panel panel-info">
  		      <div class="panel-heading">
			    <h3 class="panel-title">权限分配</h3>
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
var curStatus = "init", curAsyncCount = 0, goAsync = false;
var setting = {
		view: {
		},
		check: {
			enable: true,
			chkStyle: "checkbox",
			chkboxType: { "Y": "p", "N": "s" }
		}, 
		async: {
			enable: true,
			type: "GET",
			url: "{{ URL("admin/permission/all") }}",
			autoParam: ["id", "name"]
		},
		data: {
			simpleData: {
				enable: true,
				idKey: "id",
				pIdKey: "pid",
				rootPId: 0,
			},
			key:{
				name:'display_name'
			}
		},
		
		callback: {  
            beforeAsync: beforeAsync,  
           	onAsyncSuccess: onAsyncSuccess
        }  
};
function trClick(trRoleSid){
	roleSid = trRoleSid;
	$.ajax({  
        type:'GET',
        url:'{{ URL("admin/role-permission/find-by-role") }}/' + roleSid, 
        success:function(data){
        	console.log(data.data);
        	checkedNode(data);
        },error:function(e){  
            console.log(e);
        }  
    }); 
}
function checkedNode(nodeIds){
	if(nodeIds.length > 0){
		for(var i = 0; i < nodeIds.length; i++){
			var node = zTreeObj.getNodeByParam("id",nodeIds[i].id);
			if(null == node || typeof(node) == 'undefined'){
				continue;
			}
			node.checked = true;
		}
	}
}
$(function(){
	ajaxTable = $('#example').DataTable( {
        "type":"GET",
        "ajax": '{{ URL("admin/role-permission/all-roles") }}',
        "columns": [
            { "data": "id"},
            { "data": "name" },
            { "data": "display_name" },
            { "data": "description" },
            { "data": "created_at", "class": "center" },
            { "data": "updated_at", "class": "center" }
        ],
        "fnRowCallback" : function(nRow, aData, iDisplayIndex) {
        	
        },
        "lengthChange":false,
        "aoColumnDefs":[
        ],
    } );
    $('#example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            ajaxTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        //调用选中角色的菜单树
        var rowData = ajaxTable.rows('.selected').data();
        trClick(rowData[0].id);
    } );
    zTreeObj = $.fn.zTree.init($(".ztree"), setting).expandAll(true);
    setTimeout(function(){  
	        		expandAll("tree");  
				},500);//延迟加载  
})
</script>
@endsection