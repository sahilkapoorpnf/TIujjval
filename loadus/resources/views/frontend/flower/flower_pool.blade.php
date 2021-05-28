@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')
<!--group pool -->
<section class="section avail-group groups">
    <div class="container">
        <div class="row top-panel">
            <aside class="col-lg-7">
                <div class="section-title">
                    <h2 class="title blue">Flower Pool</h2>
                </div>
            </aside>						
        </div>
        <div class="groups-wrap">
            <div class="row">

                <?php
                if (!empty($flowers)) {
                    foreach ($flowers as $flower) {
                        $flower_image = asset('public/uploads/flower') . "/" . $flower->image;
                        ?>
                        <!--  item group 1 -->
                        <div class="col-md-4">
                            <div class="wrap-shadow">
                                <div class="group-img">
                                    <img src="<?= $flower_image; ?>" alt="" />
                                </div>
                                <div class="group-content">
                                    <h4 class="flower_name"><?= $flower->name; ?></h4>
                                    <p><?= $flower->description; ?></p>
                                    <a href="" class="iocn-round bg-blue lock-open group_privacy" data-value="<?= $flower->privacy; ?>"></a>
                                </div>
                                <div class="d-flex join-btn clearfix">
                                    <div class="col-auto p-0 box-half">
                                        <!-- <a class="btn" href="#">Join Group</a> -->
                                        <?php if($flower->is_locked == 1){ ?>	
                                            <button class="btn" disabled data-id = "<?= Crypt::encryptString($flower->group_id);?>">Flower Locked</button>
                                            
                                        <?php }else if ($flower->user_id == Auth::guard('user')->user()->id) { ?>
                                            <button class="joinBtn invite_flower" data-id = "<?= Crypt::encryptString($flower->group_id); ?>">Invite User</button>

                                        <?php } else if (empty($flower->is_member)) { ?>
                                            <button class="joinBtn join_flower" data-id = "<?= Crypt::encryptString($flower->group_id); ?>">Join Flower</button>
                                        <?php } else if (($flower->is_member == 1) && $flower->sent_by == Auth::guard('user')->user()->id && $flower->is_accepted != 1) { ?>
                                            <button class="joinBtn cancel_flower_request" data-id = "<?= Crypt::encryptString($flower->group_id); ?>">Cancel Request</button>
                                        <?php } else if ($flower->is_member == 1 && $flower->sent_by != Auth::guard('user')->user()->id && $flower->is_accepted != 1) { ?>
                                            <button class="joinBtn accept_flower_request" data-id = "<?= Crypt::encryptString($flower->group_id); ?>">Accept Request</button>
                                        <?php } ?>
                                    </div>
                                    <div class="col pr-0 pl-2 box-half text-right">
                                        <div><strong>Open Positions</strong></div><div>2 Fire, 4 Air, 1  Earth</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                
                {{ $flowers->links() }}
            </div>
        </div>
    </div>
</section>
<!-- end group pool -->

<!-- Start Popup -->
<div class="modal fade modalIn" id="mod1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('public/frontend/img/close-btn.png') }}"></button>
                <div class="mdTitle">
                        <h2 class="title blue">Join Flower <!--<span>Position (fire position)</span>--></h2>
                </div>
                <hr>
                <div class="mdkData">
                    <div class="loginForm inviteUser profile pt-0">
                        <form id="joinRequest" method="post" class="form" role="form">
                            <div class="row">
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="name" name="name" placeholder="User Name" type="text" value="<?= Auth::guard('user')->user()->first_name ?>" />
                                    <input type="hidden" name="flower_id" id="flower_id">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"   />
                                    <div class="brd">&nbsp;</div>
                                </div>
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="flower_name" name="flower_name" placeholder="Flower Name" type="text"  />
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="name" name="name" placeholder="Email ID" type="text" value="<?= Auth::guard('user')->user()->email ?>" />
                                    <div class="brd">&nbsp;</div>
                                </div>
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="name" name="name" placeholder="Phone number" type="text" value="<?= Auth::guard('user')->user()->phone ?>" />
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                    <div class="col-md-12 form-group pb-2">
                                            <textarea class="form-control" placeholder="Description"></textarea>
                                            <div class="brd">&nbsp;</div>
                                    </div>
                            </div> -->
                            <div class="row">
                                <div class="col-md-6 form-group pb-2">
                                    <select class="form-control" id="tierSelect" name="position_id">
                                        <option data-display="Select Tier" selected disabled> Select Tier </option>
                                        <?php foreach ($total_positions as $positions) { ?>
                                            <option value="<?= $positions->id ?>" ><?= $positions->name ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div>								
                            <div class="row">
                                <div class="col-md-12 pt-lg-2 sendInv form-group d-flex justify-content-between align-items-center">
                                    <button>Send inviation</button>
                                </div>

                            </div>
                        </form>										
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	
<!-- close Popup -->

<!-- Start Popup -->
<div class="modal fade modalIn" id="mod2">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('public/frontend/img/close-btn.png') }}"></button>
                <div class="mdTitle">
                        <h2 class="title blue">Invite User to join Flower <!--<span>Position (fire position)</span>--></h2>
                </div>
                <hr>
                <div class="mdkData">
                    <div class="loginForm inviteUser profile pt-0">
                        <form id="inviteRequest" method="post" class="form" role="form">
                            
                            <div class="col-md-12 form-group pb-2">
                                <input class="form-control" id="userSelect123" name="email" placeholder="User Email" type="text"  />
                                <div class="brd">&nbsp;</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group pb-2">
                                    <!-- <select class="form-control" id="userSelect" name="userSelect">
                                        <option data-display="Select User" selected disabled> Select User </option>
                                        <?php foreach ($invitable_users as $positions) { ?>
                                            <option value="<?= $positions->id ?>" ><?= $positions->email ?></option>
                                        <?php } ?>
                                    </select> -->
                                    
                                    <input class="form-control" id="invite_name" name="invite_name" placeholder="User Name" type="text" value="" />

                                    <input type="hidden" name="invite_flower_id" id="invite_flower_id">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"   />
                                    <div class="brd">&nbsp;</div>
                                </div>
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="invite_flower_name" name="invite_flower_name" placeholder="Flower Name" type="text"  />
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="invite_name" name="invite_name" placeholder="User Name" type="text" value="" />
                                    <div class="brd">&nbsp;</div>
                                </div> -->
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="invite_phone" name="invite_phone" placeholder="Phone number" type="text" value="" />
                                    <div class="brd">&nbsp;</div>
                                </div>

                                <div class="col-md-6 form-group pb-2">
                                    <select class="form-control" id="tierSelect" name="position_id">
                                        <option data-display="Select Tier" selected disabled> Select Tier </option>
                                        <?php foreach ($total_positions as $positions) { ?>
                                            <option value="<?= $positions->id ?>" ><?= $positions->name ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="brd">&nbsp;</div>
                                </div>

                            </div>

                            <!-- <div class="row">
                                <div class="col-md-6 form-group pb-2">
                                    <select class="form-control" id="tierSelect" name="position_id">
                                        <option data-display="Select Tier" selected disabled> Select Tier </option>
                                        <?php foreach ($total_positions as $positions) { ?>
                                            <option value="<?= $positions->id ?>" ><?= $positions->name ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-12 pt-lg-2 sendInv form-group d-flex justify-content-between align-items-center">
                                    <button>Send inviation</button>
                                </div>

                            </div>
                        </form>										
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	
<!-- close Popup -->

<!-- Start Popup -->
<div class="modal fade modalIn" id="mod3">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('public/frontend/img/close-btn.png') }}"></button>
                <div class="mdTitle">
                        <h2 class="title blue">Accept Group <!--<span>Position (fire position)</span>--></h2>
                </div>
                <hr>
                <div class="mdkData">
                    <div class="loginForm inviteUser profile pt-0">
                        <form id="acceptGroupJoinRequest" method="post" class="form" role="form">
                            <div class="row">
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="name" name="name" placeholder="User Name" type="text" value="<?= Auth::guard('user')->user()->first_name ?>" />
                                    <input type="hidden" name="group_id" id="group_id_accept">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"   />
                                    <div class="brd">&nbsp;</div>
                                </div>
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="group_name_accept" name="group_name" placeholder="Group Name" type="text"  />
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group pb-2">
                                    <input class="form-control" id="password" name="password" placeholder="Enter group password" type="text" value="" />
                                    <div class="brd">&nbsp;</div>
                                </div>

                            </div>							
                            <div class="row">
                                <div class="col-md-12 pt-lg-2 sendInv form-group d-flex justify-content-between align-items-center">
                                    <button>Accept inviation</button>
                                </div>

                            </div>
                        </form>										
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	
<!-- close Popup -->
<script type="text/javascript" src="{{asset('public/frontend/js/chosen.jquery.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>

<script>
$(document).ready(function () {

    $("body").on('click', '.invite_flower', function () {
        $('#mod2').modal('show');
        var id = $(this).data('id');
        var flower_name = $(this).parents('.wrap-shadow').find('.flower_name').text();
        // alert(flower_name);
        $('#invite_flower_id').val(id);
        $('#invite_flower_name').val(flower_name);

        $.ajax({
            url: '<?php echo action('GroupController@getInvitableFlowerMembers') ?>',
            type: "post",
            data: {"_token": "{{ csrf_token() }}", "id": id},
            dataType: 'json',
            success: function (data) {
                $("#userSelect").html(data);
            },
            error: function (xhr, err) {
                var errMsg = formatErrorMessage(xhr, err);
                showMessage(errMsg, success = false);
            }
        });

        $.ajax({
            url: '<?php echo action('GroupController@getflowerpositions') ?>',
            type: "post",
            data: {"_token": "{{ csrf_token() }}", "id": id},
            dataType: 'json',
            success: function (data) {
                $("#mod2").find("#tierSelect").html(data);
            },
            error: function (xhr, err) {
                var errMsg = formatErrorMessage(xhr, err);
                showMessage(errMsg, success = false);
            }
        });
    });

    $("body").on('click', '.join_flower', function () {
        $('#mod1').modal('show');
        var id = $(this).data('id');
        var flower_name = $(this).parents('.wrap-shadow').find('.flower_name').text();
        $('#flower_id').val(id);
        $('#flower_name').val(flower_name);

        $.ajax({
            url: '<?php echo action('GroupController@getflowerpositions') ?>',
            type: "post",
            data: {"_token": "{{ csrf_token() }}", "id": id},
            dataType: 'json',
            success: function (data) {
                $("#tierSelect").html(data);
            },
            error: function (xhr, err) {
                var errMsg = formatErrorMessage(xhr, err);
                showMessage(errMsg, success = false);
            }
        });


    });

    $('body').on('change', '#userSelect', function () {
        var user_id = $(this).val();
        $.ajax({
            url: '<?php echo action('GroupController@getUserDetails') ?>',
            type: "post",
            data: {"_token": "{{ csrf_token() }}", "id": user_id},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#invite_phone').val(data.phone);
                $('#invite_name').val(data.first_name);
            },
            error: function (xhr, err) {
                var errMsg = formatErrorMessage(xhr, err);
                showMessage(errMsg, success = false);
            }
        });
    });

    $('body').on('change','#userSelect123', function(){
        var email = $(this).val();
        $.ajax({
            url:'<?php echo action('GroupController@checkUser') ?>',
            type:"post",
            data: {"_token": "{{ csrf_token() }}","email":email},
            dataType:'json',
            success:function(data){
                // console.log(data);
                // if(data.is_user == true){
                    $('#invite_phone').val(data.phone);
                    $('#invite_name').val(data.first_name);
                // }	
            },
            error: function (xhr, err) {
                var errMsg = formatErrorMessage(xhr, err);
                showMessage(errMsg, success=false);
            }
        });
    });

    $('#inviteRequest').validate({
        rules: {
            "id": {required: true},
            "position_id": {required: true},
            // "userSelect": {required: true},
            "email": {required: true, email: true}
        },
        messages: {
            "id": {required: "Please enter flower name"},
            "position_id": {required: "Please select tier"},
            // "userSelect": {required: "Please select user"},
				"email":{required: "Please enter a email", email: "Please enter valid email"}
        },

        submitHandler: function () {
            $.ajax({
                url: '<?php echo action('GroupController@flower_invite_request') ?>',
                type: "POST",
                data: new FormData($('#inviteRequest')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status === true) {
                        // window.location.reload();
                        window.location.href = "{{url('flower-pool')}}";
                    } else {
                        showMessage(data.msg, success = false);
                    }
                },
                error: function (xhr, err) {
                    var errMsg = formatErrorMessage(xhr, err);
                    showMessage(errMsg, success = false);
                }
            });
        },
    });

    $('#joinRequest').validate({
        rules: {
            "id": {required: true},
            "position_id": {required: true},
        },
        messages: {
            "id": {required: "Please enter group name"},
            "position_id": {required: "Please select tier"},
        },

        submitHandler: function () {
            $.ajax({
                url: '<?php echo action('GroupController@flower_join_request') ?>',
                type: "POST",
                data: new FormData($('#joinRequest')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status === true) {
                        // window.location.reload();
                        window.location.href = "{{url('flower-pool')}}";
                    } else {
                        showMessage(data.msg, success = false);
                    }
                },
                error: function (xhr, err) {
                    var errMsg = formatErrorMessage(xhr, err);
                    showMessage(errMsg, success = false);
                }
            });
        },
    });

    $('body').on('click', '.cancel_flower_request', function () {

        var group_id = $(this).data('id');

        $.ajax({
            url: '<?php echo action('FlowerController@flower_join_cancel_request') ?>',
            type: "POST",
            data: {"_token": "{{ csrf_token() }}", "group_id": group_id},
            dataType: 'json',
            beforeSend: function () {
                return confirm("Are you sure you wanted to cancel this request ?");
            },
            success: function (data) {
                if (data.status === true) {
                    // window.location.reload();
                    window.location.href = "{{url('flower-pool')}}";
                } else {
                    showMessage(data.msg, success = false);
                }
            },
            error: function (xhr, err) {
                var errMsg = formatErrorMessage(xhr, err);
                showMessage(errMsg, success = false);
            }
        });

    });

    $('body').on('click', '.accept_flower_request', function () {

        var group_privacy = $(this).parents('.wrap-shadow').find('.group_privacy').data('value');
        var group_id = $(this).data('id');
        if (group_privacy == 1) {
            $.ajax({
                url: '<?php echo action('FlowerController@acceptFlowerMember') ?>',
                type: "POST",
                data: {"_token": "{{ csrf_token() }}", "group_id": group_id},
                dataType: 'json',
                beforeSend: function () {
                    return confirm("Are you sure you wanted to accept this request ?");
                },
                success: function (data) {
                    if (data.status === true) {
                        // window.location.reload();
                        window.location.href = "{{url('flower-pool')}}";
                    } else {
                        showMessage(data.msg, success = false);
                    }
                },
                error: function (xhr, err) {
                    var errMsg = formatErrorMessage(xhr, err);
                    showMessage(errMsg, success = false);
                }
            });
        } else {
            $('#mod3').modal('show');
            var id = $(this).data('id');

            var group_name = $(this).parents('.wrap-shadow').find('.group_name').text();

            $('#group_id_accept').val(id);
            $('#group_name_accept').val(group_name);

            $('#acceptGroupJoinRequest').validate({
                rules: {
                    "id": {required: true},
                    "password": {required: true}
                },
                messages: {
                    "id": {required: "Please enter group name"},
                    "password": {required: "Please enter password"}
                },

                submitHandler: function () {
                    $.ajax({
                        url: '<?php echo action('FlowerController@acceptFlowerMember') ?>',
                        type: "POST",
                        data: new FormData($('#acceptGroupJoinRequest')[0]),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            if (data.status === true) {
                                // window.location.reload();
                                window.location.href = "{{url('flower-pool')}}";
                            } else {
                                showMessage(data.msg, success = false);
                            }
                        },
                        error: function (xhr, err) {
                            var errMsg = formatErrorMessage(xhr, err);
                            showMessage(errMsg, success = false);
                        }
                    });
                },
            });
        }
    });




});
</script>
@endsection