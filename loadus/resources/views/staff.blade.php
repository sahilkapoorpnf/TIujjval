<?php

use App\User;
use App\Applicant;
use App\Application;
use App\Page;
?>
@extends('adminlte::page')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<div class="row">

    <a href="{{url('admin/applicant')}}">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fas fa-user-friends"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Applicant</span>
                    <span class="info-box-number">{{ count(Applicant::all())}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <a href="{{url('admin/application')}}">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fas fa-file-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Application</span>
                    <span class="info-box-number">{{  count(Application::all()->where('assign_to','=',auth()->user()->id))}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>



</div>

<div class="row">
    <div class="col-md-12">
        <!-- DIRECT CHAT -->
        <div class="box box-warning direct-chat direct-chat-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Direct Chat</h3>

                <div class="box-tools pull-right">
<!--                    <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="3 New Messages">3</span>-->
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" id="caht-history">

                    <?php
                    $query = DB::table('tbl_admin_staff_chat as a')->select('a.*', 'b.profile_image', 'b.name')->where('a.user_id', '=', auth()->user()->id)->orWhere([['a.to', '=', auth()->user()->id], ['a.from', '=', auth()->user()->id]])
                            ->leftJoin('users as b', 'a.from', '=', 'b.id');
//                    print_r($query->toSql()); die;
                    $data = $query->get();
//                    echo '<pre>';
//                    print_r($data);
//                    die;
                    foreach ($data as $val) {
                        $from = $val->from;
                        if ($val->from != auth()->user()->id) {
                            $clas = 'right';
                            $name = $val->name;
                            $img = $val->profile_image;
                        } else {
                            $clas = '';
                            $name = auth()->user()->name;
                            $img = auth()->user()->profile_image;
                        }
                        echo '<div class="direct-chat-msg ' . $clas . '">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name pull-right">' . $name . '</span>
                                        <span class="direct-chat-timestamp pull-left">' . date("F j, g:i a", strtotime($val->created_at)) . '</span>
                                    </div>
                                   
                                    <img class="direct-chat-img" src=' . '../' . $img . '>
                                   
                                    <div class="direct-chat-text">
                                        ' . $val->message . '
                                    </div>
                                </div>';
                    }
                    ?>
                </div>

            </div>
            <!--/.box-body -->
            <div class = "box-footer">
                <form action = "#" method = "post">
                    <div class = "input-group">
                        <input type="hidden" name="to" id="to" value="3">
                        <input type = "text" name = "message" id="message" placeholder = "Type Message ..." class = "form-control">
                        <span class="fileField">
                            <input type="file" name="file" id="chat_file">
                            <img src="{{url('public/front/images/file.png')}}">
                        </span>
                        <span class = "input-group-btn">
                            <button type = "button" class = "btn btn-warning btn-flat" id="send-message">Send</button>
                        </span>
                    </div>
                </form>
            </div>
            <!--/.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
</div>

@stop
@section('js')
<script>
    $(document).ready(function () {
        $("#send-message").click(function () {

            var to = $('#to').val();
            var message = $('#message').val();

            if (message != '' && to != '') {
                $.ajax({
                    type: "post",
                    url: "{{ url('/admin/adminchat') }}",
                    data: {"_token": "{{ csrf_token() }}", to: to, message: message},
                    cache: false,
                    success: function (result) {
                        if (result == 0) {
                            PNotify.error({
                                title: 'Error!',
                                delay: 2500,
                                text: 'Something went wrong please try again!'
                            });

                        } else {
                            $('#message').val('');
                            $("#caht-history").append(result);
                        }
                    }
                });
            } else {
                PNotify.error({
                    title: 'Error!',
                    delay: 2500,
                    text: 'Message field is required!'
                });
            }

        });
       

    });
</script>
@stop