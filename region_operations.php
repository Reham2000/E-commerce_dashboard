<?php
$title = "Regions";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\City;
use App\Database\Models\Region;
use App\Http\Requests\Validation;

$city = new City;
$region = new Region;
$validation = new Validation;
$cities = $city->read()->fetch_all();
$citiesId = array_column($cities,0);
if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
  $region->setId($_GET['delete'])->delete();
  header("location:regions.php");

}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $regionData = $region->setId($_GET['update'])->getRegionById()->fetch_object();
    $validation->setInput('name_en')->setValue($_POST['name_en'])->isChanged($regionData->name_en);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32);
    }
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->isChanged($regionData->name_ar);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32);
    }
    $validation->setInput('status')->setValue($_POST['status'])->isChanged($regionData->status);
    if ($validation->getChanged() == '1') {
      $validation->setInput('status')->setValue($_POST['status'])->required()->in(['1', '2']);
    }

    if (empty($validation->getErrors())) {
      // print_r($_POST);die;
        $region->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setStatus($_POST['status']);
        if ($region->setId($_GET['update'])->update()) {
          header("location:region_operations.php?update={$_GET['update']}");
          die;
        } else {
          $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
        }
    }
  } else {
    $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32);
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32);
    if(isset($_POST['city'])){
      $validation->setInput('city')->setValue($_POST['city'])->required()->in($citiesId);
    }else{
      $cityError = "<p class='text-danger font-weight-bold'> City is required </p>";
    }
    if (empty($validation->getErrors())) {
      $region->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setCity_id($_POST['city']);
      if ($region->create()) {
        header("location:regions.php");
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
      <!-- Add region -->
      <a href="regions.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row p-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>location.svg" class="w-50" alt="">
          <h2 class="text-ingo text-center py-3"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> Region</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $regionData = $region->setId($_GET['update'])->getRegionById()->fetch_object();
          ?>
          <form action="" method="post" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $regionData->name_en ?>" class="form-control" placeholder="Enter Region English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $regionData->name_ar ?>" id="" class="form-control" placeholder="Enter Region Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <select name="city" id="" class="form-control mb-1">
              <option selected disabled value>Select Region City</option>
              <?php
              foreach($cities as $cityData){?>
                <option <?= $cityData[0] == $regionData->city_id ? 'selected' : '' ?> value="<?= $cityData[0] ?>"><?= $cityData[1] ?> ( <?= $cityData[2] ?> )</option>
              <?php }
              ?>
            </select>
            <?= $validation->getMessage('city') ?>
            <select name="status" id="" class="form-control mb-1">
              <option selected disabled value>Select Region Status</option>
              <option <?= $regionData->status == '1' ? 'selected' : '' ?> value="1">Active</option>
              <option <?= $regionData->status == '2' ? 'selected' : '' ?> value="2">Not Active</option>
            </select>
            <?= $validation->getMessage('status') ?>

            <input type="submit" value="Update Region" class="btn btn-info my-2 px-2">
          </form>
        <?php } elseif(isset($_GET['delete'])) {
          $region->setId($_GET['delete'])->delete();
          header("location:regions.php");die;
        }
        else { ?>
          <form action="" method="post" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $validation->getOldValue('name_en') ?>" class="form-control" placeholder="Enter Region English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $validation->getOldValue('name_ar') ?>" id="" class="form-control" placeholder="Enter Region Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <select name="city" id="" class="form-control mb-1">
              <option selected disabled value>Select Region City</option>
              <?php
              foreach($cities as $cityData){?>
                <option <?= $validation->getOldValue('city') == $cityData[0] ? 'selected' : '' ?> value="<?= $cityData[0] ?>"><?= $cityData[1] ?> ( <?= $cityData[2] ?> )</option>
              <?php }
              ?>
            </select>
            <?= $validation->getMessage('city') ?>
            <?= $cityError ?? '' ?>
            <input type="submit" value="Add Region" class="btn btn-info px-2">
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
