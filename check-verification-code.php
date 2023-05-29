<?php

use App\Database\Models\Admin;
use App\Http\Requests\Validation;

$title = "Verify Your Account";
include "includes/init.php";
include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

$_SESSION['email'] = "rehamabado@gmail.com";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

  $validation = new Validation;
  $validation->setInput('verification_code')->setValue($_POST['verification_code'])->required()->digits(5)->exists('admins','verification_code');
  if(empty($validation->getErrors())){
    // no validation error
    $admin = new Admin;
    $result = $admin->setEmail($_SESSION['email'])->setVerification_code($_POST['verification_code'])->checkCode();
    if($result->num_rows == 1){
        if($_GET['page'] == 'login' || $_GET['page'] == "register"){
            $admin->setEmail_verified_at(date('Y-m-d H:i:s'));
            if($admin->makeUserVerified()){
                unset($_SESSION['email']);
                // updated
                if($_GET['page'] == 'register'){
                    $success = "<div class='alert alert-success text-center'> Admin Verified Successfully ... </div>";
                    header('refresh:3; url=admins.php');
                }else{
                    $_SESSION['Admin'] = $result->fetch_object();
                    header('location:admins.php');die;
                }
            }else{
                $error = "<div class='alert alert-danger text-center'> Something Went Wrong </div>";
            }
        }elseif($_GET['page'] == 'forget'){
            header('location:set-new-password.php');die;
        }
    }else{
        $error = "<div class='alert alert-danger text-center'> Wrong Verification Code </div>";
    }
}
}


?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- ####breadcrumb -->
  <?php  include "includes/breadcrumb.php"; ?>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row w-75 m-auto">
        <div class="col-md-3 py-5">
          <img class="w-100 my-5" src="<?= $dashboardImagesPath ?>verified.svg" alt="verify logo">
        </div>
        <div class="col-md-8">
          <form action="" method="post" class="w-75 ml-auto pt-5">
            <h1 class="py-5">Verify Your Account</h1>
            <?= $error ?? "" ?>
            <?= $success ?? "" ?>
            <div class="form-group">
              <input type="number" name="verification_code" id="" placeholder="*****" class="fs-3 form-control">
              <?= isset($validation) ? $validation->getMessage('verification_code') : '' ?>
            </div>
            <div class="form-group text-center ">
              <input type="submit" value="Verify" class="btn btn-info my-3 px-4" >
            </div>
          </form>
        </div>
      </div>
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
