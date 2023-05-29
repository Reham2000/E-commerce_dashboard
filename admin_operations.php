<?php
$title = "Admins";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\Admin;
use App\Http\Requests\Validation;

$admin = new Admin;
$validation = new Validation;


if($_SERVER['REQUEST_METHOD'] == "POST")
{
  $validation->setInput('first_name')->setValue($_POST['first_name'])->required()->min(2)->max(32);
  $validation->setInput('last_name')->setValue($_POST['last_name'])->required()->min(2)->max(32);
  $validation->setInput('email')->setValue($_POST['email'])->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('admins','email');
  $validation->setInput('phone')->setValue($_POST['phone'])->required()->regex('/^01[0125][0-9]{8}$/')->unique('admins','phone');
  $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'mini 8 chars max 32 ,mini one number , one character , one uppercase letter , one lowercase letter , one specidal char')->confirmed($_POST['confirm_password']);
  $validation->setInput('confirm_password')->setValue($_POST['confirm_password'])->required();
  if(isset($_POST['gender'])){
    $validation->setInput('gender')->setValue($_POST['gender'])->required()->in(['m','f']);
  }else{
    $genderError = "<p class='text-danger font-weight-bold'> Gender is required </p>";
  }


  if(empty($validation->getErrors()))
  {
    $verification_code = rand(10000,99999);
    $expired_at =  date("Y-m-d H:i:s", strtotime('+48 hours'));
    $admin->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setPassword($_POST['password'])->setGender($_POST['gender'])->setVerification_code($verification_code)->setExpired_at($expired_at);
    if($admin->create())
    {
      header("location:admins.php");die;
    }else{
      $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
    }
  }

// print_r($_POST);die;
}

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- ####breadcrumb -->
  <?php  include "includes/breadcrumb.php"; ?>

  <!-- Main content -->
  <section class="content">
    <div class="container">
      <!-- Add Admin -->
      <div class="row p-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>add_user.png" alt="">
          <h2 class="text-ingo text-center py-3">Add Admin</h2>
        </div>
        <form action="" method="post" class="col-md-7 col-sm-12 px-3">
        <?= $error ?? '' ?>

          <div class="form-group">
            <input type="text" name="first_name" id="" value="<?= $validation->getOldValue('first_name') ?>" class="form-control" placeholder="Enter Admin First Name ...">
            <?= $validation->getMessage('first_name') ?>
          </div>
          <div class="form-group">
            <input type="text" name="last_name" value="<?= $validation->getOldValue('last_name') ?>" id="" class="form-control" placeholder="Enter Admin Last Name ...">
            <?= $validation->getMessage('last_name') ?>
          </div>
          <div class="form-group">
            <input type="text" name="email" value="<?= $validation->getOldValue('email') ?>" id="" class="form-control" placeholder="Enter Admin Email ...">
            <?= $validation->getMessage('email') ?>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" value="<?= $validation->getOldValue('phone') ?>" id="" class="form-control" placeholder="Enter Admin Phone ...">
            <?= $validation->getMessage('phone') ?>
          </div>
          <div class="form-group">
            <input type="password" name="password" id="" class="form-control" placeholder="Enter Admin Password ...">
            <?= $validation->getMessage('password') ?>
          </div>
          <div class="form-group">
            <input type="password" name="confirm_password" id="" class="form-control" placeholder="Confirm Admin Password ...">
            <?= $validation->getMessage('confirm_password') ?>
          </div>
          <select name="gender" id="" class="form-control">
            <option selected disabled value>Select Admin Gender</option>
            <option <?= $validation->getOldValue('gender') == 'm' ? 'selected' : '' ?> value="m" >Male</option>
            <option <?= $validation->getOldValue('gender') == 'f' ? 'selected' : '' ?> value="f">Female</option>
          </select>
          <?= $genderError ?? '' ?>
          <?= $validation->getMessage('gender') ?>
          <input type="submit" value="Add Admin" class="btn btn-info px-2">
        </form>
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
