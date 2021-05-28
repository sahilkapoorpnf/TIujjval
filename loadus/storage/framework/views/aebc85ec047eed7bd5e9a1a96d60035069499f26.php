<?php $__env->startSection('title'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2 class="title blue">Loadus Library</h2>
        </div>
        <div class="row d-flex flex-md-row-reverse">
            <div class="col-md-6 col-lg-5">
                <div class="about-img">
                    <!-- <img src="<?php echo e(url('public/frontend/img/about-img.jpg')); ?>" /> -->
                </div>
            </div>
            <div class="col-md-6 col-lg-7">
                <div class="about-content">
                    
                   <p>It was said to be truth that Annie Turnbo Malone(first black female millionaire in the 1920’s) created the aura of the Black Press. Loadus would like to take part in the continuation of that legacy in our own way. Please feel free to enjoy our monthly editions to our magazines, world wide articles of our community achievements, and info videos that will refresh your energy down the path of financial freedom for future generations.</p>
                   <!--<h4>Gifting Tax laws: Link to PDF</h4>-->
<!--                   <p><a href="https://www.dropbox.com/s/7wcp815w9bh47rh/Loadus%20Magazine%20Vol.%201.pdf?dl=0" target="_blank">Attached Images Volume 1</a></p>
                   <p><a href="https://simplebooklet.com/loadusmagazine" target="_blank">Attached Images Volume 2</a></p>-->
                   <p><img src="<?php echo e(asset('public/frontend/img/volume1.jpeg')); ?>"></p>
                   <p><img src="<?php echo e(asset('public/frontend/img/volume2.jpeg')); ?>"></p>

                </div>
            </div>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/frontend/pages/loadus_library.blade.php ENDPATH**/ ?>