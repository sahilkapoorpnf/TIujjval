<?php $__env->startSection('title'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2 class="title blue">About Us</h2>
        </div>
        <div class="row d-flex flex-md-row-reverse">
            <div class="col-md-6 col-lg-5">
                <div class="about-img">
                    <img src="<?php echo e(asset($aboutUs[0]['featured_img'])); ?>" />
                </div>
            </div>
            <div class="col-md-6 col-lg-7">
                <div class="about-content">
                    <?php echo $aboutUs[0]['description']; ?>

<!--                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->
                </div>
            </div>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/frontend/pages/about_us.blade.php ENDPATH**/ ?>