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
                    <div class="row top-panel">
                        <aside class="col-lg-7">
                            <div class="section-title">
                                <h2 class="title blue">Member Subscription</h2>
                            </div>
                        </aside>
                        <aside class="col-lg-5 d-flex tierTp justify-content-end align-items-center">
                            {{ link_to_action('SubscriptionController@subscription_list','Buy Plan', null, array('class' => 'joinBtn')) }} 
                        </aside>
                    </div>
                    <div class="Subscription-plan text-center d-sm-flex justify-content-sm-center">
                        @if(!empty($subscription))
                        @foreach ($subscription as $subs)
                        <div class="plan-box">
                            <div class="plan-type">
                                <h3>{{ $subscriptionType[$subs->subscription_type] }}</h3>
                            </div>
                            <div class="price">
                                <span>${{$subs->subscription_rate}}</span>
                            </div>
                            <div class="plan-description">
                                <p>{{ strip_tags($subs->description) }}</p>
                            </div>
                            <a class="btn" href="#">{{ $subs->balance_day }} Days</a>						
                        </div>
                        @endforeach
                        @else
                        <div class="plan-box">
                            <div class="plan-type">
                                <h3>Plan</h3>
                            </div>
                            <div class="price">
                                <span>NA</span>
                            </div>
                            <div class="plan-description">
                                <p>Currently You Don't have any plan. Please buy.</p>
                            </div>
                            {{ link_to_action('SubscriptionController@subscription_list','Buy Plan', null, array('class' => 'btn')) }} 					
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{asset('public/frontend/js/chosen.jquery.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>

@endsection
<script>
$(document).ready(function () {
    $(document).on('click', '.buy-subs', function (e) {
        e.preventDefualt();
        var id = $(this).attr('subs-rate');
        alert(id);
        return false;
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