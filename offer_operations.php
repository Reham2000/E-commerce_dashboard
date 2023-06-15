<?php
$title = "Offers";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Services\Media;
use App\Database\Models\Offer;
use App\Http\Requests\Validation;

$offer = new Offer;
$validation = new Validation;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $offerData = $offer->setId($_GET['delete'])->getOfferById()->fetch_object();
  $offer->setId($_GET['delete'])->delete();
  if(!is_null($offerData->image)){
    unlink($offerPath . $offerData->image);
  }
  header("location:offers.php");
  die;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $offerData = $offer->setId($_GET['update'])->getOfferById()->fetch_object();
    $validation->setInput('title')->setValue($_POST['title'])->isChanged($offerData->title);
    if ($validation->getChanged() == '1') {
      $validation->setInput('title')->setValue($_POST['title'])->required()->min(2)->max(32)->unique('offers','title');
    }
    $validation->setInput('discount')->setValue($_POST['discount'])->isChanged($offerData->discount);
    if ($validation->getChanged() == '1') {
      $validation->setInput('discount')->setValue($_POST['discount'])->required()->min(2)->max(32)->unique('offers','discount');
    }
    $validation->setInput('discount_type')->setValue($_POST['discount_type'])->isChanged($offerData->discount_type);
    if ($validation->getChanged() == '1') {
      $validation->setInput('discount_type')->setValue($_POST['discount_type'])->required()->min(2)->max(32)->unique('offers','discount_type');
    }
    $validation->setInput('status')->setValue($_POST['status'])->isChanged($offerData->status);
    if ($validation->getChanged() == '1') {
      $validation->setInput('status')->setValue($_POST['status'])->required()->in(['1', '2']);
    }
    if ($_FILES['image']['error'] == 0) {
      $imageService = new Media;
      $imageService->setFile($_FILES['image'])->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
      if (empty($imageService->getErrors())) {
        if (empty($validation->getErrors())) {
          $imageService->upload($offerPath);
          if(! is_null($offerData->image)){
            $imageService->delete($offerPath . $offerData->image);
          }
          $offer->settitle($_POST['title'])->setdiscount($_POST['discount'])->setImage($imageService->getFileName());
          if ($offer->update()) {
            $message = "<div class='alert alert-success text-center p-1' role='alert'><h4>offer Updated Successfully</h4></div>";
            header("location:offer_operations.php?update={$_GET['update']}");
            die;
          } else {
            $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
          }
        }
      } else {
        $imageError = "<p class='text-danger font-weight-bold'> Image is required </p>";
      }
    } else {
      $offer->settitle($_POST['title'])->setdiscount($_POST['discount']);
      if ($offer->updateWithoutImage()) {
        header("location:offer_operations.php?update={$_GET['update']}");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
      }
    }
    if (empty($validation->getErrors())) {
      $offer->settitle($_POST['title'])->setdiscount($_POST['discount']);
      if ($offer->setId($_GET['update'])->update()) {
        header("location:offer_operations.php?update={$_GET['update']}");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
      }
    }
  } else {
    $validation->setInput('title')->setValue($_POST['title'])->required()->min(2)->max(32)->unique('offers', 'title');
    $validation->setInput('discount')->setValue($_POST['discount'])->required()->min(2)->max(32)->unique('offers', 'discount');
    $validation->setInput('discount_type')->setValue($_POST['discount_type'])->required()->min(2)->max(60);
    $validation->setInput('start_at')->setValue($_POST['start_at'])->required();
    $validation->setInput('end_at')->setValue($_POST['end_at'])->required();

    if ($_FILES['image']['error'] == 0) {
      $imageService = new Media;
      $imageService->setFile($_FILES['image'])->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
      if (empty($imageService->getErrors())) {
        if (empty($validation->getErrors())) {
          $imageService->upload($offerPath);
          $offer->settitle($_POST['title'])->setdiscount($_POST['discount'])->setImage($imageService->getFileName())->setDiscount_type($_POST['discount_type'])->setStart_at($_POST['start_at'])->setEnd_at($_POST['end_at']);
          if ($offer->create()) {
            header("location:offers.php");
            die;
          } else {
            $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong 1</h4></div>";
          }
        }
      } else {
        $imageError = "<p class='text-danger font-weight-bold'> Image is required </p>";
      }
    } else {
      if(empty($validation->getErrors())){
        $offer->settitle($_POST['title'])->setdiscount($_POST['discount'])->setImage(NULL)->setDiscount_type($_POST['discount_type'])->setStart_at($_POST['start_at'])->setEnd_at($_POST['end_at']);
        if ($offer->create()) {
          header("location:offers.php");
          die;
        } else {
          $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong 2</h4></div>";
        }
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
      <!-- Add offer -->
      <a href="offers.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row px-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>location.svg" class="w-50" alt="">
          <h2 class="text-ingo text-center py-3"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> offer</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $offerData = $offer->setId($_GET['update'])->getOfferById()->fetch_object();
        ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <?= $message ?? '' ?>
            <div class="form-group">
              <input type="text" name="title" id="" value="<?= $offerData->title ?>" class="form-control" placeholder="Enter offer English Name ...">
              <?= $validation->getMessage('title') ?>
            </div>
            <div class="form-group">
              <input type="text" name="discount" value="<?= $offerData->discount ?>" id="" class="form-control" placeholder="Enter offer Arabic Name ...">
              <?= $validation->getMessage('discount') ?>
            </div>
            <div class="form-group">
              <input type="file" name="image" class="form-control" id="">
              <?= $imageError ?? '' ?>
            </div>
            <select name="status" id="" class="form-control mb-1">
              <option selected disabled value>Select offer Status</option>
              <option <?= $offerData->status == '1' ? 'selected' : '' ?> value="1">Active</option>
              <option <?= $offerData->status == '2' ? 'selected' : '' ?> value="2">Not Active</option>
            </select>
            <?= $validation->getMessage('status') ?>

            <input type="submit" value="Update offer" class="btn btn-info my-2 px-2">
          </form>
        <?php } else { ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 ">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="title" id="" value="<?= $validation->getOldValue('title') ?>" class="form-control" placeholder="Enter Offer Title ...">
              <?= $validation->getMessage('title') ?>
            </div>
            <div class="form-group">
              <input type="text" name="discount" value="<?= $validation->getOldValue('discount') ?>" id="" class="form-control" placeholder="Enter Offer Discount ...">
              <?= $validation->getMessage('discount') ?>
            </div>
            <div class="form-group">
              <input type="text" name="discount_type" id="" value="<?= $validation->getOldValue('discount_type') ?>" class="form-control" placeholder="Enter Offer Discount Type ...">
              <?= $validation->getMessage('discount_type') ?>
            </div>
            <div class="form-group row">
              <div class="col-2">
                <label for="start_at" class="text-muted pt-2">Start At : </label>
              </div>
              <div class="col-10">
                <input type="datetime-local" name="start_at" value="<?= $validation->getOldValue('start_at') ?>" id="start_at" class="form-control" placeholder="Enter Offer Start At ...">
              </div>
              <?= $validation->getMessage('start_at') ?>
            </div>
            <div class="form-group row">
              <div class="col-2">
                <label for="end_at" class="text-muted pt-2">End At : </label>
              </div>
              <div class="col-10">
                <input type="datetime-local" name="end_at" value="<?= $validation->getOldValue('end_at') ?>" id="end_at" class="form-control" placeholder="Enter Offer End At ...">
              </div>
              <?= $validation->getMessage('end_at') ?>
            </div>
            <div class="form-group">
              <input type="file" name="image" class="form-control" id="">
              <?= $imageError ?? '' ?>
            </div>
            <input type="submit" value="Add offer" class="btn btn-info px-2">
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
