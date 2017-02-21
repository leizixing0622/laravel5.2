@extends('app')

@section('content')
<div class="container">
  <div class="row">
  	<div class="col-md-10 col-md-offset-1">
  		<div class="panel panel-info">
  		      <div class="panel-heading">
			    <h3 class="panel-title">用户管理</h3>
			  </div>
			  <div class="panel-body">
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
  		</div>
  	</div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	ajaxTable = $('#example').DataTable( {
        "type":"GET",
        "ajax": '{{ URL("admin/user/all") }}',
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
})
</script>
@endsection