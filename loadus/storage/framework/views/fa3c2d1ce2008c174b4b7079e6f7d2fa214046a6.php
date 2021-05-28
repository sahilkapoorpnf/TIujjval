<?php $__env->startSection('title'); ?>
LOADUS
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="dashbaord p-0 groups-aside groups">
    <button class="menu-btn"><img src="<?php echo e(asset('public/frontend/img/menu.png')); ?>"></button>
    <div class="container">
        <div class="row d-flex align-items-stretch">
            <?php echo $__env->make('layouts.left_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col">
                <div class="dshContent">
                    <div class="row top-panel">
                        <aside class="col-lg-7">
                            <div class="section-title">
                                <h2 class="title blue">Member Subscription</h2>
                            </div>
                        </aside>
                        <aside class="col-lg-5 d-flex tierTp justify-content-end align-items-center">
                            <?php echo e(link_to_action('SubscriptionController@subscription_list','Buy Plan', null, array('class' => 'joinBtn'))); ?> 
                        </aside>
                    </div>
                    <div class="Subscription-plan text-center d-sm-flex justify-content-sm-center">
                        <?php if(!empty($subscription)): ?>
                        <?php $__currentLoopData = $subscription; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="plan-box">
                            <div class="plan-type">
                                <h3><?php echo e($subscriptionType[$subs->subscription_type]); ?></h3>
                            </div>
                            <div class="price">
                                <span>$<?php echo e($subs->subscription_rate); ?></span>
                            </div>
                            <div class="plan-description">
                                <p><?php echo e(strip_tags($subs->description)); ?></p>
                            </div>
                            <a class="btn" href="#"><?php echo e($subs->balance_day); ?> Days</a>						
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <div class="plan-box">
                            <div class="plan-type">
                                <h3>Plan</h3>
                            </div>
                            <div class="price">
                                <span>NA</span>
                            </div>
                            <div class="plan-description">
                                <p>Currently You Don't have any plan. Please buy.</p>
                            </div>
                            <?php echo e(link_to_action('SubscriptionController@subscription_list','Buy Plan', null, array('class' => 'btn'))); ?> 					
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo e(asset('public/frontend/js/chosen.jquery.js')); ?>"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>

<?php $__env->stopSection(); ?>
<script>
$(document).ready(function () {
    $(document).on('click', '.buy-subs', function (e) {
        e.preventDefualt();
        var id = $(this).attr('subs-rate');
        alert(id);
        return false;
        swal({
            title: "Are you sure?",
            text: "Delete this  data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: 'deletesubs',
                            data: {"_token": "<?php echo e(csrf_token()); ?>", id: id},
                            success: function (data) {
                                if (data == 1) {
                                    swal("Success! Data  has been deleted!", {
                                        icon: "success",
                                    });
                                    mytable.draw();
                                } else {
                                    swal("Error! Something went wrong", {
                                        icon: "error",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Your  data is safe!");
                    }
                });
    })
});

</script>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/frontend/subscription/my-subscription.blade.php ENDPATH**/ ?>