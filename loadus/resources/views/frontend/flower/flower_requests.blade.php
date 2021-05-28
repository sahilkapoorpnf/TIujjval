@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')


<section class="dashbaord p-0">
    <button class="menu-btn"><img src="img/menu.png"></button>
    <div class="container">
        <div class="row d-flex align-items-stretch">
            <!-- left side -->
            @include('layouts.left_sidebar')
            <!-- end side menu -->
            <!-- right side -->
            <div class="col">
                <div class="dshContent">
                    <h2 class="title blue">Flower Requests</h2>
                    <hr>
                    <ul class="notiMsg">

                        <?php
                        foreach ($flower_requests as $req) {
                            $group_owner_details = userDetails($req->group_owner_id);
                            if ($req->group_owner_id == (Auth::guard('user')->user()->id) && $req->group_owner_id == $req->sent_by) {

                                $text = 'You have invited <b>' . $req->first_name . '</b> to join your flower <a href="flower-details/' . $req->group_id . '"><b>' . $req->group_name . '</b> at <b>' . $req->position_name . '</b></a>';
                                $html = '<a class="btn del ml-2 cancelInvite" href="javascript:void(0)" data-id="' . Crypt::encryptString($req->gfm_Id) . '">Cancel Invite</a>';
                            } else if ($req->group_owner_id == (Auth::guard('user')->user()->id) && $req->group_owner_id != $req->sent_by) {

                                $text = '<b>' . $req->first_name . '</b> has requested you to join your flower <a href="flower-details/' . $req->group_id . '"><b>' . $req->group_name . '</b> at <b>' . $req->position_name . '</b></a>';
                                $html = '<a class="btn acp acceptInvite" href="javascript:void(0)" data-id="' . Crypt::encryptString($req->gfm_Id) . '">Accept invite</a>
									<a class="btn del ml-2 rejectInvite" href="javascript:void(0)" data-id="' . Crypt::encryptString($req->gfm_Id) . '">Reject invite</a>';
                            } else if ($req->group_owner_id != (Auth::guard('user')->user()->id) && $req->member_id == (Auth::guard('user')->user()->id) && $req->sent_by == (Auth::guard('user')->user()->id)) {

                                $text = 'You have requested <b>' .$group_owner_details->first_name . '</b> to join his flower <a href="flower-details/' . $req->group_id . '"><b>' . $req->group_name . '</b> at <b>' . $req->position_name . '</b></a>';
                                $html = '<a class="btn acp cancelJoin" href="javascript:void(0)" data-id="' . Crypt::encryptString($req->gfm_Id) . '">Cancel Join</a>';
                            } else if ($req->group_owner_id != (Auth::guard('user')->user()->id) && $req->member_id == (Auth::guard('user')->user()->id) && $req->sent_by != (Auth::guard('user')->user()->id)) {

                                // $group_owner_details = userDetails($req->group_owner_id);

                                $text = '<b>' . $group_owner_details->first_name . '</b> has invited you to join his flower <a href="flower-details/' . $req->group_id . '"><b>' . $req->group_name . '</b> at <b>' . $req->position_name . '</b></a>';
                                $html = '<a class="btn acp acceptJoin" href="javascript:void(0)" data-id="' . Crypt::encryptString($req->gfm_Id) . '">Accept Join</a>
									<a class="btn del ml-2 rejectJoin" href="javascript:void(0)" data-id="' . Crypt::encryptString($req->gfm_Id) . '">Reject Join</a>';
                            }
                            ?>
                            <li class="d-flex justify-content-sm-end parentLi" data-privacy="<?= $req->privacy ?>">
                                <div class="col group_name" data-groupname="<?= $req->group_name; ?>"><!--<a href="">--><?php //echo $req->group_name;     ?> <!--</a>--> <?= $text; ?></div>
                                <div class="col text-right" data-group="<?= Crypt::encryptString($req->group_id) ?>">
                                    <?= $html; ?>
                                </div>
                            </li>


                        <?php } ?>
                            {{ $flower_requests->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Start Popup -->
<div class="modal fade modalIn" id="mod3">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('public/frontend/img/close-btn.png') }}"></button>
                <div class="mdTitle">
                        <h2 class="title blue">Accept Flower <!--<span>Position (fire position)</span>--></h2>
                </div>
                <hr>
                <div class="mdkData">
                    <div class="loginForm inviteUser profile pt-0">
                        <form id="acceptFlowerJoinRequest" method="post" class="form" role="form">
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
                                    <button>Submit</button>
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

