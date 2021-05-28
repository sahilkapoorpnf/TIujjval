@extends('layouts.base')
@section('title')
{{ $title }}
@endsection
@section('content')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2 class="title blue">Testimonials</h2>
        </div>
        <div class="row d-flex flex-md-row-reverse">
            
            <div class="col-md-12 col-lg-12">
                <div class="about-content">
                    <p></p>
                    @foreach($testimonials as $val)
                    <!--<h6>{!! $val['title'] !!}</h6>-->
                    <p>{!! $val['description'] !!}</p>
                    <strong>- {!! $val['client_name'] !!}</strong>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

@endsection