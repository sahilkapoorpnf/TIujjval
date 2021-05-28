//JavaScript Code
 $(document).ready(function(){

    //Scroll To Top
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 250) {
            $(".back-to-top").fadeIn(200);
        } else {
            $(".back-to-top").fadeOut(200);
        } 
    })

   
    //Menu Toggle Button
    $('.menu-toggle').click(function(){
        $('.menu-toggle').toggleClass('active');
    })



 })