<script>
    $(document).ready(function () {
        $("body").on('click', '.cancelInvite', function () {

            var gfm_id = $(this).data('id');
            var group_id = $(this).parent().data('group');
            // alert(group_id);
            // return false;

            $.ajax({
                url: '<?php echo action('FlowerController@cancelInvite') ?>',
                type: "post",
                data: {"_token": "{{ csrf_token() }}", "gfm_id": gfm_id, "group_id": group_id},
                dataType: 'json',
                beforeSend: function () {
                    return confirm("Are you sure you wanted to cancel this invitation ?");
                },
                success: function (data) {
                    if (data.status === true) {
                        // window.location.reload();
                        window.location.href = "{{url('flower-join-request-list')}}";
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
        /*** logged in user get invitation from other group admin */
        $('body').on('click', '.acceptJoin', function () {

            var group_privacy = $(this).parents('.parentLi').data('privacy');
            var group_id = $(this).parent().data('group');
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
                            window.location.href = "{{url('flower-join-request-list')}}";
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
                var id = $(this).parent().data('group');

                var group_name = $(this).parents('.parentLi').find('.group_name').data('groupname');

                $('#group_id_accept').val(id);
                $('#group_name_accept').val(group_name);

                $('#acceptFlowerJoinRequest').validate({
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
                            data: new FormData($('#acceptFlowerJoinRequest')[0]),
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                if (data.status === true) {
                                    // window.location.reload();
                                    window.location.href = "{{url('flower-join-request-list')}}";
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
        /****************Working****************** */
        $('body').on('click', '.cancelJoin', function () {

            var group_id = $(this).parent().data('group');

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
                        window.location.href = "{{url('flower-join-request-list')}}";
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

        $("body").on('click', '.rejectInvite', function () {

            var gfm_id = $(this).data('id');
            var group_id = $(this).parent().data('group');
            // alert(group_id);
            // return false;

            $.ajax({
                url: '<?php echo action('FlowerController@rejectInvite') ?>',
                type: "post",
                data: {"_token": "{{ csrf_token() }}", "gfm_id": gfm_id, "group_id": group_id},
                dataType: 'json',
                beforeSend: function () {
                    return confirm("Are you sure you wanted to reject this request ?");
                },
                success: function (data) {
                    if (data.status === true) {
                        // window.location.reload();
                        window.location.href = "{{url('flower-join-request-list')}}";
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

        $("body").on('click', '.rejectJoin', function () {

            var gfm_id = $(this).data('id');
            var group_id = $(this).parent().data('group');
            // alert(group_id);
            // return false;

            $.ajax({
                url: '<?php echo action('FlowerController@rejectJoin') ?>',
                type: "post",
                data: {"_token": "{{ csrf_token() }}", "gfm_id": gfm_id, "group_id": group_id},
                dataType: 'json',
                beforeSend: function () {
                    return confirm("Are you sure you wanted to reject this request ?");
                },
                success: function (data) {
                    if (data.status === true) {
                        // window.location.reload();
                        window.location.href = "{{url('flower-join-request-list')}}";
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

        $("body").on('click', '.acceptInvite', function () {

            var gfm_id = $(this).data('id');
            var group_id = $(this).parent().data('group');
            // alert(group_id);
            // return false;

            $.ajax({
                url: '<?php echo action('FlowerController@acceptInvite') ?>',
                type: "post",
                data: {"_token": "{{ csrf_token() }}", "gfm_id": gfm_id, "group_id": group_id},
                dataType: 'json',
                beforeSend: function () {
                    return confirm("Are you sure you wanted to accept this request ?");
                },
                success: function (data) {
                    if (data.status === true) {
                        // window.location.reload();
                        window.location.href = "{{url('flower-join-request-list')}}";
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



    });
</script>
@endsection
