<?php $__env->startSection('title'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2 class="title blue">How It Works</h2>
        </div>
        <div class="row d-flex flex-md-row-reverse">
            <?php if(!empty($howItWorks[0]['featured_img'])){?>
            <div class="col-md-6 col-lg-5">
                <div class="about-img">
                    <img src="<?php echo e(asset($howItWorks[0]['featured_img'])); ?>" />
                </div>
            </div>

            <div class="col-md-6 col-lg-7">
                <div class="about-content">
                    <?php if(!empty($howItWorks)){?>
                    <?php echo $howItWorks[0]['description']; ?>

                    <?php } ?>
                </div>
            </div>
            <?php }else{ ?>
                <div class="col-md-12 col-lg-12">
                    <div class="about-content">
                        <?php if(!empty($howItWorks)){?>
                        <?php echo $howItWorks[0]['description']; ?>

                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/frontend/pages/how-it-works.blade.php ENDPATH**/ ?>