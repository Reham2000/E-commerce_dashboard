<?php
$title = "users";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\User;
use App\Http\Requests\Validation;

$user = new User;
$validation = new Validation;

if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
  $user->setId($_GET['delete'])->delete();
  header("location:users.php");

}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['update']) && is_numeric($_GET['update'])) {
    $userData = $user->setId($_GET['update'])->getuserById($_GET['update'])->fetch_object();
    $validation->setInput('first_name')->setValue($_POST['first_name'])->isChanged($userData->first_name);
    if ($validation->getChanged() == '1') {
      $validation->setInput('first_name')->setValue($_POST['first_name'])->required()->min(2)->max(32);
    }
    $validation->setInput('last_name')->setValue($_POST['last_name'])->isChanged($userData->last_name);
    if ($validation->getChanged() == '1') {
      $validation->setInput('last_name')->setValue($_POST['last_name'])->required()->min(2)->max(32);
    }
    $validation->setInput('email')->setValue($_POST['email'])->isChanged($userData->email);
    if ($validation->getChanged() == '1') {
      $validation->setInput('email')->setValue($_POST['email'])->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('users', 'email');
    }
    $validation->setInput('phone')->setValue($_POST['phone'])->isChanged($userData->phone);
    if ($validation->getChanged() == '1') {
      $validation->setInput('phone')->setValue($_POST['phone'])->required()->regex('/^01[0125][0-9]{8}$/')->unique('users', 'phone');
    }
    $validation->setInput('gender')->setValue($_POST['gender'])->isChanged($userData->gender);
    if ($validation->getChanged() == '1') {
      $validation->setInput('gender')->setValue($_POST['gender'])->required()->in(['m', 'f']);
    }
    $validation->setInput('status')->setValue($_POST['status'])->isChanged($userData->status);
    if ($validation->getChanged() == '1') {
      $validation->setInput('status')->setValue($_POST['status'])->required()->in(['1', '2']);
    }

    if (empty($validation->getErrors())) {
      // print_r($_POST);die;
        $user->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setPassword($_POST['password'])->setGender($_POST['gender'])->setStatus($_POST['status']);
        if ($user->setId($_GET['update'])->update()) {
          header("location:user_operations.php?update={$_GET['update']}");
          die;
        } else {
          $error = "<div class='alert alert-danger text-center p-1' role='alert'><h4>Something Went Wrong</h4></div>";
        }
    }
  } else {
    $validation->setInput('first_name')->setValue($_POST['first_name'])->required()->min(2)->max(32);
    $validation->setInput('last_name')->setValue($_POST['last_name'])->required()->min(2)->max(32);
    $validation->setInput('email')->setValue($_POST['email'])->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('users', 'email');
    $validation->setInput('phone')->setValue($_POST['phone'])->required()->regex('/^01[0125][0-9]{8}$/')->unique('users', 'phone');
    $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'mini 8 chars max 32 ,mini one number , one character , one uppercase letter , one lowercase letter , one specidal char')->confirmed($_POST['confirm_password']);
    $validation->setInput('confirm_password')->setValue($_POST['confirm_password'])->required();
    if (isset($_POST['gender'])) {
      $validation->setInput('gender')->setValue($_POST['gender'])->required()->in(['m', 'f']);
    } else {
      $genderError = "<p class='text-danger font-weight-bold'> Gender is required </p>";
    }
    if (empty($validation->getErrors())) {
      $verification_code = rand(10000, 99999);
      $expired_at =  date("Y-m-d H:i:s", strtotime('+48 hours'));
      $user->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setPassword($_POST['password'])->setGender($_POST['gender'])->setVerification_code($verification_code)->setExpired_at($expired_at);
      if ($user->create()) {
        header("location:users.php");
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
      <!-- Add user -->
      <a href="users.php" class="btn btn-secondary"><i class="fas fa-backward px-2"></i> Back </a>
      <div class="row p-3">
        <div class="col-md-5 col-sm-12 text-center my-5">
          <img src="<?= $dashboardImagesPath ?>add_user.png" alt="">
          <h2 class="text-ingo text-center py-3 text-capitalize"><?= isset($_GET['update']) ? 'Update' : 'Add' ?> user</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $userData = $user->setId($_GET['update'])->getuserById()->fetch_object();
          ?>
          <form action="" method="post" class="col-md-7 col-sm-12 px-3">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="first_name" id="" value="<?= $userData->first_name ?>" class="form-control" placeholder="Enter user First Name ...">
              <?= $validation->getMessage('first_name') ?>
            </div>
            <div class="form-group">
              <input type="text" name="last_name" value="<?= $userData->last_name ?>" id="" class="form-control" placeholder="Enter user Last Name ...">
              <?= $validation->getMessage('last_name') ?>
            </div>
            <div class="form-group">
              <input type="text" name="email" value="<?= $userData->email ?>" id="" class="form-control" placeholder="Enter user Email ...">
              <?= $validation->getMessage('email') ?>
            </div>
            <div class="form-group">
              <input type="tel" name="phone" value="<?= $userData->phone ?>" id="" class="form-control" placeholder="Enter user Phone ...">
              <?= $validation->getMessage('phone') ?>
            </div>
            <select name="gender" id="" class="form-control mb-1">
              <option selected disabled value>Select user Gender</option>
              <option <?= $userData->gender == 'm' ? 'selected' : '' ?> value="m">Male</option>
              <option <?= $userData->gender == 'f' ? 'selected' : '' ?> value="f">Female</option>
            </select>
            <?= $genderError ?? '' ?>
            <?= $validation->getMessage('gender') ?>
            <select name="status" id="" class="form-control mb-1">
              <option selected disabled value>Select user Status</option>
              <option <?= $userData->status == '1' ? 'selected' : '' ?> value="1">Active</option>
              <option <?= $userData->status == '2' ? 'selected' : '' ?> value="2">Blocked</option>
            </select>
            <?= $validation->getMessage('status') ?>

            <input type="submit" value="Update user" class="btn btn-info my-2 px-2">
          </form>
        <?php } elseif(isset($_GET['delete'])) {
          echo "delete is loading";
        }
        else { ?>
          <form action="" method="post" class="col-md-7 col-sm-12 px-3">
            <?= $error ?? '' ?>
            <div class="form-group">
              <input type="text" name="first_name" id="" value="<?= $validation->getOldValue('first_name') ?>" class="form-control" placeholder="Enter user First Name ...">
              <?= $validation->getMessage('first_name') ?>
            </div>
            <div class="form-group">
              <input type="text" name="last_name" value="<?= $validation->getOldValue('last_name') ?>" id="" class="form-control" placeholder="Enter user Last Name ...">
              <?= $validation->getMessage('last_name') ?>
            </div>
            <div class="form-group">
              <input type="text" name="email" value="<?= $validation->getOldValue('email') ?>" id="" class="form-control" placeholder="Enter user Email ...">
              <?= $validation->getMessage('email') ?>
            </div>
            <div class="form-group">
              <input type="tel" name="phone" value="<?= $validation->getOldValue('phone') ?>" id="" class="form-control" placeholder="Enter user Phone ...">
              <?= $validation->getMessage('phone') ?>
            </div>
            <div class="form-group">
              <input type="password" name="password" id="" class="form-control" placeholder="Enter user Password ...">
              <?= $validation->getMessage('password') ?>
            </div>
            <div class="form-group">
              <input type="password" name="confirm_password" id="" class="form-control" placeholder="Confirm user Password ...">
              <?= $validation->getMessage('confirm_password') ?>
            </div>
            <select name="gender" id="" class="form-control">
              <option selected disabled value>Select user Gender</option>
              <option <?= $validation->getOldValue('gender') == 'm' ? 'selected' : '' ?> value="m">Male</option>
              <option <?= $validation->getOldValue('gender') == 'f' ? 'selected' : '' ?> value="f">Female</option>
            </select>
            <?= $genderError ?? '' ?>
            <?= $validation->getMessage('gender') ?>
            <input type="submit" value="Add user" class="btn btn-info px-2">
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
