<?php
$title = "Regions";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\City;
use App\Database\Models\Region;

$region = new Region;
$regions = $region->read()->fetch_all();

// print_r($regions);die;

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
        <a href="region_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New Region <i
            class="fas fa-user-plus pl-3"></i></a>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>Id</th>
                <th>English Name</th>
                <th>Arabic Name</th>
                <th>City</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
                        foreach ($regions as $regionDate) {?>
              <tr class="text-center">
                <td><?= $regionDate[0] ?></td>
                <td><?= $regionDate[1] ?></td>
                <td><?= $regionDate[2] ?></td>
                <td>
                  <?php
                    $city = new City;
                    $cityData = $city->setId($regionDate[4])->getCityById()->fetch_object();
                    echo $cityData->name_en . " ( " . $cityData->name_ar . " )";
                  ?>
                </td>
                <td>
                  <?php
                            if($regionDate[3] == '1'){echo "Active";}
                            else{echo "Not Active";}
                            ?>
                </td>
                <td><?= explode(' ' ,$regionDate[5])[0] ?></td>
                <?php if($regionDate[6] != ''){$regionDate[6] = explode(' ' ,$regionDate[6])[0];} ?>
                <td><?= $regionDate[6] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="region_operations.php?update=<?= $regionDate[0] ?>" class="btn btn-info  mt-2">Update</a>
                </td>
                <td>
                  <a href="region_operations.php?delete=<?= $regionDate[0] ?>" class="btn btn-danger  mt-2">Delete</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
                <th>Id</th>
                <th>English Name</th>
                <th>Arabic Name</th>
                <th>City</th>
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
