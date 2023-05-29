<?php
$title = "Admins";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

use App\Database\Models\Admin;
use App\Mails\VerificationCode;
use App\Http\Requests\Validation;

$validation = new Validation;
$admin = new Admin;
echo "<script>toastr.info('Are you the 6 fingered man?');</script>";
if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
  $admin->setId($_GET['delete'])->delete();
  header("location:admins.php");

}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if(isset($_GET['update']) && is_numeric($_GET['update'])){
    $adminData = $admin->setId($_GET['update'])->getAdminById()->fetch_object();

    $validation->setInput('first_name')->setValue($_POST['first_name'])->isChanged($adminData->last_name);
    if($validation->getChanged() == 1){
      $validation->required()->min(2)->max(32);
    }

    $validation->setInput('last_name')->setValue($_POST['last_name'])->isChanged($adminData->last_name);
    if($validation->getChanged() == 1){
      $validation->required()->min(2)->max(32);
    }

    $validation->setInput('email')->setValue($_POST['email'])->isChanged($adminData->email);
    if($validation->getChanged() == 1){
      $validation->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('admins', 'email');
    }

    $validation->setInput('phone')->setValue($_POST['phone'])->isChanged($adminData->phone);
    if($validation->getChanged() == 1){
      $validation->required()->regex('/^01[0125][0-9]{8}$/')->unique('admins', 'phone');
    }
    if(isset($_POST['password']) && isset($_POST['confirm_password']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])){
      $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'mini 8 chars max 32 ,mini one number , one character , one uppercase letter , one lowercase letter , one specidal char')->confirmed($_POST['confirm_password']);
      $validation->setInput('confirm_password')->setValue($_POST['confirm_password'])->required();
    }

    $validation->setInput('gender')->setValue($_POST['gender'])->isChanged($adminData->gender);
    if($validation->getChanged() == 1){
      $validation->required()->in(['m','f']);
    }
    $validation->setInput('status')->setValue($_POST['status'])->isChanged($adminData->status);
    if($validation->getChanged() == 1){
      $validation->required()->in(['1','2']);
    }




    if (empty($validation->getErrors())) {
      if(!empty($_POST['password']) && !empty($_POST['confirm_password'])){
        $admin->setId($_GET['update'])->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setPassword($_POST['password'])->setGender($_POST['gender'])->setStatus($_POST['status'])->update();
      }else{
        $admin->setId($_GET['update'])->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setGender($_POST['gender'])->setStatus($_POST['status'])->updateWithoutPassword();
      }
    }
  }else{
    // $validation->setInput('first_name')->setValue($_POST['first_name'])->required()->min(2)->max(32);
    // $validation->setInput('last_name')->setValue($_POST['last_name'])->required()->min(2)->max(32);
    // $validation->setInput('email')->setValue($_POST['email'])->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('admins', 'email');
    // $validation->setInput('phone')->setValue($_POST['phone'])->required()->regex('/^01[0125][0-9]{8}$/')->unique('admins', 'phone');
    // $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'mini 8 chars max 32 ,mini one number , one character , one uppercase letter , one lowercase letter , one specidal char')->confirmed($_POST['confirm_password']);
    // $validation->setInput('confirm_password')->setValue($_POST['confirm_password'])->required();
    // if(isset($_POSt['gender'])){
      // $validation->setInput('gender')->setValue($_POST['gender'])->required()->in(['m','f']);
    // }else{
    //   $genderError = "<p class='text-danger font-weight-bold'> Post is Required </p>";
    // }

    print_r($_POST);die;

    // if (empty($validation->getErrors())) {
    //   $verification_code = rand(10000 ,99999);
    //   $expiredTime = date("Y-m-d H:i:s", strtotime('+5 hours'));
    //   $admin->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPassword($_POST['password'])->setPhone($_POST['phone'])->setgender($_POST['gender'])->setVerification_code($verification_code)->setExpired_at($expiredTime);
    //   if($admin->create()){
    //     $verificationCodeMail = new VerificationCode;
    //     $subject = "Admin Account Verification Code";
    //     $body = "<p>Hello {$_POST['first_name']}</p>
    //     <p>Your Verification Code Is : <b style='color:blue;'>{$verificationCode}</b></p>
    //     <p>Thank You.</p>";
    //     if ($verificationCodeMail->send($_POST['email'], $subject, $body)) {
    //       $_SESSION['email'] = $_POST['email'];
    //       header('location:check-verification-code.php?page=register');
    //       die;
    //   } else {
    //       $error = "<div class='alert alert-danger text-center'> Please Try Again Later </div>";
    //   }
    //   }else{
    //     $error = "<div class='alert alert-danger text-center'> Something Went Wrong </div>";
    //   }
    //   header("refrsh:5 ;url=admins.php");
    // }
  }
}
?>



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php  include "includes/breadcrumb.php"; ?>

  <!-- /.content-header -->
  <section class="content">
    <div class="container">
      <!-- <div class="row shadow"> -->
      <div class="row">
        <div class="col-4 page_logo text-center w-25 m-auto">
          <img src="<?= $dashboardImagesPath ?>add_user.png" class="rounded-circle" alt="Add Admin">
          <h2 class="text-center col-12 py-3"><?php if(isset($_GET['update'])) { echo 'Update' ; }else{ echo 'Add';} ?> Admin</h2>
        </div>
        <?php
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
          $adminData = $admin->setId($_GET['update'])->getAdminById()->fetch_object();
        ?>
          <div class="col-md-8 col-sm-12">
            <form action="" method="POST" enctype="multipart/form-data" class="w-75 mx-auto">
              <div class="col-12 form-group ">
                <input class="form-control" type="text" name="first_name" value="<?= $adminData->first_name ?>" placeholder="Enter Your First Name...">
                <?= $validation->getMessage('first_name') ?>
              </div>
              <div class="col-12 form-group ">
                <input class="form-control" type="text" name="last_name" value="<?= $adminData->last_name ?>" placeholder="Enter Your Last Name...">
                <?= $validation->getMessage('last_name') ?>
              </div>
              <div class="col-12 form-group ">
                <input class="form-control" type="email" name="email" value="<?= $adminData->email ?>" placeholder="Enter Your E-mail...">
                <?= $validation->getMessage('email') ?>
              </div>
              <div class="col-12 form-group ">
                <input class="form-control" type="tel" name="phone" value="<?= $adminData->phone ?>" placeholder="Enter Your Phone Number...">
                <?= $validation->getMessage('phone') ?>
              </div>
              <div class="col-12 form-group ">
                <input class="form-control" type="password" name="password" value="" placeholder="Change The Password...">
                <?= $validation->getMessage('password') ?>
              </div>
              <div class="col-12 form-group ">
                <input class="form-control" type="password" name="confirm_password" value="" placeholder="Confirm The Password...">
                <?= $validation->getMessage('confirm_password') ?>
              </div>
              <div class="col-12 form-group ">
                <select class="form-control" name="gender" id="">
                  <option disabled selected value>Choose The Gender...</option>
                  <option <?= $adminData->gender == 'm' ? 'selected' : '' ?> value="m">Male</option>
                  <option <?= $adminData->gender == 'f' ? 'selected' : '' ?> value="f">Female</option>
                </select>
                <?= $validation->getMessage('gender'); ?>
              </div>
              <div class="col-12 form-group ">
                <select class="form-control" name="status" id="">
                  <option disabled selected value>Choose The Gender...</option>
                  <option <?= $adminData->status == '1' ? 'selected' : '' ?> value="1">Active</option>
                  <option <?= $adminData->status == '2' ? 'selected' : '' ?> value="2">Blocked</option>
                </select>
                <?= $validation->getMessage('status'); ?>
              </div>
              <button type="submit" class="btn btn-primary mx-3">Update <i class="fas fa-pencil-alt"></i></button>
            </form>
          </div>
        <?php } elseif (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
          $admin->setId($_GET['delete'])->delete();
          header("location:admins.php");
      } else { ?>
          <div class="col-md-8 col-sm-12">
            <h2 class="text-center col-12 pt-3 pb-2">Add Admin</h2>
            <script>toastr.success('You clicked Success toast');</script>
            <form action="" method="POST" enctype="multipart/form-data" class="w-75 mx-auto">
              <div class="col-12 form-group mb-1">
                <input class="form-control" type="text" name="first_name" value="<?= $validation->getOldValue('first_name') ?>" placeholder="Enter Your First Name...">
                <?= $validation->getMessage('first_name') ?>
              </div>
              <div class="col-12 form-group mb-1">
                <input class="form-control" type="text" name="last_name" value="<?= $validation->getOldValue('last_name') ?>" placeholder="Enter Your Last Name...">
                <?= $validation->getMessage('last_name') ?>
              </div>
              <div class="col-12 form-group mb-1">
                <input class="form-control" type="text" name="email" value="<?= $validation->getOldValue('email') ?>" placeholder="Enter Your E-mail...">
                <?= $validation->getMessage('email') ?>
              </div>
              <div class="col-12 form-group mb-1">
                <input class="form-control" type="tel" name="phone" value="<?= $validation->getOldValue('phone') ?>" placeholder="Enter Your Phone Number...">
                <?= $validation->getMessage('phone') ?>
              </div>
              <div class="col-12 form-group mb-1">
                <input class="form-control" type="password" name="password" value="" placeholder="Enter Your Password...">
                <?= $validation->getMessage('password') ?>
              </div>
              <div class="col-12 form-group mb-1">
                <input class="form-control" type="password" name="confirm_password" value="" placeholder="Confirm Your Password...">
                <?= $validation->getMessage('confirm_password') ?>
              </div>
              <div class="col-12 form-group mb-1">
              <select name="gender" id="" class="form-control">
            <option disabled selected value>Choose The Gender...</option>
              <option <?= $validation->getOldValue('gender') == 'm' ? 'selected' : '' ?> value="m" >Male</option>
              <option <?= $validation->getOldValue('gender') == 'f' ? 'selected' : '' ?> value="f" >Female</option>
            </select>
                <?= $genderError ?? "" ?>
                <?= $validation->getMessage('gender'); ?>
              </div>
              <button type="submit" class="btn btn-primary mx-3 my-3">Add <i class="fas fa-user-plus pl-3"></i></button>
            </form>
          </div>
        <?php } ?>

      </div>

      <div class="col-12">

      </div>
      <!-- </div> -->
  </section>
</div>


<?php


include "includes/footer.php";
include "includes/scripts.php";
?>
