
<!--<div id="qnimate" class="off">-->
<!--    <div id="search" class="open">-->
<!--      <button data-widget="remove" id="removeClass" class="close" type="button">×</button>-->
<!--      <form class="form-inline ">-->
<!--        <div class="input-group">-->
<!--          <input type="text" id="search-input" class="form-control" placeholder="Search" aria-describedby="basic-addon1" autofocus>-->
<!--          <button class="btn bg-orange srch-btn" type="submit"><span class="" id="basic-addon1"><i class="fa fa-search"></i></span><span class="srch-txt">Search</span></button>-->
<!--        </div>-->
<!--      </form>-->
<!--    </div>-->
<!--</div>-->
<div style="display:none;" id="successTemplate">
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
     {MESSAGE}
  </div>
</div>
<div style="display:none;" id="errorTemplate">
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {MESSAGE}
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script type="text/javascript"  src="<?php echo e(asset('public/frontend/js/jquery.min.js')); ?>"></script> -->
<script type="text/javascript" src="<?php echo e(asset('public/frontend/js/popper.min.js')); ?>"></script>
<script type="text/javascript"  src="<?php echo e(asset('public/frontend/js/bootstrap.min.js')); ?>"></script>	
<script type="text/javascript"  src="<?php echo e(asset('public/frontend/js/simplebar.js')); ?>"></script>	
<script type="text/javascript" src="<?php echo e(asset('public/frontend/js/webslidemenu.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('public/frontend/js/owl.carousel.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('public/frontend/js/pushy.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>

<!-- Own JavaScript File Link -->
<script src="<?php echo e(asset('public/frontend/san_asset/js/main.js')); ?>"></script>


<script>
	$(document).ready(function(){

		$('.heroContent').slick({
			dots: true,
			arrows: false,
  			autoplay: true,
			infinite: true,
			speed: 200,
			slidesToShow: 1,
			vertical: true,
			verticalSwiping: true,
			slidesToScroll: 1,
			responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: true,
				}
			},

			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: false
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: false
				}
			}
]
});
	});

</script>	

<script>
    $('.productScroll').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  speed: 500,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
    {
        breakpoint: 1024,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
        }
    },

    {
        breakpoint: 600,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            arrows: false
        }
    },
    {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            arrows: false
        }
    }
]
});
    
</script>

<script>
$(document).ready(function() {
	$('.home-slider').owlCarousel({
		items: 1,
		loop: true,
		margin: 0,
		dots: false,
		nav: false
	});
	$('.group-carousel').owlCarousel({
		items: 3,
		loop: false,
		margin: 24,
		nav: false,
		dots: true,
		autoHeight: true,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
				margin: 30
			},
			530:{
				items:2
			},
			768:{
				items:3
			}
		}
	});
	$(function(){
		$("#search-active").click(function () {
			$('#qnimate').addClass('popup-box-on');
			$("#search-input").val('').focus();
		});          
		$("#removeClass").click(function () {
			$('#qnimate').removeClass('popup-box-on');
		});
	});

});

// $(window).scroll(function () {
// 	var window_top = $(window).scrollTop() + 1;
// 	if($( window ).width() > 999){
// 		if (window_top > 400) {
// 			$('.sticky-header').addClass('header_fixed animated fadeInDown');
// 		} else {
// 			$('.sticky-header').removeClass('header_fixed animated fadeInDown');
// 		}
// 	}
// });

/** ------------------Custom Methods---------------------**/
function formatErrorMessage(jqXHR, exception) {
    if (jqXHR.status === 0) {
        return ('Not connected.\nPlease verify your network connection.');
    } else if (jqXHR.status == 404) {
        return ('The requested page not found. [404]');
    } else if (jqXHR.status == 500) {
        return ('Internal Server Error [500].');
    } else if (exception === 'parsererror') {
        return ('Requested JSON parse failed.');
    } else if (exception === 'timeout') {
        return ('Time out error.');
    } else if (exception === 'abort') {
        return ('Ajax request aborted.');
    } else {
        return ('Uncaught Error.\n' + jqXHR.responseText);
    }
}

function customLoadingOnPlaceHolder(text, obj) {
    var i = 0;
    return window.setInterval(function() {
        obj.attr( 'placeholder', (text+Array((++i % 6)+1).join(".")) );                
    }, 500);
}

function showMessage(msg, success) {
	var templateObj = $("<div>");
	templateObj.addClass('globalMessage');
	if ( success) {
		templateObj.append( ($('#successTemplate').html()).replace('{MESSAGE}', msg) );
	} else {
		templateObj.append( ($('#errorTemplate').html()).replace('{MESSAGE}', msg) );
	}
	//$('body').prepend( (templateObj.html()).replace('{MESSAGE}', msg)).show();
	$('body').prepend(templateObj);
	templateObj.find('.alert-dismissible').show();
	setTimeout(function() {
		templateObj.find('.alert-dismissible').fadeOut(2000, function() {
			templateObj.remove();
		});
	}, 3000);
}

</script>
<!-- Script shared by client for customer support -->
<script>
(function(d,a){function c(){var b=d.createElement("script");b.async=!0;b.type="text/javascript";b.src=a._settings.messengerUrl;b.crossOrigin="anonymous";var c=d.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}window.kayako=a;a.readyQueue=[];a.newEmbedCode=!0;a.ready=function(b){a.readyQueue.push(b)};a._settings={apiUrl:"https://loadusfoundation.kayako.com/api/v1",messengerUrl:"https://loadusfoundation.kayakocdn.com/messenger",realtimeUrl:"wss://kre.kayako.net/socket"};window.attachEvent?window.attachEvent("onload",c):window.addEventListener("load",c,!1)})(document,window.kayako||{});
</script>
</body>
</html><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/layouts/sahil-footer-script.blade.php ENDPATH**/ ?>