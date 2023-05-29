<?php
$title = "users";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\User;

$user = new User;
$users = $user->read()->fetch_all();

// print_r($users);die;

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
        <a href="user_operations.php" class=" mx-5 w-25 btn btn-success  mt-2"> Add New User <i
            class="fas fa-user-plus pl-3"></i></a>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Verified At </th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
                        foreach ($users as $userDate) {?>
              <tr class="text-center">
                <td><?= $userDate[0] ?></td>
                <td><?= $userDate[1] . " " . $userDate[2] ?></td>
                <td><?= $userDate[3] ?></td>
                <td><?= $userDate[5] ?></td>
                <td>
                  <?php
                            if($userDate[7] == 'm'){echo "Male";}
                            else{echo "Female";}
                            ?>
                </td>
                <td>
                  <?php
                            if($userDate[10] == '1'){echo "Active";}
                            else{echo "Not Active";}
                            ?>
                </td>
                <td><?= $userDate[11] ?? 'Not Verified yet' ?></td>
                <td><?= explode(' ' ,$userDate[12])[0] ?></td>
                <?php if($userDate[13] != ''){$userDate[13] = explode(' ' ,$userDate[13])[0];} ?>
                <td><?= $userDate[13] ?? 'Not Updated yet' ?></td>
                <td>
                  <a href="user_operations.php?update=<?= $userDate[0] ?>" class="btn btn-info  mt-2">Update</a>
                </td>
                <td>
                  <a href="user_operations.php?delete=<?= $userDate[0] ?>" class="btn btn-danger  mt-2">Delete</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr class="text-center">
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Verified At </th>
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
