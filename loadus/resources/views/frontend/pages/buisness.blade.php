@extends('layouts.sahil-base')
@section('title')
{{ $title }}
@endsection

@section('content')
<!-- ======================= Banner Section start ======================= -->
<section class="heroBg p-0">
	<div class="container">
		<div class="banner">
			<div class="bannerBox">
				<div class="bannerSearchBox">
					<form action="" class="banSearchBox">
					<input class="form-control" type="search" placeholder="Find Plumber, Delivery, Checkout" aria-label="Search">
					<button class="btn" type="submit"><img src="{{asset('public/frontend/san_asset/images/bsearh.png')}}"></button>
					</form>
				</div>
				<div class="bannerLocationBox">
					<form action="" class="banSearchBox locactBox">
					<button class="btn" type="submit"><img src="{{asset('public/frontend/san_asset/images/blocation.png')}}"></button>
					<input class="form-control" type="search" placeholder="All Location" aria-label="Search">
					<button class="btn" type="submit"><img src="{{asset('public/frontend/san_asset/images/rlocation.png')}}"></button>
					</form>
				</div>
			</div>
			<div class="bannerSearch">
				<button class="btn">Search</button>
			</div>
		</div>
	</div>    
</section>
<!-- ======================= Banner Section Exit ======================= -->
@endsection