
@extends('adminlte::page')

@section('title', 'Admin LTE')

@section('content_header')

<h1>{{ $titles }}</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $titles }}</a></li>    
</ol>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('/admin/group')}}"><button class="btn btn-success btn-flat">Back</button></a>
    </div> 
</div>
@stop

@section('content')

<div class="box box-success color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $titles }} </h3>

    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 25%">Title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Group ID</td>
                        <td>{{$data['id']}}</td>
                    </tr>
                    <tr>
                        <td>Group Name</td>
                        <td>{{$data['name']}}</td>
                    </tr>
                    <tr>
                        <td>Group Unique Id</td>
                        <td>{{$data['group_flower_unique_id']}}</td>
                    </tr>
                    <tr>
                        <td>Group Owner Name</td>
                        <td>{{$data['groupuser']['first_name']}}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea id="description">{{$data['description']}}</textarea></td>
                    </tr>
                    <tr>
                        <td>Privacy</td>
                        <td>{{($data['privacy'] == 1) ? 'Public' : 'private'}}</td>
                    </tr>
                    <?php if($data['privacy'] == 0){?>
                    <tr>
                        <td>Password</td>
                        <td>{{$data['password']}}</td>
                    </tr>
                <?php }?>
                    <tr>
                        <td>Status</td>
                        <td>{{($data['status'] == 1) ? 'Active' :'In-Active'}}</td>
                    </tr>
                    <tr>
                        <td>Featured</td>
                        <td>{{($data['is_featured'] == 1) ? 'Featured Group' : 'Not Featured Group'}}</td>
                    </tr>
                </tbody>

            </table>
        </div>
        <h3>Group Members</h3>
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th style="width: 4%">#</th>
                        <th style="width: 30%">User Email</th>
                        <th style="width: 36%">Group Member Name</th>
                        <th style="width: 30%">Action</th>
                    </tr>
                </thead>
               

            </table>
        </div>

    </div>
</div>
<script src="{{asset('public/vendor/ckeditor4/ckeditor.js')}}"></script>
<script type="text/javascript">
    CKEDITOR.replace('description');

    $(document).ready(function () {
        var group_id = "{{$data['id']}}";
            mytable = $('#example1').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": "{{url('admin/group/groupMembers')}}",
                    "type": "POST",
                    data: {"_token": "{{ csrf_token() }}", "group_id": group_id},
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'group_flower_user.email', name: 'group_flower_user.email' },
                    { data: 'group_flower_user.first_name', name: 'group_flower_user.first_name' },
                    { data: 'action',name: 'action', orderable: false, searchable: false},
                   
                ]
            });

        $(document).on('click', '.data-member', function () {

            

            var id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Remove member from group!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: '{{url("admin/group/removeMember")}}',
                        data: {"_token": "{{ csrf_token() }}", "id": id, "group_id": group_id},
                        success: function (data) {
                            if (data.status == true) {
                                swal(data.message, {
                                    icon: "success",
                                });
                                 mytable.draw();
                            } else {
                                swal(data.message, {
                                    icon: "error",
                                });
                            }
                        }

                    });
                } else {
                    swal("Your user data is safe!");
                }
            });

        });
    });

</script>
@stop