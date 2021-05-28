@extends('adminlte::page')
<?php $title = "Users"; ?>
@section('title', "$title")

@section('content_header')
<h1>User</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<?php //echo CreateButton(); ?>
<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('Import-User-Csv-Sample.csv')}}"><button class="btn btn-primary btn-flat fa fa-download csvDemo" data-toggle="tooltip" title="" data-original-title="Csv Sample"></button></a>
        <a href="#"><button class="btn btn-primary btn-flat fa fa-upload importUser" data-toggle="tooltip" title="" data-original-title="Import User">Import User</button></a>
        <a href="user/create"><button class="btn btn-success btn-flat" data-toggle="tooltip" title="" data-original-title="Create User">Create User</button></a>
    </div> 
</div>

@stop

@section('content')
<div id="success"></div>
<div id="failed"></div>

<div class="box box-success color-palette-box">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $title }}</h3>        
    </div>
    <div class="box-body">
        <div class="table-responsive">

        <table id="example" class="table table-bordered table-striped dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                    <?php //echo ActionColumn(); ?>

                </tr>
            </thead>

        </table>
        </div>
    </div>
</div>
<!-- Start Popup -->
<div class="modal fade modalIn" id="mod2">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('public/frontend/img/close-btn.png') }}"></button>
                <div class="mdTitle">
                    <h2 class="title blue">Import User</h2>
                </div>
                <hr>
                <div class="mdkData">
                    <div class="loginForm inviteUser profile pt-0">
                        <?php $action = 'admin/user/uploadUserCsv'; ?>
                        {{ Form::open(array('url' => $action,'id'=>'myForm','autocomplete'=>'off', 'enctype'=>"multipart/form-data")) }}
                        <!--<form id="upload_form" method="post" class="form" role="form" enctype="multipart/form-data">-->
                        <div class="row">
                            <div class="col-md-6 form-group pb-2">
                                <input class="form-control" id="csv_file" name="import_user"  type="file" value="" />
                                <div class="brd">&nbsp;</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 pt-lg-2 sendInv form-group d-flex justify-content-between align-items-center">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"   id="csrf_token"/>
                                <button>Upload</button>
                            </div>

                        </div>
                        {{ Form::close() }}
                        </form>										
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	
<!-- close Popup -->
<script>
    var mytable;
    $(document).ready(function () {
        mytable = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": "userdata",
                "type": "POST",
                data: {"_token": "{{ csrf_token() }}"},
            },
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'full_name', name: 'full_name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action',name: 'action', orderable: false, searchable: false},
                   
                  ]

        });
    });
</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.status-data', function () {
            var id = $(this).data('status');

            swal({
                title: "Are you sure?",
                text: "Change Status for this user data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'user/statusChange',
                        data: {"_token": "{{ csrf_token() }}", id: id},
                        success: function (data) {
                            if (data.status == true) {
                                swal("Success! User  has been Updated!", {
                                    icon: "success",
                                });
                                mytable.draw();
                            } else {
                                swal("Error! Something went wrong", {
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

        $(document).on('click', '.delete-data', function () {
            var id = $(this).data('delete');

            swal({
                title: "Are you sure?",
                text: "Delete this user data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'user/deleteuser',
                        data: {"_token": "{{ csrf_token() }}", id: id},
                        success: function (data) {
                            if (data.status == true) {
                                swal("Success! User  has been deleted!", {
                                    icon: "success",
                                });
                                mytable.draw();
                            } else {
                                swal("Error! Something went wrong", {
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

    $(document).ready(function () {

        $("body").on('click', '.importUser', function () {
            $('#mod2').modal('show');
        });
    });

</script>


@stop