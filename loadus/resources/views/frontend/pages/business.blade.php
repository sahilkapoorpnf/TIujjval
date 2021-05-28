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

<!-- ======================= Business Section Start ======================= -->
<section class="businessSection">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="mainTitle">
					<h1>Find the best business in town</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-12">
				<div class="bussinesBx">
					<div class="bussinesImage">
						<img src="{{asset('public/frontend/san_asset/images/gyms.jpg')}}" alt="">
					</div>
					<div class="bussinesTxt">
						<h2>Gyms</h2>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-12">
				<div class="bussinesBx">
					<div class="bussinesImage">
						<img src="{{asset('public/frontend/san_asset/images/hotel.jpg')}}" alt="">
					</div>
					<div class="bussinesTxt">
						<h2>Hotels</h2>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-12">
				<div class="bussinesBx">
					<div class="bussinesImage">
						<img src="{{asset('public/frontend/san_asset/images/cleaning.jpg')}}" alt="">
					</div>
					<div class="bussinesTxt">
						<h2>cleaning</h2>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-12">
				<div class="bussinesBx">
					<div class="bussinesImage">
						<img src="{{asset('public/frontend/san_asset/images/locksmith.jpg')}}" alt="">
					</div>
					<div class="bussinesTxt">
						<h2>locksmith</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ======================= Business Section Exit ======================= -->

<!-- ======================= Popular Section Start ======================= -->
<section class="popular">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="mainTitle">
					<h1>Choose from most popular</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="popularBox">
					<div class="popularImage">
						<img src="{{asset('public/frontend/san_asset/images/piza.jpg')}}" alt="">
						<i class="fas fa-heart"></i>
						<div class="popstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>112</span></li>
							</ul>
						</div>
					</div>
					<div class="popularArea">
						<h2>Italian Pizza House</h2>
						<div class="popularText">
							<div class="popularLeft">
								<h6>Drum stick, pizza</h6>
								<p>Min Order <span>150</span></p>
							</div>
							<div class="popularRight">
								<button type="button" class="btn">Order Now</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="popularBox">
					<div class="popularImage">
						<img src="{{asset('public/frontend/san_asset/images/piza.jpg')}}" alt="">
						<i class="fas fa-heart"></i>
						<div class="popstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>112</span></li>
							</ul>
						</div>
					</div>
					<div class="popularArea">
						<h2>Italian Pizza House</h2>
						<div class="popularText">
							<div class="popularLeft">
								<h6>Drum stick, pizza</h6>
								<p>Min Order <span>150</span></p>
							</div>
							<div class="popularRight">
								<button type="button" class="btn">Order Now</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="popularBox">
					<div class="popularImage">
						<img src="{{asset('public/frontend/san_asset/images/piza.jpg')}}" alt="">
						<i class="fas fa-heart"></i>
						<div class="popstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>112</span></li>
							</ul>
						</div>
					</div>
					<div class="popularArea">
						<h2>Italian Pizza House</h2>
						<div class="popularText">
							<div class="popularLeft">
								<h6>Drum stick, pizza</h6>
								<p>Min Order <span>150</span></p>
							</div>
							<div class="popularRight">
								<button type="button" class="btn">Order Now</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="popularBox">
					<div class="popularImage">
						<img src="{{asset('public/frontend/san_asset/images/piza.jpg')}}" alt="">
						<i class="fas fa-heart"></i>
						<div class="popstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>112</span></li>
							</ul>
						</div>
					</div>
					<div class="popularArea">
						<h2>Italian Pizza House</h2>
						<div class="popularText">
							<div class="popularLeft">
								<h6>Drum stick, pizza</h6>
								<p>Min Order <span>150</span></p>
							</div>
							<div class="popularRight">
								<button type="button" class="btn">Order Now</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="popularBox">
					<div class="popularImage">
						<img src="{{asset('public/frontend/san_asset/images/piza.jpg')}}" alt="">
						<i class="fas fa-heart"></i>
						<div class="popstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>112</span></li>
							</ul>
						</div>
					</div>
					<div class="popularArea">
						<h2>Italian Pizza House</h2>
						<div class="popularText">
							<div class="popularLeft">
								<h6>Drum stick, pizza</h6>
								<p>Min Order <span>150</span></p>
							</div>
							<div class="popularRight">
								<button type="button" class="btn">Order Now</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<div class="popularBox">
					<div class="popularImage">
						<img src="{{asset('public/frontend/san_asset/images/piza.jpg')}}" alt="">
						<i class="fas fa-heart"></i>
						<div class="popstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>112</span></li>
							</ul>
						</div>
					</div>
					<div class="popularArea">
						<h2>Italian Pizza House</h2>
						<div class="popularText">
							<div class="popularLeft">
								<h6>Drum stick, pizza</h6>
								<p>Min Order <span>150</span></p>
							</div>
							<div class="popularRight">
								<button type="button" class="btn">Order Now</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ======================= Popular Section Exit ======================= -->

