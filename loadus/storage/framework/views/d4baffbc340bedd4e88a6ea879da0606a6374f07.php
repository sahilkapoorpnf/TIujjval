<?php $__env->startSection('title', "$title"); ?>

<?php $__env->startSection('content_header'); ?>
<?php //echo ActionButton(1); ?>
<h1><?php echo e($title); ?></h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><?php echo e($title); ?></a></li>    
</ol>
<?php //echo CreateButton(); ?>

<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="<?php echo e(url('admin/subscription/create')); ?>"><button class="btn btn-success btn-flat" data-toggle="tooltip" title="" data-original-title="Create Page">Create Subscription</button></a>
    </div> 
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="success"></div>
<div id="failed"></div>

<div class="box box-success color-palette-box">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo e($title); ?></h3>
        <!--<button class="btn btn-success btn-flat pull-right">Add </button>-->
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>User Email</th>
                        <th>Subscription Type</th>
                        <th>Subscription Rate</th>
                        <th>Buy Date</th>
                        <th>Expiry Date</th>
                        <th>Balance Day</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    var mytable;
    $(document).ready(function () {
        mytable = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": "getusersubs",
                data: {"_token": "<?php echo e(csrf_token()); ?>"},
                "type": "POST"
            }

        });
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-data', function () {
            var id = $(this).data('delete');

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/a18p1ucxu8bf/public_html/TI/TI/TI/loadus/LoadusSourceCode/loadus_laravel/loadus/resources/views/admin/subscription/user-subscription.blade.php ENDPATH**/ ?>