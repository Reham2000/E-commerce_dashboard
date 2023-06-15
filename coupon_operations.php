<?php
$title = "Coupons";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Services\Media;
use App\Database\Models\Coupon;
use App\Http\Requests\Validation;

$coupon = new Coupon;
$validation = new Validation;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $couponData = $coupon->setId($_GET['delete'])->getCouponById()->fetch_object();
  $coupon->setId($_GET['delete'])->delete();
  if (!is_null($couponData->image)) {
    unlink($couponPath . $couponData->image);
  }
  header("location:coupons.php");
  die;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $couponData = $coupon->setId($_GET['update'])->getCouponById()->fetch_object();
    $validation->setInput('title')->setValue($_POST['title'])->isChanged($couponData->title);
    if ($validation->getChanged() == '1') {
      $validation->setInput('title')->setValue($_POST['title'])->required()->min(2)->max(32)->unique('coupons', 'title');
    }
    $validation->setInput('discount')->setValue($_POST['discount'])->isChanged($couponData->discount);
    if ($validation->getChanged() == '1') {
      $validation->setInput('discount')->setValue($_POST['discount'])->required()->maxValue(100);
    }
    $validation->setInput('discount_type')->setValue($_POST['discount_type'])->isChanged($couponData->discount_type);
    if ($validation->getChanged() == '1') {
      $validation->setInput('discount_type')->setValue($_POST['discount_type'])->required()->min(2)->max(32);
    }
    $validation->setInput('start_at')->setValue($_POST['start_at'])->isChanged($couponData->start_at);
    if ($validation->getChanged() == '1') {
      $validation->setInput('start_at')->setValue($_POST['start_at'])->required();
    }
    $validation->setInput('end_at')->setValue($_POST['end_at'])->isChanged($couponData->end_at);
    if ($validation->getChanged() == '1') {
      $validation->setInput('end_at')->setValue($_POST['end_at'])->required()->after($_POST['start_at']);
    }

    if (empty($validation->getErrors())) {
      $coupon->setMini_order($_POST['mini_order'])->setMax_useage_per_user($_POST['max_useage_per_user'])->setMax_useage($_POST['max_useage'])->setMax_discount_value($_POST['max_discount_value'])->setCode($_POST['code'])->setdiscount($_POST['discount'])->setDiscount_type($_POST['discount_type'])->setStart_at($_POST['start_at'])->setEnd_at($_POST['end_at']);
      if ($coupon->setId($_GET['update'])->update()) {
        header("location:coupon_operations.php?update={$_GET['update']}");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong2</h4></div>";
      }
    }
  } else {
    $validation->setInput('code')->setValue($_POST['code'])->required()->min(6)->max(6);
    $validation->setInput('discount')->setValue($_POST['discount'])->required()->maxValue(100);
    $validation->setInput('discount_type')->setValue($_POST['discount_type'])->required()->min(2)->max(60);
    $validation->setInput('max_discount_value')->setValue($_POST['max_discount_value'])->required()->max(4);
    $validation->setInput('max_useage')->setValue($_POST['max_useage'])->required()->max(3);
    $validation->setInput('max_useage_per_user')->setValue($_POST['max_useage_per_user'])->required()->max(1);
    $validation->setInput('mini_order')->setValue($_POST['mini_order'])->required()->max(6);
    $validation->setInput('start_at')->setValue($_POST['start_at'])->required();
    if(! empty($_POST['start_at'])){
      $validation->setInput('end_at')->setValue($_POST['end_at'])->required()->after($_POST['start_at']);
    }else{
      $dateError = "<p class='text-danger text-bold'>Set Start Date First</p>";
    }


    if (empty($validation->getErrors())) {
      $coupon->setMini_order($_POST['mini_order'])->setMax_useage_per_user($_POST['max_useage_per_user'])->setMax_useage($_POST['max_useage'])->setMax_discount_value($_POST['max_discount_value'])->setCode($_POST['code'])->setdiscount($_POST['discount'])->setDiscount_type($_POST['discount_type'])->setStart_at($_POST['start_at'])->setEnd_at($_POST['end_at']);
      if ($coupon->create()) {
        header("location:coupons.php");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong 2</h4></div>";
      }
    }
  }
}


