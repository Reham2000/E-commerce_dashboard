<?php
$title = "Coupons";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\Coupon;

$coupon = new Coupon;
$coupons = $coupon->read()->fetch_all();

// print_r($coupons);die;

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- ####breadcrumb -->
  <?php  include "includes/breadcrumb.php"; ?>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <!-- <div class="row shadow"> -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All <?= $title ?> In Our System</h3>
        </div>
        <a href="coupon_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New Coupon <i
            class="fas fa-user-plus pl-3"></i></a>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>Id</th>
                <th>code</th>
                <th>Discount</th>
                <th>Discount Type</th>
                <th>Max Discount Value</th>
                <th>Max Useage</th>
                <th>max Useage Per User</th>
                <th>Mini Order</th>
                <th>Start At</th>
                <th>End At</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if(empty($coupons)){ ?>
                <td colspan="12" class='text-center text-danger display-4 text-bold'>No <?= $title ?> To Show</td>
              <?php }else{
              foreach ($coupons as $couponDate) {?>
              <tr class="text-center">
                <td><?= $couponDate[0] ?></td>
                <td class="text-primary text-bold"><?= ucwords($couponDate[1]) ?></td>
                <td><?= $couponDate[2] ?> %</td>
                <td><?= ucwords($couponDate[3]) ?></td>
                <td><?= $couponDate[4]?></td>
                <td><?= $couponDate[5] ?></td>
                <td><?= $couponDate[6] ?></td>
                <td><?= $couponDate[7] ?></td>
                <td><?= $couponDate[8] ?></td>
                <td><?= $couponDate[9] ?></td>
                <td><?= explode(' ' ,$couponDate[10])[0] ?></td>
                <?php if($couponDate[11] != ''){$couponDate[11] = explode(' ' ,$couponDate[11])[0];} ?>
                <td><?= $couponDate[11] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="coupon_operations.php?update=<?= $couponDate[0] ?>" class="btn btn-info  mt-2"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                  <a href="coupon_operations.php?delete=<?= $couponDate[0] ?>" class="btn btn-danger  mt-2"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php } } ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
              <th>Id</th>
                <th>code</th>
                <th>Discount</th>
                <th>Discount Type</th>
                <th>Max Discount Value</th>
                <th>Max Useage</th>
                <th>max Useage Per User</th>
                <th>Mini Order</th>
                <th>Start At</th>
                <th>End At</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- </div> -->
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php

include "includes/footer.php";
include "includes/scripts.php";

?>
