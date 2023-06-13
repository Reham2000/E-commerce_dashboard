<?php
$title = "Categories";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Services\Media;
use App\Database\Models\Category;
use App\Http\Requests\Validation;

$category = new Category;
$validation = new Validation;
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $categoryData = $category->setId($_GET['delete'])->getCategoryById()->fetch_object();
  $category->setId($_GET['delete'])->delete();
  if(!is_null($categoryData->image)){
    unlink($categoryPath . $categoryData->image);
  }
  header("location:categories.php");
  die;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $categoryData = $category->setId($_GET['update'])->getCategoryById()->fetch_object();
    $validation->setInput('name_en')->setValue($_POST['name_en'])->isChanged($categoryData->name_en);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32)->unique('categories','name_en');
    }
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->isChanged($categoryData->name_ar);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32)->unique('categories','name_ar');
    }
    $validation->setInput('status')->setValue($_POST['status'])->isChanged($categoryData->status);
    if ($validation->getChanged() == '1') {
      $validation->setInput('status')->setValue($_POST['status'])->required()->in(['1', '2']);
    }
    if ($_FILES['image']['error'] == 0) {
      $imageService = new Media;
      $imageService->setFile($_FILES['image'])->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
      if (empty($imageService->getErrors())) {
        if (empty($validation->getErrors())) {
          $imageService->upload($categoryPath);
          if(! is_null($categoryData->image)){
            $imageService->delete($categoryPath . $categoryData->image);
          }
          $category->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setImage($imageService->getFileName())->setStatus($_POST['status']);
          if ($category->update()) {
            $message = "<div class='alert alert-success text-center p-1' role='alert'><h4>Category Updated Successfully</h4></div>";
            header("Refresh:5; url=category_operations.php?update={$_GET['update']}");
            die;
          } else {
            $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
          }
        }
      } else {
        $imageError = "<p class='text-danger font-weight-bold'> Image is required </p>";
      }
    } else {
      $category->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setStatus($_POST['status']);
      if ($category->updateWithoutImage()) {
        header("location:category_operations.php?update={$_GET['update']}");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
      }
    }
    if (empty($validation->getErrors())) {
      $category->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setStatus($_POST['status']);
      if ($category->setId($_GET['update'])->update()) {
        header("location:category_operations.php?update={$_GET['update']}");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
      }
    }
  } else {
    // print_r($_FILES);die;
    $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32)->unique('categories', 'name_en');
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32)->unique('categories', 'name_ar');
    if ($_FILES['image']['error'] == 0) {
      $imageService = new Media;
      $imageService->setFile($_FILES['image'])->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
      if (empty($imageService->getErrors())) {
        if (empty($validation->getErrors())) {
          $imageService->upload($categoryPath);
          $category->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setImage($imageService->getFileName());
          if ($category->create()) {
            header("location:categories.php");
            die;
          } else {
            $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
          }
        }
      } else {
        $imageError = "<p class='text-danger font-weight-bold'> Image is required </p>";
      }
    } else {
      $category->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setImage(null);
      if ($category->create()) {
        header("location:categories.php");
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
      <!-- Add category -->
      <a href="categories.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row p-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>location.svg" class="w-50" alt="">
          <h2 class="text-ingo text-center py-3"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> category</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $categoryData = $category->setId($_GET['update'])->getCategoryById()->fetch_object();
        ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <?= $message ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $categoryData->name_en ?>" class="form-control" placeholder="Enter category English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $categoryData->name_ar ?>" id="" class="form-control" placeholder="Enter category Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <div class="form-group">
              <input type="file" name="image" class="form-control" id="">
              <?= $imageError ?? '' ?>
            </div>
            <select name="status" id="" class="form-control mb-1">
              <option selected disabled value>Select category Status</option>
              <option <?= $categoryData->status == '1' ? 'selected' : '' ?> value="1">Active</option>
              <option <?= $categoryData->status == '2' ? 'selected' : '' ?> value="2">Not Active</option>
            </select>
            <?= $validation->getMessage('status') ?>

            <input type="submit" value="Update Category" class="btn btn-info my-2 px-2">
          </form>
        <?php } else { ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $validation->getOldValue('name_en') ?>" class="form-control" placeholder="Enter Category English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $validation->getOldValue('name_ar') ?>" id="" class="form-control" placeholder="Enter Category Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <div class="form-group">
              <input type="file" name="image" class="form-control" id="">
              <?= $imageError ?? '' ?>
            </div>
            <input type="submit" value="Add Category" class="btn btn-info px-2">
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