?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- ####breadcrumb -->
  <?php include "includes/breadcrumb.php"; ?>

  <!-- Main content -->
  <section class="content">
    <div class="container">
      <!-- Add coupon -->
      <a href="coupons.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row px-3">
        <div class="col-md-5 col-sm-12 text-center my-5 ">
          <img src="<?= $dashboardImagesPath ?>location.svg" class="w-75 " alt="">
          <h2 class="text-ingo text-center py-3 text-capitalize"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> coupon</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $couponData = $coupon->setId($_GET['update'])->getCouponById()->fetch_object();
        ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <?= $message ?? '' ?>
            <div class="form-group">
              <input type="text" name="title" id="" value="<?= ucwords($couponData->title) ?>" class="form-control" placeholder="Enter coupon title ...">
              <?= $validation->getMessage('title') ?>
            </div>
            <div class="form-group">
              <input type="text" name="discount" value="<?= $couponData->discount ?>" id="" class="form-control" placeholder="Enter coupon Discount ...">
              <?= $validation->getMessage('discount') ?>
            </div>
            <div class="form-group">
              <input type="text" name="discount_type" id="" value="<?= ucwords($couponData->discount_type) ?>" class="form-control" placeholder="Enter coupon Discount Type ...">
              <?= $validation->getMessage('discount_type') ?>
            </div>
            <div class="form-group row">
              <div class="col-2">
                <label for="start_at" class="text-muted pt-2">Start At : </label>
              </div>
              <div class="col-10">
                <input type="datetime-local" name="start_at" value="<?= $couponData->start_at  ?>" id="start_at" class="form-control" placeholder="Enter coupon Start At ...">
              </div>
              <?= $validation->getMessage('start_at') ?>
            </div>
            <div class="form-group row">
              <div class="col-2">
                <label for="end_at" class="text-muted pt-2">Start At : </label>
              </div>
              <div class="col-10">
                <input type="datetime-local" name="end_at" value="<?= $couponData->end_at  ?>" id="end_at" class="form-control" placeholder="Enter coupon End At ...">
              </div>
              <?= $validation->getMessage('end_at') ?>
            </div>

            <div class="form-group">
              <input type="file" name="image" class="form-control" id="">
              <?= $imageError ?? '' ?>
            </div>


            <input type="submit" value="Update coupon" class="btn btn-info my-2 px-2">
          </form>
        <?php } else { ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 ">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="number" name="code" id="" value="<?= $validation->getOldValue('code') ?>" class="text-capitalize form-control" placeholder="Enter coupon Code ...">
              <?= $validation->getMessage('code') ?>
            </div>
            <div class="form-group">
              <input type="number" name="discount" value="<?= $validation->getOldValue('discount') ?>" id="" class="text-capitalize form-control" placeholder="Enter coupon Discount ...">
              <?= $validation->getMessage('discount') ?>
            </div>
            <div class="form-group">
              <input type="text" name="discount_type" id="" value="<?= $validation->getOldValue('discount_type') ?>" class="text-capitalize form-control" placeholder="Enter coupon Discount Type ...">
              <?= $validation->getMessage('discount_type') ?>
            </div>
            <div class="form-group">
              <input type="number" name="max_discount_value" value="<?= $validation->getOldValue('max_discount_value') ?>" id="" class="text-capitalize form-control" placeholder="Enter coupon max discount value ...">
              <?= $validation->getMessage('max_discount_value') ?>
            </div>
            <div class="form-group">
              <input type="number" name="max_useage" value="<?= $validation->getOldValue('max_useage') ?>" id="" class="text-capitalize form-control" placeholder="Enter coupon max useage ...">
              <?= $validation->getMessage('max_useage') ?>
            </div>
            <div class="form-group">
              <input type="number" name="max_useage_per_user" value="<?= $validation->getOldValue('max_useage_per_user') ?>" id="" class="text-capitalize form-control" placeholder="Enter coupon max useage per user ...">
              <?= $validation->getMessage('max_useage_per_user') ?>
            </div>
            <div class="form-group">
              <input type="number" name="mini_order" value="<?= $validation->getOldValue('mini_order') ?>" id="" class="text-capitalize form-control" placeholder="Enter coupon mini order ...">
              <?= $validation->getMessage('mini_order') ?>
            </div>
            <div class="form-group row">
              <div class="col-2">
                <label for="start_at" class="text-muted pt-2">Start At : </label>
              </div>
              <div class="col-10">
                <input type="datetime-local" name="start_at" value="<?= $validation->getOldValue('start_at') ?>" id="start_at" class="form-control" placeholder="Enter coupon Start At ...">
              </div>
              <?= $validation->getMessage('start_at') ?>
            </div>
            <div class="form-group row">
              <div class="col-2">
                <label for="end_at" class="text-muted pt-2">End At : </label>
              </div>
              <div class="col-10">
                <input type="datetime-local" name="end_at" value="<?= $validation->getOldValue('end_at') ?>" id="end_at" class="form-control" placeholder="Enter coupon End At ...">
              </div>
              <?= $validation->getMessage('end_at') ?>
              <?= $dateError ?? '' ?>
            </div>
            <input type="submit" value="Add coupon" class="btn btn-info px-2 mb-3">
          </form>
        <?php } ?>

      </div>
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
