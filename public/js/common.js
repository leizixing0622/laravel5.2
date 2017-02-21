$.ajaxSetup({
	headers:{'X-CSRF-Token' : $('meta[name=_token]').attr('content')}
});
(function($){  
  $.fn.serializeObject = function() {  
    if ( !this.length ) { return false; }  
  
    var $el = this,  
      data = {},  
      lookup = data; //current reference of data  
  
      $el.find(':input[type!="checkbox"][type!="radio"], input:checked').each(function() {  
        // data[a][b] becomes [ data, a, b ]  
        var named = this.name.replace(/\[([^\]]+)?\]/g, ',$1').split(','),  
            cap = named.length - 1,  
            i = 0;  
  
        for ( ; i < cap; i++ ) {  
            // move down the tree - create objects or array if necessary  
            lookup = lookup[ named[i] ] = lookup[ named[i] ] ||  
                ( named[i+1] == "" ? [] : {} );  
        }  
  
        // at the end, psuh or assign the value  
        if ( lookup.length != undefined ) {  
             lookup.push( $(this).val() );  
        }else {  
              lookup[ named[ cap ] ]  = $(this).val();  
        }  
  
        // assign the reference back to root  
        lookup = data;  
      });  
  
    return data;  
  };  
})(jQuery);  

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
function fns(datar,pid){
    var result = [] , temp;
    for(var i in datar){
        if(datar[i].pid==pid){
            result.push(datar[i]);
            temp = fns(datar,datar[i].id);           
            if(temp.length>0){
                datar[i].children=temp;
            }           
        } 
    }
    return result;
}
function sf(a){
    if(!a){return ''}
    var html='';
    for(var i=0;i<a.length;i++){
      if(a[i].children != undefined){
    	  html+='<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'+a[i].display_name+'<span class="caret"></span></a><ul class="dropdown-menu">';
    	  html+=sf(a[i].children);
    	  html+='</ul></li>\n';
      }else{
    	  html+='<li><a href="#">'+a[i].display_name+'</a></li>';
      }
    };
    return html;
}