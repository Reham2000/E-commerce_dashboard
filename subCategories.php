<?php
$title = "Sub Subcategories";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\Category;
use App\Database\Models\Subcategory;

$categoryObj = new Category;
$subCategory = new Subcategory;
$subCategories = $subCategory->read()->fetch_all();

// print_r($Subcategories);die;

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
        <a href="subCategory_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New Sub Category <i
            class="fas fa-user-plus pl-3"></i></a>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>Id</th>
                <th>Image</th>
                <th>English Name</th>
                <th>Arabic Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody><pre>
            <?php
              if(empty($subCategories)){ ?>
                <td colspan="10" class='text-center text-danger display-4 text-bold'>No <?= $title ?> To Show</td>
              <?php }else{
              foreach ($subCategories as $subCategoryDate) {
                $category = $categoryObj->setId($subCategoryDate[5])->getCategoryById()->fetch_object();
              ?>
              <tr class="text-center">
                <td><?= $subCategoryDate[0] ?></td>
                <td><img class="w-50" src="<?= !empty($subCategoryDate[3]) ? $subCategoryPath . $subCategoryDate[3] : $subCategoryPath . 'default.png' ?>" alt="<?= $subCategoryDate[1] . " [ " . $subCategoryDate[2] . " ] "  ?>"></td>
                <td><?= $subCategoryDate[1] ?></td>
                <td><?= $subCategoryDate[2] ?></td>
                <td><?= $category->name_en . "( ". $category->name_ar ." )" ?></td>
                <td>
                  <?php
                            if($subCategoryDate[4] == '1'){echo "Active";}
                            else{echo "Not Active";}
                            ?>
                </td>
                <td><?= explode(' ' ,$subCategoryDate[6])[0] ?></td>
                <?php if($subCategoryDate[7] != ''){$subCategoryDate[7] = explode(' ' ,$subCategoryDate[7])[0];} ?>
                <td><?= $subCategoryDate[7] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="subCategory_operations.php?update=<?= $subCategoryDate[0] ?>" class="btn btn-info  mt-2"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                  <a href="subCategory_operations.php?delete=<?= $subCategoryDate[0] ?>" class="btn btn-danger  mt-2"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php } } ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
              <th>Id</th>
                <th>Image</th>
                <th>English Name</th>
                <th>Arabic Name</th>
                <th>Category</th>
                <th>Status</th>
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
