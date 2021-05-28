@extends('adminlte::page')
@section('title', "$title")

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
       <a href="{{url('admin/flower')}}"><button class="btn btn-success btn-flat" data-toggle="tooltip" title="" data-original-title="Back">Back</button></a>
    </div> 
    <p>Flower ID : {{$data->id}}</p>
    <p>Flower Owner Name / Water Position User : {{$data->groupuser->first_name}}</p>
</div>

@stop

@section('content')
<div id="success"></div>
<div id="failed"></div>

<div class="box box-success color-palette-box">
   

    <div class="box-header with-border">
        <h3 class="box-title">Flower Name : {{ $data->name }}</h3>        
    </div>
    <div class="box-body">
        <form name="add_members_form" id="add_members_form">
            <input type="hidden" value="{{$data->id}}" name="group_id" id="group_id">
            <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Select Members</th>

                    </tr>
                </thead>

            </table>

            </div>
            <div class="card-footer">
              <button id="submitButton" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    var mytable;
    $(document).ready(function () {
        var group_id = $('#group_id').val();
        mytable = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": "{{url('admin/flower/getuserdata')}}",
                "type": "POST",
                data: {"_token": "{{ csrf_token() }}", "group_id": group_id},
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'first_name', name: 'first_name' },
                { data: 'email', name: 'email' },
                { data: 'action',name: 'action', orderable: false, searchable: false},
               
            ]
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '#submitButton', function () {
            var users_table = $('#example').dataTable();
            var user_matches = [];
            var rowcollection =  users_table.$(".user_check:checked", {"page": "all"});

            rowcollection.each(function(index,elem){
                var checkbox_value = $(elem).data('id');
                user_matches.push(checkbox_value);
            });

            var userIds = user_matches;
            var group_id = $('#group_id').val();

            if(Array.isArray(userIds) && userIds.length){
                swal({
                    title: "Are you sure?",
                    text: "Add Members to the Flower!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willSubmit) => {
                    if (willSubmit) {
                        $.ajax({
                            type: 'POST',
                            url: '{{url("admin/flower/addgroupmember")}}',
                            data: {"_token": "{{ csrf_token() }}", "userIds": userIds, "group_id": group_id },
                            success: function (data) {
                                if (data.status == true) {
                                    window.location.href = "{{url('/admin/flower')}}";
                                } else {
                                    swal("Error! Something went wrong", {
                                        icon: "error",
                                    });
                                }
                            }

                        });
                    } else {
                        swal("Cancelled", "No user added to the group:)", "error");
                    }
                });
            }else{
                swal("Please select at least one user", {
                    icon: "error",
                });
            }
            return false;
        });
        

    });

</script>


@stop