@extends('layouts.base')
@section('title')
LOADUS
@endsection
@section('content')<!-- Slider -->
<?php if(!empty($banner)){?>
<section class="slider">
   <div class="home-slider owl-carousel">
      <!--  item slider 1 -->
      <div class="item">
         <div class="slide-img">
            <img src="{!! asset($banner->banner_image) !!}" alt="" />
         </div>
         <div class="container">
            <div class="slide-content">
               <h1>{!! $banner->banner_name !!}</h1>
               <p>{!! $banner->description !!}</p>
               <a class="btn" href="{{ $banner->read_more_link }}" target="_blank">Read More</a>
            </div>
         </div>
      </div>
      <!--  item slider 2 -->
      <!-- <div class="item">
         <div class="slide-img">
            <img src="{{asset('public/frontend/img/slide01.jpg')}}" alt="" />
         </div>
         <div class="container">
            <div class="slide-content">
               <h1>Set up business meetings for more than 100 people!</h1>
               <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
               <a class="btn" href="">Read More</a>
            </div>
         </div>
      </div>          -->
   </div>
</section>
<?php } ?>
<!--End .Slider-->
<main>
   <!--create.Group -->
   <section class="section avail-group">
      <div class="container">
         <div class="section-title">
            <h2 class="title blue">Featured Groups</h2>
         </div>
         <div class="available-group-wrap">
            <div class="group-carousel owl-carousel">

            
               <?php foreach($featured_groups as $groups){
                  $group_image = asset('public/uploads/group').'/'.$groups->image;

                  if($groups->privacy == 1){
                     $lockClass = "bg-blue lock-open";
                  }else{
                     $lockClass = "bg-grey lock-close";
                  }

                  // echo $group_image;die;
               ?>
               <!--  item group 1 -->
               <div class="item">
                  <div class="group-img">
                     <img src="<?= $group_image; ?>" alt="Image not available" />
                  </div>
                  <div class="group-content">
                     <h4><?= $groups->name;?></h4>
                     <p><?= $groups->description;  ?></p>
                     <a href="" class="iocn-round <?= $lockClass?>"></a>
                  </div>
                  <div class="d-flex justify-content-between join-btn">
                     <div class="col-auto pl-0 pr-3 box-half">
                        <a class="btn" href="" data-toggle="modal" data-target="#join-mod1">Join Group</a>
                     </div>
                     <div class="col-auto p-0 box-half text-left msg-icon">
                        <div><a class="txt-btn" href=""><?= $groups->total_group_flowers;?> Flower(s)</a></div>
                        <div><a class="txt-btn" href=""><?= $groups->total_group_members;?> Member(s)</a></div>
                     </div>
                  </div>
               </div>

               <?php } ?>
               
            </div>                        
         </div>
      </div>
   </section>
   <!--end create.Group -->
   <!--want.group -->
   <section class="section team-group">
      <div class="container">
         <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
               <div class="team-img">
                  <img src="{{asset('public/frontend/img/team-img.jpg')}}" alt="">
               </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
               <div class="team-group-content">
                  <div class="section-title">
                     <h2 class="title white">Want to create a fundraising group?</h2>
                  </div>
                  <p>We understand many individuals have their own large network and wish to continue to stay close to their community’s essence. Here, you keep your logo, colors, and aura of your amazing community.
                  Have a group already in the works?
                  Email <a href="mailto:groups@loadus.org"><span style="color:white">groups@loadus.org</span></a>. To have all manual groups and data transferred to Loadu$.
                  </p>
                  <div>
                     <h2 class="title white">OTHER FUNDRAISING GROUPS </h2>
                  </div>
               </div>
               <ul class="list-unstyled d-flex justify-content-start flex-wrap option-list">
                  <li><span class="glyph-icon flaticon-drop"></span>Destiny 25 Community</li>
                  <li><span class="glyph-icon flaticon-agreement"></span>The Gifting Collective</li>
                  <!-- <li><span class="glyph-icon flaticon-key"></span>Lorem Ipsum is  simply</li>
                  <li><span class="glyph-icon flaticon-bar-chart"></span>Lorem Ipsum is  simply</li> -->
               </ul>
            </div>
         </div>
      </div>
   </section>
   <!--end want.group -->
   <!-- subscription  -->
   <section class="section member">
      <div class="container">
         <div class="section-title">
            <h2 class="title blue">Member Subscription </h2>
         </div>
         <div class="Subscription-plan text-center d-sm-flex justify-content-sm-center">
             @foreach($subscription as $val)
            <div class="plan-box">
               <div class="plan-type">
                  <h3>{{$subscriptionType[$val->subscription_type]}}</h3>
               </div>
               <div class="price">
                  <span>${{$val->subscription_rate}}</span>
               </div>
               <div class="plan-description">
                  {!! $val->description !!}
               </div>
               <a class="btn "href="{{ url('/stripe/'.Crypt::encryptString($val->id ))}}">Buy</a>                  
            </div>
             @endforeach
         </div>
      </div>
   </section>
   <!--end subscription  -->
</main>

@endsection