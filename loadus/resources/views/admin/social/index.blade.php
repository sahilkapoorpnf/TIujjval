@extends('adminlte::page')

@section('title', "$title")

@section('content_header')

<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<?php echo CreateButton(); ?>


@stop

@section('content')
<div id="success"></div>
<div id="failed"></div>

<div class="box box-success color-palette-box">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $title }}</h3>
        <!--<button class="btn btn-success btn-flat pull-right">Add </button>-->
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Icon</th>
                        <th>Status</th>
                        <th>Action</th>
                        <?php// echo ActionColumn(); ?>


                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    var mytable;
    $(document).ready(function () {
        mytable = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": "{{url('admin/socialdata')}}",
                "type": "POST",
                data: {
                    "_token": "{{ csrf_token() }}"                   
                }
            }

        });
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-data', function () {
            var id = $(this).data('delete');

            swal({
                title: "Are you sure?",
                text: "Delete this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                    .then((willDelete) => {

                        if (willDelete) {
                            $.ajax({
                                type: 'POST',
                                url: 'social/delete',
                                data: {"_token": "{{ csrf_token() }}", id: id},
                                success: function (data) {
                                    if (data == 1) {
                                        swal("Success! Data  has been deleted successfully!", {
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

        })




    });

</script>

@stop