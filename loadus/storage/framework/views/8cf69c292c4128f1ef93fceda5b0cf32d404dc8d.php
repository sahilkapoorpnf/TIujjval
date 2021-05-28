<?php $__env->startSection('title'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="slider">
   <div class="home-slider owl-carousel">
      <!--  item slider 1 -->
      <div class="item">
         <div class="slide-img">
            <img src="<?php echo e(asset('public/frontend/img/loadus_business.jpeg')); ?>" alt="" />
         </div>
         <div class="container">
            <div class="slide-content">
               
            </div>
         </div>
      </div>
   </div>
</section>

<section class="section avail-group">
    <div class="container">
        <div class="section-title">
        <h2 class="title blue">Loadus Business Directory Coming soon...</h2>
        </div>
        <div class="available-group-wrap">
        

              
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/frontend/pages/loadus_business.blade.php ENDPATH**/ ?>