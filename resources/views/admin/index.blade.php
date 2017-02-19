@extends('app')

@section('content')
<div class="container">
  <div class="row">
  	<div class="col-md-3">
  		<div class="panel panel-info">
  			<div class="panel-heading">
			    <h3 class="panel-title">组织机构</h3>
			  </div>
			  <div class="panel-body">
			    	<div id="tree" class="ztree">  
	  
	  			</div>
			  </div>
  		</div>
  	</div>
            <div class="col-md-9" style="padding:20px;">
                <div class="panel panel-default">
  <!-- Default panel contents -->
                  <div class="panel-heading" id="panel_heading_buttons">该组织下的人员
                  	<a href="javascript:void(0);" class="pull-right" onclick="userCreate()">添加</a>
                  </div>
                  <div class="panel-body" id="variableArea" style="padding:20px 40px;">
                        <table id="example" class="demo hover dataTable" role="grid" aria-describedby="demo1_info" style="width: 90%;" width="100%">
                           <thead>
                                <tr role="row">
                                    <th>编号</th>
                                    <th>账号</th>
                                    <th>邮箱</th>
                                    <th>创建时间</th>
                                    <th>修改时间</th>
                                    <th></th>
                                </tr>
                            </thead>
                      </table>
                  </div>

                  <!-- Table -->
                  
                </div>
            </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">添加新用户</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="userForm">
        	<input type="hidden" name="type" id="type" value="1">
		  <div class="form-group">
		    <label for="org" class="col-sm-2 control-label">所属组织</label>
		    <div class="col-sm-10">
		      <input readonly type="text" class="form-control" id="org" name="org" value="">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="name" class="col-sm-2 control-label">昵称</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control" name="name" id="name">
		    </div>
		    <label for="email" class="col-sm-2 control-label">邮箱</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control" name="email" id="email">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="password" class="col-sm-2 control-label">密码</label>
		    <div class="col-sm-4">
		      <input type="password" class="form-control" name="password" id="password">
		    </div>
		    <label for="password2" class="col-sm-2 control-label">确认密码</label>
		    <div class="col-sm-4">
		      <input type="password" class="form-control" name="confirm_password" id="confirm_password">
		    </div>
		  </div>
	      <button id="save" type="submit" class="btn btn-primary" onclick="userStore()" style="display:none;"></button>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-info" id="fakeSave" onclick="forUserStore()">保存</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
var zTreeObj;
var curStatus = "init", curAsyncCount = 0, goAsync = false; 
var org_id = 1,org_name = "总经理",user_id = 0;
var setting = {
		view: {
			addHoverDom: addHoverDom, 
	        removeHoverDom: removeHoverDom, 
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
			url: "{{ URL("admin/organization/all") }}",
			autoParam: ["id", "name"]
		},
		data: {
			simpleData: {
				enable: true,
				idKey: "id",
				pIdKey: "pid",
				rootPId: 0,
			}
		},
		callback: {  
            onRename: onRename, 
        	beforeRemove: zTreeBeforeRemove,
            onRemove: onRemove, 
            beforeAsync: beforeAsync,  
           	onAsyncSuccess: onAsyncSuccess,
           	onClick:zTreeOnClick  
        }  
};

function addHoverDom(treeId, treeNode) {  
    var sObj = $("#" + treeNode.tId + "_span"); 
    if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;  
  
    var addStr = "<span class='button add' id='addBtn_" + treeNode.tId + "' title='add node' onfocus='this.blur();'></span>";   
    sObj.after(addStr); 
    var btn = $("#addBtn_"+treeNode.tId);  
  
    if (btn) btn.bind("click", function(){  
        var zTree = $.fn.zTree.getZTreeObj("tree");  
        var name='新节点'; 
        $.ajax({
    		url: '{{ URL("admin/organization/store") }}/'+treeNode.id+'/'+name,
    		type: 'POST',
    		async: false,  
            contentType: false,  
            processData: false,  
    		success:function(e){
    				console.log(e);
			        zTree.addNodes(treeNode, {id:(e.newTreeNode.id), parentid:e.newTreeNode.pid, name:e.newTreeNode.name}); 
    			},
    		error:function(msg){
    				console.log(msg);
    			}
    	}); 
    });  
};  
function removeHoverDom(treeId, treeNode) {  
    $("#addBtn_"+treeNode.tId).unbind().remove();  
};

function onRename(e, treeId, treeNode, isCancel) {  
    console.log(treeNode);
	$.ajax({
		url: '{{ URL("admin/organization/update") }}/'+treeNode.id+'/'+treeNode.name,
		type: 'POST',
		async: false,  
        contentType: false,  
        processData: false,  
		success:function(e){
				console.log(e);
			},
		error:function(msg){
				console.log(msg);
			}
	}); 
}


function zTreeBeforeRemove(treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("tree");  
    zTree.selectNode(treeNode);  
    return confirm("确认删除" + treeNode.name + "吗？"); 
}


