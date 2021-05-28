
@extends('front.layouts.default')
@section('content')
<section class="banner innerBanner"><img class="img-fluid" src="{{ asset('public/front') }}/images/visa-banner.jpg" width="1349" height="970">
    <div class="pageHeading">
        <div class="container">
            <h1>Travidocs <span>404 page not found</span></h1>
        </div>
    </div>
</section>
<section class="pageBreadcrumb">
    <div class="container">
        <div class="row">
            <aside class="col-sm-12">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">404 page not found</li>
                </ul>
            </aside>
        </div>
    </div>
</section>
<img class="img-fluid" src="{{ asset('public/front') }}/images/my404.png" width="1349" height="970">

@stop

