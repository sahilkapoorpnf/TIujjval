@extends('layouts.base')
@section('title')
LOADUS
@endsection

@section('content')

<section class="dashbaord p-0 groups-aside groups">
    <button class="menu-btn"><img src="{{asset('public/frontend/img/menu.png')}}"></button>
    <div class="container">
        <div class="row d-flex align-items-stretch">
            @include('layouts.left_sidebar')

            <div class="col">
                <div class="dshContent">
                    <h2 class="title blue">Notifications</h2>
                    <hr>
                    <ul class="notiMsg">
                        <?php
                        foreach ($notifications as $noti) {
                            ?>
                            <li><b><?= trim($noti->first_name . ' ' . $noti->last_name) ?></b> <?= $noti->description; ?></li>
                            <!-- <li>Your request is accepted to join Group ID 587489 at fire level</li> -->
                        <?php } ?>

                    </ul>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection