@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6">
        <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">用户列表</h3>
              </div>
              <div class="panel-body">
                <table id="example" class="demo hover dataTable" role="grid" aria-describedby="demo1_info">
                       <thead>
                            <tr role="row">
                                <th>编号</th>
                                <th>用户名</th>
                                <th>邮箱</th>
                            </tr>
                        </thead>
                  </table>
              </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">角色分配</h3>
            </div>
            <div class="panel-body">
                <select class="js-example-programmatic-multi" multiple="" style="width:100%;">
                    <option></option>
                </select>
            </div>
            <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                <a class="btn btn-success" href="javascript:void(0);" role="button" onclick="save()">保存</a>
                <a class="btn btn-default" href="javascript:void(0);" role="button" onclick="reset()">重置</a>
            </div>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function trClick(userId) {
    $.ajax({
        type:'GET',
        async: false,
        url:'{{ URL("admin/user-role/find-by-user") }}/' + userId,
        success:function(e){
            //console.log(e);
            multiSelect.val(null).trigger("change");
            var array = [];
            for(var i = 0; i<e.length; i++){
                array.push(e[i].id);
            }
            multiSelect.val(array).trigger("change");
        },error:function(e){
            console.log(e.responseText);
        }
    });
}
function save(){
    var array = multiSelect.val();
    //console.log(array);
    $.ajax({
        type:'POST',
        async: false,
        data: {data : array},
        url:'{{ URL("admin/user-role/store-by-user") }}/'+userId,
        success:function(data){
            console.log(data);
            toastr.info("保存角色成功");
        },error:function(e){
            console.log(e.responseText);
        }
    });
}
function reset() {
    trClick(userId);
}
$(function(){
    userId = 0;
    dataList = [];
    ajaxTable = $('#example').DataTable( {
        "type":"GET",
        "ajax": '{{ URL("admin/user-role/all-users") }}',
        "columns": [
            { "data": "id"},
            { "data": "name" },
            { "data": "email" }
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
            multiSelect.val(null).trigger("change");
        }
        else {
            ajaxTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //调用选中用户的角色列表
            var rowData = ajaxTable.rows('.selected').data();
            trClick(rowData[0].id);
            userId = rowData[0].id ;
        }
    } );
    $.ajax({
        type:'GET',
        async: false,
        url:'{{ URL("admin/user-role/all-roles") }}',
        success:function(data){
            //console.log(data);
            for (var i = 0; i < data.length; i ++){
                dataList.push({
                    id:data[i].id,
                    text:data[i].name,
                });
            }
        },error:function(e){
            console.log(e.responseText);
        }
    });
    multiSelect = $('.js-example-programmatic-multi').select2({
      data: dataList,
      minimumResultsForSearch: Infinity,
      placeholder:'请选择用户'
    });
});
</script>
@endsection