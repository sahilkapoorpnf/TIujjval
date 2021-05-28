@extends('adminlte::page')

@section('title', "$title")

@section('content_header')
<?php //echo ActionButton(1); ?>
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<?php //echo CreateButton(); ?>

<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('admin/subscription/create')}}"><button class="btn btn-success btn-flat" data-toggle="tooltip" title="" data-original-title="Create Page">Create Subscription</button></a>
    </div> 
</div>


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
                        <th>Sr. No.</th>
                        <th>User Email</th>
                        <th>Subscription Type</th>
                        <th>Subscription Rate</th>
                        <th>Buy Date</th>
                        <th>Expiry Date</th>
                        <th>Balance Day</th>
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
                "url": "getusersubs",
                data: {"_token": "{{ csrf_token() }}"},
                "type": "POST"
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
                text: "Delete this  data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                    .then((willDelete) => {

                        if (willDelete) {
                            $.ajax({
                                type: 'POST',
                                url: 'deletesubs',
                                data: {"_token": "{{ csrf_token() }}", id: id},
                                success: function (data) {
                                    if (data == 1) {
                                        swal("Success! Data  has been deleted!", {
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
                            swal("Your  data is safe!");
                        }
                    });

        })




    });

</script>

@stop