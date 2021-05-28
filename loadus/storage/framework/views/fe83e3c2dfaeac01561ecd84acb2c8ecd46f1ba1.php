<!DOCTYPE html>
<html>
    <head>
        <title>Loadus Strip Payement Gateway</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style type="text/css">
            .panel-title {
                display: inline;
                font-weight: bold;
            }
            .display-table {
                display: table;
            }
            .display-tr {
                display: table-row;
            }
            .display-td {
                display: table-cell;
                vertical-align: middle;
                width: 61%;
            }
            .login-logo, .register-logo {
                font-size: 35px;
                text-align: center;
                margin-bottom: 25px;
                font-weight: 300;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="login-logo">
                <img src="<?php echo e(url('public/frontend/img/logo.png')); ?>" style="margin-bottom:22px">
            </div>
            <!--<h1>Loadus <br/> loadus.com</h1>-->

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table" >
                            <div class="row display-tr" >
                                <h3 class="panel-title display-td" >Payment Details</h3>
                                <div class="display-td" >                            
                                    <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                </div>
                            </div>                    
                        </div>
                        <div class="panel-body">

                            <?php if(Session::has('success')): ?>
                            <div class="alert alert-success text-center">
                                <a href="<?php echo e('my-subscription'); ?>" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p><?php echo e(Session::get('success')); ?></p>
                                <div id="payment_status" data-payment_status="1" style="display:none;"></div>
                            </div>
                            <?php endif; ?>
                            <?php if(Session::has('failure')): ?>
                            <div class="alert alert-danger text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p><?php echo e(Session::get('failure')); ?></p>
                                <div id="payment_status" data-payment_status="2" style="display:none;"></div>
                            </div>
                            <?php endif; ?>

                            <form role="form" action="<?php echo e(route('stripe.post')); ?>" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo e($strip_key); ?>" id="payment-form">
                                <?php echo csrf_field(); ?>

                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group required'>
                                        <label class='control-label'>Name on Card</label> 
                                        <input type="text" class='form-control' size='4' type='text' onkeypress=" return onlyString();">
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group card required'>
                                        <label class='control-label'>Card Number</label> 
                                        <input type="text" autocomplete='off' class='form-control card-number' size='20' min="0" onkeypress='validate(event)'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label> 
                                        <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' min="3" max="3" onkeypress='validate(event)'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label> 
                                        <input class='form-control card-expiry-month' placeholder='MM' size='2' min="2" max="2" onkeypress='validate(event)'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label> 
                                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4' min="4" max="4" onkeypress='validate(event)'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="hidden" name="user_id" value="<?php echo e($userData[0]->id); ?>">
                                        <input type="hidden" name="user_email" value="<?php echo e($userData[0]->email); ?>">
                                        <input type="hidden" name="subscription_id" value="<?php echo e($subsData[0]->id); ?>">

                                        <input type="hidden" name="id" value="<?php echo e(Crypt::encryptString($subsData[0]->id)); ?>">

                                        
                                        <input type="hidden" name="subscription_type" value="<?php echo e($subsData[0]->subscription_type); ?>">
                                        <input type="hidden" name="subscription_rate" value="<?php echo e($subsData[0]->subscription_rate); ?>">
                                        <input type="hidden" name="description" value="<?php echo e($subsData[0]->description); ?>">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($<?php echo e($subsData[0]->subscription_rate); ?>)</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>        
                </div>
            </div>

        </div>

    </body>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
$(function () {

    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function (e) {
        var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
        $errorMessage.addClass('hide');

        $('.has-error').removeClass('has-error');
        $inputs.each(function (i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });

        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }

    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];

            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

});

//payment status
window.onload = function () {
    var payment_status = $("#payment_status").attr("data-payment_status");
    if (payment_status == 1) {
        // redirect after 3 seconds
        window.setTimeout(function () {
            window.location.href = "<?php echo e(url('my-subscription')); ?>";
        }, 3000);
    }
    if (payment_status == 2) {
// redirect after 3 seconds
        window.setTimeout(function () {
            window.location.href = "<?php echo e(url('subscription_list')); ?>";
        }, 3000);
    }
};

//card number validation

function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
    </script>
    
</html><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/stripe.blade.php ENDPATH**/ ?>