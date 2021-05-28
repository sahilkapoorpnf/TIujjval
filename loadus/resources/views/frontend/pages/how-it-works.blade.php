@extends('layouts.base')
@section('title')
{{ $title }}
@endsection
@section('content')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2 class="title blue">How It Works</h2>
        </div>
        <div class="row d-flex flex-md-row-reverse">
            <?php if(!empty($howItWorks[0]['featured_img'])){?>
            <div class="col-md-6 col-lg-5">
                <div class="about-img">
                    <img src="{{asset($howItWorks[0]['featured_img'])}}" />
                </div>
            </div>

            <div class="col-md-6 col-lg-7">
                <div class="about-content">
                    <?php if(!empty($howItWorks)){?>
                    {!! $howItWorks[0]['description'] !!}
                    <?php } ?>
                </div>
            </div>
            <?php }else{ ?>
                <div class="col-md-12 col-lg-12">
                    <div class="about-content">
                        <?php if(!empty($howItWorks)){?>
                        {!! $howItWorks[0]['description'] !!}
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section>

@endsection