function onRemove(e, treeId, treeNode) {  
	$.ajax({
		url: '{{ URL("admin/organization/delete") }}/'+treeNode.id,
		type: 'POST',
		async: false,  
        contentType: false,  
        processData: false,  
		success:function(e){
				console.log(e);
			},
		error:function(msg){
				console.log(msg);
			}
	});  
} 

function zTreeOnClick(event, treeId, treeNode){
	org_id = treeNode.id;
	org_name = treeNode.name;
	ajaxTable.ajax.url('{{URL("admin/user/findByOrg")}}'+'/'+treeNode.id).load();
}
function userCreate() {
	$('#myModal input').val("");
	$('#myModal input[name = "type"]').val(1);
	$('#myModal input[name = "org"]').val(org_name);
	$('#myModal').modal();	
}
function forUserStore(){
	$("#save").click();
}
function userStore() {
	$("#userForm").validate({
	    rules: {
		      name: {
		        required: true,
		      },
		      email: {
		        required: true,
		        email: true
		      },
		      password: {
		        required: true,
		        minlength: 5
		      },
		      confirm_password: {
		        required: true,
		        minlength: 5,
		        equalTo: "#password"
		      }
	    },
	    submitHandler:function(form){
			var data = $('#userForm').serializeObject();
			if($('#myModal input[name = "type"]').val() == 1){
				$.ajax({
					dataType: 'json',
					url: '{{ URL("admin/user/storeByOrg") }}' + '/' + org_id,
					type: 'POST',
					data: data,
					async: false,  
					success:function(e){
							console.log(e.data);
							if(e.data == -1){
								toastr.info("该邮箱已经被注册过");
								$('#myModal input[name = "email"]').val("");
							}else if(e.data == 1){
								console.log(e.data);
								$('#myModal').modal('hide');
								ajaxTable.ajax.reload();
								toastr.info('添加成功')
							}
						},
					error:function(msg){
							console.log(msg.responseText);
						}
				});
			}else if($('#myModal input[name = "type"]').val() == 2){
				$.ajax({
					dataType: 'json',
					url: '{{ URL("admin/user/update") }}' + '/' + user_id,
					type: 'POST',
					data: data,
					async: false,  
					success:function(e){
							console.log(e.data);
							$('#myModal').modal('hide');
							ajaxTable.ajax.reload();
							toastr.info('修改成功')
						},
					error:function(msg){
							console.log(msg.responseText);
						}
				});
			}
		} 
	});
}
//用户编辑按钮
$("#example").delegate('.userUpdate','click',function(){
	//alert($(this).attr("data-id"));
	$.ajax({
		url: '{{ URL("admin/user/findById") }}'+'/'+$(this).attr("data-id"),
		type: 'GET',
		async: false,  
		success:function(e){
				user_id = e.id;
				$('#myModal input[name = "org"]').val(org_name);
				$('#myModal input[name = "type"]').val(2);
				$('#myModal input[name = "name"]').val(e.name);
				$('#myModal input[name = "email"]').val(e.email);
				$('#myModal input[name = "password"]').val("");
				$('#myModal input[name = "confirm_password"]').val("");
				$('#myModal').modal();
			},
		error:function(msg){
				console.log(msg);
			}
	});
});
//用户删除按钮
$("#example").delegate('.userDelete','click',function(){
	//alert($(this).attr("data-id"));
	if(confirm("确认要删除用户"+$(this).attr("data-id")+"吗？")){
		$.ajax({
			url: '{{ URL("admin/user/delete") }}'+'/'+$(this).attr("data-id"),
			type: 'GET',
			async: false,  
			success:function(e){
					console.log(e);
					ajaxTable.ajax.reload();					
					toastr.info("删除成功");
				},
			error:function(msg){
					console.log(msg);
				}
		});
	}
});
	$(function(){
		zTreeObj = $.fn.zTree.init($(".ztree"), setting).expandAll(true);
        setTimeout(function(){  
	        expandAll("tree");  
		},500);//延迟加载  
    	});
                            
        ajaxTable = $('#example').DataTable( {
            "type":"GET",
            "ajax": '{{ URL("admin/user/findByOrg") }}'+'/'+org_id,
            "columns": [
                { "data": "id"},
                { "data": "name" },
                { "data": "email" },
                { "data": "created_at", "class": "center" },
                { "data": "updated_at", "class": "center" },
                { "data": null }
            ],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex) {
            	$('td:eq(5)', nRow).find(".userUpdate").attr("data-id",aData.id);
            	$('td:eq(5)', nRow).find(".userDelete").attr("data-id",aData.id);
            },
            "lengthChange":false,
            "aoColumnDefs":[
                {
                    "targets": -1,
                    "class": "but_xq",
                    "data": null,
                    "bSortable": false,
                    "defaultContent": "<a class=\"userUpdate\">编辑</a>&nbsp;&nbsp;&nbsp;<a class=\"userDelete\">删除</a>"
                }
            ],
        } );
</script>
@endsection