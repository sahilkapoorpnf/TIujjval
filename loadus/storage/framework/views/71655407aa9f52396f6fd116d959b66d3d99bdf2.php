<?php $__env->startSection('title'); ?>
LOADUS Signup
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


            <h3>Dear <?php echo e($fname); ?>,</h3>

            <p>Thank you for creating an account with us.</p>

            <p>Please click on the link below to verify your email ID:</p>
            <p><a href="<?php echo e(url('signup_mail_verification'.'/'.$email.'/'.$token)); ?>" target="_blank" >Click here to verify your email</a></p>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.mailer.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/layouts/mailer/signup.blade.php ENDPATH**/ ?>