<!-- ======================= Feature Section Start ======================= -->
<section class="feature">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="mainTitle">
					<h1>Featured Restaurant</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-sm-12">
				<div class="featureBox">
					<div class="offershape">Open</div>
					<div class="featureImage">
						<img src="{{asset('public/frontend/san_asset/images/feature1.png')}}" alt="">
					</div>
					<div class="featureArea">
						<div class="featureTop">
							<h2>Italian Pizza House</h2>
							<p>Drum stick, pizza</p>
							<i class="far fa-heart"></i>
						</div>
						<div class="featureTime">
							<ul>
								<li><i class="fas fa-check-circle"></i> Min 15.00 $</li>
								<li><i class="fas fa-motorcycle"></i> 40 min</li>
								<li><i class="far fa-clock"></i> 40 min</li>
							</ul>
						</div>
						<div class="featstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>(1)</span></li>
							</ul>
							<p>United Kingdom, London</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<div class="featureBox">
					<div class="offershape">Open</div>
					<div class="featureImage">
						<img src="images/feature2.png" alt="">
					</div>
					<div class="featureArea">
						<div class="featureTop">
							<h2>McDonalds</h2>
							<p>Chines Soup, Cold Coffe, Drum Stick, Ice Cream</p>
							<i class="far fa-heart"></i>
						</div>
						<div class="featureTime">
							<ul>
								<li><i class="fas fa-check-circle"></i> Min 15.00 $</li>
								<li><i class="fas fa-motorcycle"></i> 40 min</li>
								<li><i class="far fa-clock"></i> 40 min</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<div class="featureBox">
					<div class="offershape">Open</div>
					<div class="featureImage">
						<img src="images/feature3.png" alt="">
					</div>
					<div class="featureArea">
						<div class="featureTop">
							<h2>Hardees</h2>
							<p>Apple Juice, BB,Q, Carrot Juice, Chicken Roast</p>
							<i class="far fa-heart"></i>
						</div>
						<div class="featureTime">
							<ul>
								<li><i class="fas fa-check-circle"></i> Min 15.00 $</li>
								<li><i class="fas fa-motorcycle"></i> 40 min</li>
								<li><i class="far fa-clock"></i> 40 min</li>
							</ul>
						</div>
						<div class="featstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>(1)</span></li>
							</ul>
							<p>United State, Miami</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<div class="featureBox">
					<div class="offershape">Open</div>
					<div class="featureImage">
						<img src="{{asset('public/frontend/san_asset/images/feature4.png')}}" alt="">
					</div>
					<div class="featureArea">
						<div class="featureTop">
							<h2>Wendy's Cafe</h2>
							<p>Carrot Juice, Egg Fry, Fish Fry, Hot Dogs, Pastry</p>
							<i class="far fa-heart"></i>
						</div>
						<div class="featureTime">
							<ul>
								<li><i class="fas fa-check-circle"></i> Min 15.00 $</li>
								<li><i class="fas fa-motorcycle"></i> 40 min</li>
								<li><i class="far fa-clock"></i> 40 min</li>
							</ul>
						</div>
						<div class="featstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>(1)</span></li>
							</ul>
							<p>France, Dieppe</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<div class="featureBox">
					<div class="offershape">Open</div>
					<div class="featureImage">
						<img src="images/feature5.png" alt="">
					</div>
					<div class="featureArea">
						<div class="featureTop">
							<h2>Burger King</h2>
							<p>Carrot Juice, Egg Fry, Fish Fry, Hot Dogs, Pastry</p>
							<i class="far fa-heart"></i>
						</div>
						<div class="featureTime">
							<ul>
								<li><i class="fas fa-check-circle"></i> Min 15.00 $</li>
								<li><i class="fas fa-motorcycle"></i> 40 min</li>
								<li><i class="far fa-clock"></i> 40 min</li>
							</ul>
						</div>
						<div class="featstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>(1)</span></li>
							</ul>
							<p>Spain, Madrid</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<div class="featureBox">
					<div class="offershape">Open</div>
					<div class="featureImage">
						<img src="{{asset('public/frontend/san_asset/images/feature6.png')}}" alt="">
					</div>
					<div class="featureArea">
						<div class="featureTop">
							<h2>Burger King</h2>
							<p>Carrot Juice, Egg Fry, Fish Fry, Hot Dogs, Pastry</p>
							<i class="far fa-heart"></i>
						</div>
						<div class="featureTime">
							<ul>
								<li><i class="fas fa-check-circle"></i> Min 15.00 $</li>
								<li><i class="fas fa-motorcycle"></i> 40 min</li>
								<li><i class="far fa-clock"></i> 40 min</li>
							</ul>
						</div>
						<div class="featstar">
							<ul>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><i class="fas fa-star"></i></li>
								<li><span>(1)</span></li>
							</ul>
							<p>Brazil, Manaus</p>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</section>		
<!-- ======================= Feature Section Exit ======================= -->

<!-- ======================= App Section Exit ======================= -->
<section class="appSection">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 mx-auto col-md-12">
				<div class="appBoxFlex">
					<div class="appBoxA">
						<img src="{{asset('public/frontend/san_asset/images/appphn.png')}}" alt="">
					</div>
					<div class="appBoxB">
						<div class="appBoxText">
							<h2>Loadu$ In Your Mobile! Get Our App</h2>
							<p>Get our app, its the fastest way to order food on the go. </p>
						</div>
						<div class="appIcons">
							<a href="#"><span><img src="{{asset('public/frontend/san_asset/images/appstore.png')}}" alt=""></span></a>
							<a href="#"><span><img src="{{asset('public/frontend/san_asset/images/googleplay.png')}}" alt=""></span></a>
						</div>
						<div class="appMail">
							<input type="email" class="form-control" placeholder="Your Email" id="email">
							<button type="submit" class="btn">Send Link</button>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</section>
<!-- ======================= App Section Exit ======================= -->

@endsection