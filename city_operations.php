<?php
$title = "cities";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\City;
use App\Http\Requests\Validation;

$city = new City;
$validation = new Validation;

if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
  $city->setId($_GET['delete'])->delete();
  header("location:cities.php");

}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $cityData = $city->setId($_GET['update'])->getCityById($_GET['update'])->fetch_object();
    $validation->setInput('name_en')->setValue($_POST['name_en'])->isChanged($cityData->name_en);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32);
    }
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->isChanged($cityData->name_ar);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32);
    }
    $validation->setInput('status')->setValue($_POST['status'])->isChanged($cityData->status);
    if ($validation->getChanged() == '1') {
      $validation->setInput('status')->setValue($_POST['status'])->required()->in(['1', '2']);
    }

    if (empty($validation->getErrors())) {
      // print_r($_POST);die;
        $city->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setStatus($_POST['status']);
        if ($city->setId($_GET['update'])->update()) {
          header("location:city_operations.php?update={$_GET['update']}");
          die;
        } else {
          $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
        }
    }
  } else {
    $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32);
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32);
    if (empty($validation->getErrors())) {
      $city->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar']);
      if ($city->create()) {
        header("location:cities.php");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
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
      <!-- Add city -->
      <a href="cities.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row p-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>location.svg" class="w-50" alt="">
          <h2 class="text-ingo text-center py-3 text-capitalize"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> city</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $cityData = $city->setId($_GET['update'])->getCityById()->fetch_object();
          ?>
          <form action="" method="post" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $cityData->name_en ?>" class="form-control" placeholder="Enter City English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $cityData->name_ar ?>" id="" class="form-control" placeholder="Enter City Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <select name="status" id="" class="form-control mb-1">
              <option selected disabled value>Select City Status</option>
              <option <?= $cityData->status == '1' ? 'selected' : '' ?> value="1">Active</option>
              <option <?= $cityData->status == '2' ? 'selected' : '' ?> value="2">Not Active</option>
            </select>
            <?= $validation->getMessage('status') ?>

            <input type="submit" value="Update City" class="btn btn-info my-2 px-2">
          </form>
        <?php } elseif(isset($_GET['delete'])) {
          $city->setId($_GET['delete'])->delete();
          header("location:cities.php");die;
        }
        else { ?>
          <form action="" method="post" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $validation->getOldValue('name_en') ?>" class="form-control" placeholder="Enter City English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $validation->getOldValue('name_ar') ?>" id="" class="form-control" placeholder="Enter City Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <input type="submit" value="Add City" class="btn btn-info px-2">
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
