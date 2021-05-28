<?php
  use App\Social;
  use App\Setting;
  $socialmedia = Social::where('status', "1")->get();
  $address = Setting::where('id', '1')->first();
  $contact1 = Setting::where('id', '2')->first();
  $contact2 = Setting::where('id', '3')->first();
  $email = Setting::where('id', '4')->first();
  $email2 = Setting::where('id', '5')->first();
  $email3 = Setting::where('id', '6')->first();
?>



<!-- ======================= Footer Section Start ======================= -->
<section class="footer">
	<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-4v col-md-5 col-sm-12">
						<div class="footerBx">
						<h3>Contact</h3>
							<div class="footerAddress">
								<div class="footerIcon">
									<img src="images/map24.png" alt="">
								</div>
								<div class="footerTxt">
									<h5><?php echo $address->description;?></h5>
								</div>
							</div>
							<div class="footerAddress">
								<div class="footerIcon">
									<img src="images/mail24.png" alt="">
								</div>
								<div class="footerTxt">
									<h5><a href="mailto:<?php echo $contact1->description;?>"><?php echo $contact1->description;?></a></h5>
									<h5><a href="mailto:<?php echo $email->description;?>"><?php echo $email->description;?></a></h5>
									<p>To transfer your large group with manual data, please email us here, Loadus will love to automate you.</p>
								</div>
							</div>
							<div class="footerAddress">
								<div class="footerIcon">
									<img src="{{asset('public/frontend/san_asset/images/mail24.png')}}" alt="">
								</div>
								<div class="footerTxt">
									<h5><a href="mailto:Group@loadus.org">Partner@loadus.org</a></h5>
									<p>To partner with Loadus, please email us here, we would love to collab.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 mx-auto col-md-3 col-sm-12">
						<div class="footerBx">
						<h3>Links</h3>
							<div class="footerLinks">
								<ul>
									  <li><a href="{{ url('home') }}">Home</a></li>
                                      <li><a href="{{ url('about-us') }}">About Loadus</a></li>
                                      <li><a href="{{ url('Faq') }}">Loadus FAQ</a></li>
                                      <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                                      <li><a href="{{ url('terms-condition') }}">Terms And Condition</a></li>
                                      <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-3 col-sm-12">
						<div class="footerBx">
						<h3>Social Media</h3>
							<div class="footerSocial">
								<ul>
								    @foreach($socialmedia as $socials)
									<li><a href="{{$socials->link}}"><i class="{{$socials->icon}}"></i></a></li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
	</footer>
	<div class="footerDark">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-7 col-sm-7">
					<div class="copyright">
					<p>Copyright © <?php echo date('Y');?> Loadus | All Rights Reserved</p>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ======================= Footer Section Exit ======================= -->

<!-- top Arrow -->
<div class="back-to-top">
	<a href="#backToTop"><i class="fa fa-chevron-up"></i></a>
</div>
