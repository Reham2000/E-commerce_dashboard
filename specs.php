<?php
$title = "Specs";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\Spec;

$spec = new Spec;
$specs = $spec->read()->fetch_all();

// print_r($specs);die;

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
        <a href="brand_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New Brand <i
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
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(empty($specs)){ ?>
                <td colspan="9" class='text-center text-danger display-4 text-bold'>No <?= $title ?> To Show</td>
              <?php }else{
              foreach ($specs as $specDate) {?>
              <tr class="text-center">
                <td><?= $specDate[0] ?></td>
                <td><img class="w-50" src="<?= !empty($specDate[3]) ? $specPath . $specDate[3] : $specPath . 'default.jpg' ?>" alt="<?= $specDate[1] . " [ " . $specDate[2] . " ] "  ?>"></td>
                <td><?= $specDate[1] ?></td>
                <td><?= $specDate[2] ?></td>
                <td>
                  <?php
                            if($specDate[4] == '1'){echo "Active";}
                            else{echo "Not Active";}
                            ?>
                </td>
                <td><?= explode(' ' ,$specDate[5])[0] ?></td>
                <?php if($specDate[6] != ''){$specDate[6] = explode(' ' ,$specDate[6])[0];} ?>
                <td><?= $specDate[6] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="brand_operations.php?update=<?= $specDate[0] ?>" class="btn btn-info  mt-2">Update</a>
                </td>
                <td>
                  <a href="brand_operations.php?delete=<?= $specDate[0] ?>" class="btn btn-danger  mt-2">Delete</a>
                </td>
              </tr>
              <?php }} ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
              <th>Id</th>
                <th>Image</th>
                <th>English Name</th>
                <th>Arabic Name</th>
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
