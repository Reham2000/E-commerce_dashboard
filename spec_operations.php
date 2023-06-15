<?php
$title = "Specs";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\spec;
use App\Http\Requests\Validation;

$spec = new Spec;
$validation = new Validation;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $specData = $spec->setId($_GET['delete'])->getSpecById()->fetch_object();
  $spec->setId($_GET['delete'])->delete();
  if (!is_null($specData->image)) {
    unlink($specPath . $specData->image);
  }
  header("location:specs.php");
  die;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $specData = $spec->setId($_GET['update'])->getSpecById()->fetch_object();
    $validation->setInput('name')->setValue($_POST['name'])->isChanged($specData->name);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name')->setValue($_POST['name'])->required()->min(2)->max(32)->unique('specs', 'name');
    }
    if (empty($validation->getErrors())) {
      $spec->setName($_POST['name']);
      if ($spec->setId($_GET['update'])->update()) {
        header("location:spec_operations.php?update={$_GET['update']}");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
      }
    }
  } else {
    $validation->setInput('name')->setValue($_POST['name'])->required()->min(2)->max(32)->unique('specs', 'name');
        if (empty($validation->getErrors())) {
          $spec->setName($_POST['name']);
          if ($spec->create()) {
            header("location:specs.php");
            die;
          } else {
            $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong1</h4></div>";
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
      <!-- Add spec -->
      <a href="specs.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row p-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>location.svg" class="w-50" alt="">
          <h2 class="text-ingo text-center py-3"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> spec</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $specData = $spec->setId($_GET['update'])->getSpecById()->fetch_object();
        ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <?= $message ?? '' ?>
            <div class="form-group">
              <input type="text" name="name" id="" value="<?= $specData->name ?>" class="form-control" placeholder="Enter spec  Name ...">
              <?= $validation->getMessage('name') ?>
            </div>

            <input type="submit" value="Update spec" class="btn btn-info my-2 px-2">
          </form>
        <?php } else { ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="name" id="" value="<?= $validation->getOldValue('name') ?>" class="form-control" placeholder="Enter spec  Name ...">
              <?= $validation->getMessage('name') ?>
            </div>
            <input type="submit" value="Add spec" class="btn btn-info px-2">
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
