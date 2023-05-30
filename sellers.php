<?php
$title = "sellers";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\Seller;

$seller = new Seller;
$sellers = $seller->read()->fetch_all();

// print_r($sellers);die;

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
        <a href="seller_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New seller <i
            class="fas fa-user-plus pl-3"></i></a>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Logo</th>
                <th>Phone</th>
                <th>E-mail</th>
                <th>Region</th>
                <th>City</th>
                <th>Address</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
                        foreach ($sellers as $sellerDate) {?>
              <tr class="text-center">
                <td><?= $sellerDate[0] ?></td>
                <td><?= $sellerDate[1] . " " . $sellerDate[2] ?></td>
                <td><?= $sellerDate[3] ?></td>
                <td><?= $sellerDate[5] ?></td>
                <td>
                  <?php
                            if($sellerDate[7] == 'm'){echo "Male";}
                            else{echo "Female";}
                            ?>
                </td>
                <td>
                  <?php
                            if($sellerDate[10] == '1'){echo "Active";}
                            else{echo "Not Active";}
                            ?>
                </td>
                <td><?= $sellerDate[11] ?? 'Not Verified yet' ?></td>
                <td><?= explode(' ' ,$sellerDate[12])[0] ?></td>
                <?php if($sellerDate[13] != ''){$sellerDate[13] = explode(' ' ,$sellerDate[13])[0];} ?>
                <td><?= $sellerDate[13] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="seller_operations.php?update=<?= $sellerDate[0] ?>" class="btn btn-info  mt-2">Update</a>
                </td>
                <td>
                  <a href="seller_operations.php?delete=<?= $sellerDate[0] ?>" class="btn btn-danger  mt-2">Delete</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
              <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Logo</th>
                <th>Phone</th>
                <th>E-mail</th>
                <th>Region</th>
                <th>City</th>
                <th>Address</th>
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
