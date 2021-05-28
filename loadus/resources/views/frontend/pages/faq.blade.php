@extends('layouts.base')
@section('title')
LOADUS
@endsection
@section('content')

<!--faq -->
<section class="section faq">
    <div class="container">
        <div class="section-title">
            <h2 class="title blue">Faq</h2>
        </div>
        <h3>Do You Have Any Questions?</h3>
        <p class="mb-5">Creation timelines for the standard lorem ipsum passage vary, with some citing the 15th century and others the business data.</p>
        <div id="accordion" class="accordion">
            @foreach ($faq as $faqVal)
            <div class="card">
                <div class="card-header">
                    <a class="card-link collapsed" data-toggle="collapse" href="#collapse{{$faqVal['id']}}" aria-expanded="false">{{$faqVal['question']}}</a>
                </div>
                <div id="collapse{{$faqVal['id']}}" class="collapse" data-parent="#accordion" style="">
                    <div class="card-body">{{strip_tags($faqVal['answer'])}}</div>
                </div>
            </div>
            @endforeach
<!--            <div class="card">
                <div class="card-header">
                    <a class="card-link collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">Where can I find market research reports?</a>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                    <div class="card-body">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Impress clients new and existing with elite construction brochures. Impress clients new and existing with elite construction.</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">What is social distancing and how can we do that?</a>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Impress clients new and existing with elite construction brochures. Impress clients new and existing with elite construction.</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">What type of company is measured?</a>
                </div>
                <div id="collapseFour" class="collapse" data-parent="#accordion">
                    <div class="card-body">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Impress clients new and existing with elite construction brochures. Impress clients new and existing with elite construction.</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">How can I safely use cleaning chemicals?</a>
                </div>
                <div id="collapseFive" class="collapse" data-parent="#accordion">
                    <div class="card-body">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Impress clients new and existing with elite construction brochures. Impress clients new and existing with elite construction.</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseSix">Where should I incorporate my business?</a>
                </div>
                <div id="collapseSix" class="collapse" data-parent="#accordion">
                    <div class="card-body">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Impress clients new and existing with elite construction brochures. Impress clients new and existing with elite construction.</div>
                </div>
            </div>-->
        </div>				
    </div>
</section>
<!--end faq -->

<script>
    $(document).ready(function () {
        $('.home-slider').owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            dots: false,
            nav: false
        });
        $('.group-carousel').owlCarousel({
            items: 3,
            loop: true,
            margin: 24,
            nav: false,
            dots: true,
            autoHeight: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 30
                },
                530: {
                    items: 2
                },
                992: {
                    items: 3
                }

            }
        });
        $(function () {
            $("#search-active").click(function () {
                $('#qnimate').addClass('popup-box-on');
                $("#search-input").val('').focus();
            });
            $("#removeClass").click(function () {
                $('#qnimate').removeClass('popup-box-on');
            });
        });
    });
    $(window).scroll(function () {
        var window_top = $(window).scrollTop() + 1;
        if ($(window).width() > 999) {
            if (window_top > 400) {
                $('.sticky-header').addClass('header_fixed animated fadeInDown');
            } else {
                $('.sticky-header').removeClass('header_fixed animated fadeInDown');
            }

        }
    });
</script>


@endsection