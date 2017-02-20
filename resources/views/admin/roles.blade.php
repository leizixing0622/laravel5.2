@extends('app')

@section('content')
<div class="container">
  <div class="row">
  	<div class="col-md-3">
  		<div class="panel panel-info">
  		      <div class="panel-heading">
			    <h3 class="panel-title">角色管理</h3>
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
			url: "{{ URL("admin/role/all") }}",
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
    		url: '{{ URL("admin/role/store") }}/'+treeNode.id+'/'+name,
    		type: 'GET',
    		async: false,  
            contentType: false,  
            processData: false,  
    		success:function(e){
    				console.log(e);
			        zTree.addNodes(treeNode, {id:(e.newTreeNode.id), parentid:e.newTreeNode.pid, name:e.newTreeNode.name}); 
    			},
    		error:function(msg){
    				console.log(msg.responseText);
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
		url: '{{ URL("admin/role/update") }}/'+treeNode.id+'/'+treeNode.name,
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
		url: '{{ URL("admin/role/delete") }}/'+treeNode.id,
		type: 'GET',
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

	$(function(){
		zTreeObj = $.fn.zTree.init($(".ztree"), setting).expandAll(true);
		setTimeout(function(){  
            expandAll("tree");  
		},500);//延迟加载  
	});
</script>
@endsection