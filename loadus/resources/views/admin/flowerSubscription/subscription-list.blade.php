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
                                <h2 class="title blue">Flower Subscription Plan</h2>
                            </div>
                        </aside>
                        <aside class="col-lg-5 d-flex tierTp justify-content-end align-items-center">
                            <!--{{ link_to_action('SubscriptionController@my_subscription','Back', null, array('class' => 'joinBtn')) }}--> 
                        </aside>
                    </div>
                    <div class="Subscription-plan text-center d-sm-flex justify-content-sm-center">
                        @foreach ($subscription as $subs)
                        <div class="plan-box">
                            <div class="plan-type">
                                <h3>{{ $subs->plan_name }}</h3>
                            </div>
                            <div class="price">
                                <span>${{$subs->plan_rate}}</span>
                            </div>
                            <div class="plan-description">
                                <p>{{ strip_tags($subs->description) }}</p>
                            </div>
                            <a class="btn buy-subs" href="{{ URL('/stripe/'.Crypt::encryptString($subs->id ))}}">Buy</a>						
                        </div>
                        @endforeach
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{asset('public/frontend/js/chosen.jquery.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>

@endsection
