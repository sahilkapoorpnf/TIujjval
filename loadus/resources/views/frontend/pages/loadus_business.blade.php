@extends('layouts.base')
@section('title')
{{ $title }}
@endsection

@section('content')
<section class="slider">
   <div class="home-slider owl-carousel">
      <!--  item slider 1 -->
      <div class="item">
         <div class="slide-img">
            <img src="{{asset('public/frontend/img/loadus_business.jpeg')}}" alt="" />
         </div>
         <div class="container">
            <div class="slide-content">
               
            </div>
         </div>
      </div>
   </div>
</section>

<section class="section avail-group">
    <div class="container">
        <div class="section-title">
        <h2 class="title blue">Loadus Business Directory Coming soon...</h2>
        </div>
        <div class="available-group-wrap">
        

              
        </div>
    </div>
</section>

@endsection