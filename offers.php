<?php
$title = "Offers";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\Offer;

$offer = new Offer;
$offers = $offer->read()->fetch_all();

// print_r($offers);die;

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
        <a href="offer_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New Offer <i
            class="fas fa-user-plus pl-3"></i></a>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>Id</th>
                <th>Image</th>
                <th>Title</th>
                <th>Discount</th>
                <th>Discount Type</th>
                <th>Start At</th>
                <th>End At</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if(empty($offers)){ ?>
                <td colspan="11" class='text-center text-danger display-4 text-bold'>No <?= $title ?> To Show</td>
              <?php }else{
              foreach ($offers as $offerDate) {?>
              <tr class="text-center">
                <td><?= $offerDate[0] ?></td>
                <td><img class="w-50" src="<?= !empty($offerDate[2]) ? $offerPath . $offerDate[2] : $offerPath . 'default.jpg' ?>" alt="<?= $offerDate[1] . " [ " . $offerDate[2] . " ] "  ?>"></td>
                <td><?= $offerDate[1] ?></td>
                <td><?= $offerDate[3] ?></td>
                <td><?= $offerDate[4] ?></td>
                <td><?= explode(' ' ,$offerDate[5])[0] ?></td>
                <td><?= explode(' ' ,$offerDate[6])[0] ?></td>
                <td><?= explode(' ' ,$offerDate[7])[0] ?></td>
                <?php if($offerDate[6] != ''){$offerDate[6] = explode(' ' ,$offerDate[6])[0];} ?>
                <td><?= $offerDate[6] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="offer_operations.php?update=<?= $offerDate[0] ?>" class="btn btn-info  mt-2">Update</a>
                </td>
                <td>
                  <a href="offer_operations.php?delete=<?= $offerDate[0] ?>" class="btn btn-danger  mt-2">Delete</a>
                </td>
              </tr>
              <?php } } ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
              <th>Id</th>
                <th>Image</th>
                <th>Title</th>
                <th>Discount</th>
                <th>Discount Type</th>
                <th>Start At</th>
                <th>End At</th>
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
