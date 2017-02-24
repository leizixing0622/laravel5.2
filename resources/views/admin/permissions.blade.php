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
    <div class="col-md-9">
        <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">详细信息修改</h3>
                </div>
                <div class="panel-body">
                    <form id="permissionInfo">
                      <div class="form-group">
                        <label for="id">菜单编号</label>
                        <input type="text" class="form-control" name="id" id="id" placeholder="" v-bind:value="id">
                      </div>
                      <div class="form-group">
                        <label for="url">菜单路径</label>
                        <input type="text" class="form-control" name="url" id="url" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="name">菜单名称</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="display_name">菜单</label>
                        <input type="text" class="form-control" name="display_name" id="display_name" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="description">菜单描述</label>
                        <input type="text" class="form-control" name="description" id="description" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="type">是否是隐形菜单</label>
                        <input type="radio" name="type" id="type" value="2">是
                        <input type="radio" name="type" id="type" value="1">否
                      </div>
                      <button type="submit" style="display:none;" id="saveButton" onclick="updateInfo()"></button>
                    </form>
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-info" onclick="clickSaveButton()">保存修改</button>
                  </div>
                </div>
                </div>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var zTreeObj;
var curStatus = "init", curAsyncCount = 0, goAsync = false;
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
			key: {
				name: "display_name"
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
function removeHoverDom(treeId, treeNode) {
    $("#addBtn_"+treeNode.tId).unbind().remove();
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
    		url: '{{ URL("admin/permission/store") }}/'+treeNode.id+'/'+name,
    		type: 'GET',
    		async: false,
            contentType: false,
            processData: false,
    		success:function(e){
    				console.log(e);
			        zTree.addNodes(treeNode, {id:(e.newTreeNode.id), parentid:e.newTreeNode.pid, name:e.newTreeNode.display_name});
    			},
    		error:function(msg){
    				console.log(msg.responseText);
    			}
    	});
    });
};
function onRename(e, treeId, treeNode, isCancel) {
    console.log(treeNode);
	$.ajax({
		url: '{{ URL("admin/permission/update") }}/'+treeNode.id+'/'+treeNode.display_name,
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
    return confirm("确认删除" + treeNode.display_name + "吗？");
}


function onRemove(e, treeId, treeNode) {
	$.ajax({
		url: '{{ URL("admin/permission/delete") }}/'+treeNode.id,
		type: 'GET',
		async: true,
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
    permission_id = treeNode.id;
    $.ajax({
        url: '{{ URL("admin/permission/findById") }}/'+permission_id,
        type: 'GET',
        async: true,
        contentType: false,
        processData: false,
        success:function(e){
                console.log(e);
                $("input[name = id]").val(e.id);
                $("input[name = url]").val(e.url);
                $("input[name = name]").val(e.name);
                $("input[name = display_name]").val(e.display_name);
                $("input[name = description]").val(e.description);
                $("input[name = type]").eq(e.type).click();
            },
        error:function(msg){
                console.log(msg);
            }
    });
}

function clickSaveButton(){
    $("#saveButton").click();
}
function updateInfo(){
    $("#permissionInfo").validate({
        rules: {
              id: {
                required: true,
              },
              url: {
                required: true,
              },
              name: {
                required: true,
                minlength: 5
              },
              display_name: {
                required: true,
                minlength: 4
              }
        },
        submitHandler:function(form){
            var data = $('#permissionInfo').serializeObject();
            $.ajax({
                dataType: 'json',
                url: '{{ URL("admin/permission/updateDetail") }}/' + permission_id,
                type: 'POST',
                data: data,
                async: false,
                success:function(e){
                        console.log(e);
                        toastr.info("保存成功");
                    },
                error:function(msg){
                        console.log(msg.responseText);
                    }
            });
        }
    });
}

	$(function(){
        permission_id = 0;
		zTreeObj = $.fn.zTree.init($(".ztree"), setting).expandAll(true);
		setTimeout(function(){
                expandAll("tree");
 			},500);//延迟加载
		});
</script>
@endsection