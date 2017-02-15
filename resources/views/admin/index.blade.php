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
                  <div class="panel-heading">该组织下的人员</div>
                  <div class="panel-body" >
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
			url: "{{ URL("index/all-org/") }}",
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
                           onAsyncSuccess: onAsyncSuccess  
	      }  
};
function beforeAsync() {  
            curAsyncCount++;  
        } 
function onAsyncSuccess(event, treeId, treeNode, msg) {  
            curAsyncCount--;  
            if (curStatus == "expand") {  
                expandNodes(treeNode.children);  
            } else if (curStatus == "async") {  
                asyncNodes(treeNode.children);  
            }  
  
            if (curAsyncCount <= 0) {  
                curStatus = "";  
            }  
        } 
function expandNodes(nodes) {  
            if (!nodes) return;  
            curStatus = "expand";  
            var zTree = $.fn.zTree.getZTreeObj("tree");  
            for (var i=0, l=nodes.length; i<l; i++) {  
                zTree.expandNode(nodes[i], true, false, false);//展开节点就会调用后台查询子节点  
                if (nodes[i].isParent && nodes[i].zAsync) {  
                    expandNodes(nodes[i].children);//递归  
                } else {  
                    goAsync = true;  
                }  
            }  
        }
function addHoverDom(treeId, treeNode) {  
    var sObj = $("#" + treeNode.tId + "_span"); 
    if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;  
  
    var addStr = "<span class='button add' id='addBtn_" + treeNode.tId + "' title='add node' onfocus='this.blur();'></span>"; //������Ӱ�ť  
    sObj.after(addStr); 
    var btn = $("#addBtn_"+treeNode.tId);  
  
    if (btn) btn.bind("click", function(){  
        var zTree = $.fn.zTree.getZTreeObj("tree");  
        var name='new node';  
        $.ajax({
    		url: '{{ URL("index/add-org/") }}/'+treeNode.id+'/'+name,
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
    });  
};  
function removeHoverDom(treeId, treeNode) {  
    $("#addBtn_"+treeNode.tId).unbind().remove();  
};

function onRename(e, treeId, treeNode, isCancel) {  
    console.log(treeNode);
	$.ajax({
		url: '{{ URL("index/update-org/") }}/'+treeNode.id+'/'+treeNode.name,
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
		url: '{{ URL("index/delete-org/") }}/'+treeNode.id,
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




function expandAll() {  
    if (!check()) {  
        return;  
    }  
    var zTree = $.fn.zTree.getZTreeObj("tree");  
    expandNodes(zTree.getNodes());  
    if (!goAsync) {  
        curStatus = "";  
    }  
} 
function check() {  
    if (curAsyncCount > 0) {  
        return false;  
    }  
    return true;  
}  

	$(function(){
		$.ajax({
			url: '{{ URL("index/all-org/") }}',
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
		zTreeObj = $.fn.zTree.init($(".ztree"), setting).expandAll(true);
                         setTimeout(function(){  
                                expandAll("tree");  
                             },1000);//延迟加载  
                	});
                            
                            ajaxTable = $('#example').DataTable( {
                                "type":"GET",
                                "ajax": '{{ URL("index/users-by-org/") }}'+'/'+1,
                                "columns": [
                                    { "data": "id"},
                                    { "data": "name" },
                                    { "data": "email" },
                                    { "data": "created_at", "class": "center" },
                                    { "data": "updated_at", "class": "center" },
                                    { "data": null}
                                ],
                                "fnRowCallback" : function(nRow, aData, iDisplayIndex) {
                                    
                                },
                                "lengthChange":false,
                            } );
</script>
@endsection