<?php
$title = "Sub Categories";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Services\Media;
use App\Database\Models\Category;
use App\Http\Requests\Validation;
use App\Database\Models\Subcategory;

$category = new Category;
$subCategory = new Subcategory;
$validation = new Validation;
$categories = $category->read()->fetch_all();
$categoriesId = array_column($categories, 0);

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $subCategoryData = $subCategory->setId($_GET['delete'])->getSubcategoryById()->fetch_object();
  $subCategory->setId($_GET['delete'])->delete();
  if (!is_null($subCategoryData->image)) {
    unlink($subCategoryPath . $subCategoryData->image);
  }
  header("location:subCategories.php");
  die;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $subCategoryData = $subCategory->setId($_GET['update'])->getSubcategoryById()->fetch_object();
    $validation->setInput('name_en')->setValue($_POST['name_en'])->isChanged($subCategoryData->name_en);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32)->unique('subcategories', 'name_en');
    }
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->isChanged($subCategoryData->name_ar);
    if ($validation->getChanged() == '1') {
      $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32)->unique('subcategories', 'name_ar');
    }
    $validation->setInput('status')->setValue($_POST['status'])->isChanged($subCategoryData->status);
    if ($validation->getChanged() == '1') {
      $validation->setInput('status')->setValue($_POST['status'])->required()->in(['1', '2']);
    }
    $validation->setInput('category')->setValue($_POST['category'])->isChanged($subCategoryData->category_id);
    if ($validation->getChanged() == '1') {
      $validation->setInput('category')->setValue($_POST['category'])->required()->in($categoriesId);
    }
    if ($_FILES['image']['error'] == 0) {
      $imageService = new Media;
      $imageService->setFile($_FILES['image'])->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
      if (empty($imageService->getErrors())) {
        if (empty($validation->getErrors())) {
          $imageService->upload($subCategoryPath);
          if (!is_null($subCategoryData->image)) {
            $imageService->delete($subCategoryPath . $subCategoryData->image);
          }
          $subCategory->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setImage($imageService->getFileName())->setStatus($_POST['status'])->setCategory_id($_POST['category']);
          if ($subCategory->update()) {
            header("location:subCategory_operations.php?update={$_GET['update']}");
            die;
          } else {
            $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
          }
        }
      } else {
        $imageError = "<p class='text-danger font-weight-bold'> Image Not Uplaoded </p>";
      }
    } else {
      if (empty($validation->getErrors())) {
        $subCategory->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setStatus($_POST['status'])->setCategory_id($_POST['category']);
        if ($subCategory->setId($_GET['update'])->update()) {
          header("location:subCategory_operations.php?update={$_GET['update']}");
          die;
        } else {
          $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
        }
      }
    }

  } else {
    // print_r($_POST);die;
    $validation->setInput('name_en')->setValue($_POST['name_en'])->required()->min(2)->max(32)->unique('subcategories', 'name_en');
    $validation->setInput('name_ar')->setValue($_POST['name_ar'])->required()->min(2)->max(32)->unique('subcategories', 'name_ar');
    if (isset($_POST['category'])) {
      $validation->setInput('category')->setValue($_POST['category'])->required()->in($categoriesId);
    } else {
      $categoryError = "<p class='text-danger font-weight-bold'> Category is required </p>";
    }
    if ($_FILES['image']['error'] == 0) {
      $imageService = new Media;
      $imageService->setFile($_FILES['image'])->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
      if (empty($imageService->getErrors())) {
        if (empty($validation->getErrors())) {
          $imageService->upload($subCategoryPath);
          $subCategory->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setImage($imageService->getFileName())->setCategory_id($_POST['category']);
          if ($subCategory->create()) {
            header("location:subCategories.php");
            die;
          } else {
            $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong in create</h4></div>";
          }
        }
      } else {
        $imageError = "<p class='text-danger font-weight-bold'> Image Not Uplaoded </p>";
      }
    } else {
      $subCategory->setName_en($_POST['name_en'])->setName_ar($_POST['name_ar'])->setImage(Null)->setCategory_id($_POST['category']);
      if ($subCategory->create()) {
        header("location:subCategories.php");
        die;
      } else {
        $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong in create</h4></div>";
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
      <a href="subCategories.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row p-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>location.svg" class="w-50" alt="">
          <h2 class="text-ingo text-center py-3"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> Sub Category</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $subCategoryData = $subCategory->setId($_GET['update'])->getSubcategoryById()->fetch_object();
        ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-5">
            <?= $error ?? '' ?>
            <?= $message ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $subCategoryData->name_en ?>" class="form-control" placeholder="Enter Sub Category English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $subCategoryData->name_ar ?>" id="" class="form-control" placeholder="Enter Sub Category Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <div class="form-group">
              <input type="file" name="image" class="form-control" id="">
              <?= $imageError ?? '' ?>
            </div>
            <select name="category" id="" class="form-control mb-3">
              <option selected disabled value>Select Category </option>
              <?php foreach ($categories as $categoryData) { ?>
                <option <?= $subCategoryData->category_id == $categoryData[0] ? 'selected' : ''  ?> value="<?= $categoryData[0] ?>"><?= $categoryData[1] . " ( " . $categoryData[2] . " ) "  ?></option>
              <?php } ?>
            </select>
            <?= $categoryError ?? '' ?>
            <select name="status" id="" class="form-control mb-1">
              <option selected disabled value>Select Sub Category Status</option>
              <option <?= $subCategoryData->status == '1' ? 'selected' : '' ?> value="1">Active</option>
              <option <?= $subCategoryData->status == '2' ? 'selected' : '' ?> value="2">Not Active</option>
            </select>
            <?= $validation->getMessage('status') ?>

            <input type="submit" value="Update Sub Category" class="btn btn-info my-2 px-2">
          </form>
        <?php } else { ?>
          <form action="" method="post" enctype="multipart/form-data" class="col-md-7 col-sm-12 px-3 mt-md-3">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="name_en" id="" value="<?= $validation->getOldValue('name_en') ?>" class="form-control" placeholder="Enter Sub Category English Name ...">
              <?= $validation->getMessage('name_en') ?>
            </div>
            <div class="form-group">
              <input type="text" name="name_ar" value="<?= $validation->getOldValue('name_ar') ?>" id="" class="form-control" placeholder="Enter Sub Category Arabic Name ...">
              <?= $validation->getMessage('name_ar') ?>
            </div>
            <select name="category" id="" class="form-control mb-3">
              <option selected disabled value>Select Category </option>
              <?php foreach ($categories as $categoryData) { ?>
                <option <?= $validation->getOldValue('category') == $categoryData[0] ? 'selected' : ''  ?> value="<?= $categoryData[0] ?>"><?= $categoryData[1] . " ( " . $categoryData[2] . " ) "  ?></option>
              <?php } ?>
            </select>
            <?= $categoryError ?? '' ?>
            <div class="form-group">
              <input type="file" name="image" class="form-control" id="">
              <?= $imageError ?? '' ?>
            </div>
            <input type="submit" value="Add Sub Category" class="btn btn-info px-2">
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
