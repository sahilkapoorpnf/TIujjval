@extends('layouts.base')
@section('title')
{{ $title }}
@endsection
@section('content')

@section('content')
<section class="contact-page">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10">
                <div class="loginBox position-relative">
                    <div class="space50"><h2 class="title blue">Contact Us</h2></div>
                    <div class="loginForm">
                        <form method="post" class="form" role="form" action="javascript:void(0)" id="contactUsForm">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6 form-group pb-4">
                                    <div class=" d-flex">
                                        <div class="icon"><img src="{{url('public/frontend/img/user.png')}}"></div>
                                        <input class="form-control" id="name" name="first_name" placeholder="First Name *" type="text"  />
                                    </div>
                                    <div class="brd">&nbsp;</div>
                                </div>
                                <div class="col-md-6 form-group pb-4">
                                    <div class=" d-flex">
                                        <div class="icon"><img src="{{url('public/frontend/img/user.png')}}"></div>
                                        <input class="form-control" id="name" name="last_name" placeholder="Last Name" type="text"  />
                                    </div>
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group pb-4">
                                    <div class="d-flex">
                                        <div class="icon"><img src="{{url('public/frontend/img/phone2.png')}}"></div>
                                        <input class="form-control" id="" name="phone" placeholder="Contact Number*" type="Phone"  />
                                    </div>
                                    <div class="brd">&nbsp;</div>

                                </div>
                                <div class="col-md-12 form-group pb-4">
                                    <div class="d-flex">
                                        <div class="icon"><img src="{{url('public/frontend/img/email.png')}}"></div>
                                        <input class="form-control" id="email" name="email" placeholder="Email*" type="email"  />
                                    </div>
                                    <div class="brd">&nbsp;</div>
                                </div>
                                <div class="col-md-12 form-group pb-4">
                                    <div class="d-flex">
                                        <div class="icon"><i class="fa fa-comment-o" aria-hidden="true"></i></div>
                                        <textarea class="form-control" id="msg" name="message" placeholder="Write your message" type="text"  ></textarea>
                                    </div>
                                    <div class="brd">&nbsp;</div>
                                </div>
                            </div>										
                            <div class="row">
                                <div class="col-md-12 pt-lg-2 form-group d-flex justify-content-between align-items-center">
                                    <button>Submit</button>											
                                </div>										
                            </div>
                        </form>							
                    </div>					
                </div>
            </div>
            <div class="col-lg-12">
                <div class="maps">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6509922.444479586!2d-123.79928089560903!3d37.18423978848934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb9fe5f285e3d%3A0x8b5109a227086f55!2sCalifornia%2C%20USA!5e0!3m2!1sen!2sin!4v1601557917399!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<!-- custom check box --> 
<script type="text/javascript">
$('#contactUsForm').validate({
    rules: {
        "first_name": {required: true},
        "phone": {required: true},
        "email": {required: true, email: true},
        "message": {required: true},
    },
    messages: {
        "first_name": {required: "Please enter first name"},
        "phone": {required: "Please enter Contact Number"},
        "email": {required: "Please enter valid email", email: "Please enter valid email"},
        "message": {required: "Please enter message"},
    },

    submitHandler: function () {

        $.ajax({
            url: "{{ url('contactUs') }}",
            type: "POST",
            data: new FormData($('#contactUsForm')[0]),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {console.log(data);
                if (data.status === true) {
                    // window.location.reload();
                    window.location.href = "{{url('/')}}";
                } else {
                    showMessage(data.msg, success = false);
                }
            },
            error: function (xhr, err) {console.log(xhr, err);
                var errMsg = formatErrorMessage(xhr, err);
                showMessage(errMsg, success = false);
            }
        });
    },
});

</script> 
@endsection