<?php
$title = "Cities";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\City;

$city = new City;
$cities = $city->read()->fetch_all();

// print_r($cities);die;

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
        <a href="city_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New city <i
            class="fas fa-user-plus pl-3"></i></a>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>Id</th>
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
              if(empty($cities)){ ?>
                <td colspan="8" class='text-center text-danger display-4 text-bold'>No <?= $title ?> To Show</td>
              <?php }else{
                        foreach ($cities as $cityDate) {?>
              <tr class="text-center">
                <td><?= $cityDate[0] ?></td>
                <td><?= $cityDate[1] ?></td>
                <td><?= $cityDate[2] ?></td>
                <td>
                  <?php
                            if($cityDate[3] == '1'){echo "Active";}
                            else{echo "Not Active";}
                            ?>
                </td>
                <td><?= explode(' ' ,$cityDate[4])[0] ?></td>
                <?php if($cityDate[5] != ''){$cityDate[5] = explode(' ' ,$cityDate[5])[0];} ?>
                <td><?= $cityDate[5] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="city_operations.php?update=<?= $cityDate[0] ?>" class="btn btn-info  mt-2"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                  <a href="city_operations.php?delete=<?= $cityDate[0] ?>" class="btn btn-danger  mt-2"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php }} ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
                <th>Id</th>
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
