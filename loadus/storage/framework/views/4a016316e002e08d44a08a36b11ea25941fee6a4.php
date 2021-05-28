<?php $__env->startSection('content'); ?>
<section class="banner innerBanner"><img class="img-fluid" src="<?php echo e(asset('public/front')); ?>/images/visa-banner.jpg" width="1349" height="970">
    <div class="pageHeading">
        <div class="container">
            <h1>Travidocs <span>404 page not found</span></h1>
        </div>
    </div>
</section>
<section class="pageBreadcrumb">
    <div class="container">
        <div class="row">
            <aside class="col-sm-12">
                <ul class="breadcrumb">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="active">404 page not found</li>
                </ul>
            </aside>
        </div>
    </div>
</section>
<img class="img-fluid" src="<?php echo e(asset('public/front')); ?>/images/my404.png" width="1349" height="970">

<?php $__env->stopSection(); ?>


<?php echo $__env->make('front.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/errors/404.blade.php ENDPATH**/ ?>