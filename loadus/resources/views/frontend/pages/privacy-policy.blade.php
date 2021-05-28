@extends('layouts.base')
@section('title')
{{ $title }}
@endsection
@section('content')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2 class="title blue">{{$title}}</h2>
        </div>
        <div class="row d-flex flex-md-row-reverse">
            
            <div class="col-md-12 col-lg-12">
                <div class="about-content">
                    <p></p>
                    @foreach($privacyPolicy as $val)
                    <!--<h6>{!! $val['title'] !!}</h6>-->
                    <p>{!! $val['description'] !!}</p>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

@endsection