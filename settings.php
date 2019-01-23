<?php
  session_start();
  ob_start();
  $pagetitle = "Account Settings";
  include "connect.php";

  if (isset($_SESSION) && !empty($_SESSION)) {
    include "includes/templates/header.php";
    include "includes/templates/navbar.php";
  }else {
    header("location: login.php");
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // errors
    $errors = [];

    // check if is the fields set or not
    if (isset($_POST['fname'])) {
      $fullname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
    }else {
      $errors[] = "<div class='alert alert-danger l-capital'>The full name field isn't <strong>exist</strong></div>";
    }
    if (isset($_POST['npass']) && isset($_POST['repass'])) {
      $newpass = $_POST['npass'];
      $repass = $_POST['repass'];
    }else {
      $errors[] = "<div class='alert alert-danger l-capital'>The password field isn't <strong>exist</strong></div>";
    }
    if (isset($_POST['email'])) {
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    }else {
      $errors[] = "<div class='alert alert-danger l-capital'>The email field isn't <strong>exist</strong></div>";
    }

    if (empty($errors)) {
      // fullname
      if (empty($fullname)) {
        $errors[] = "<div class='alert alert-danger l-capital'>You can't let the full name <strong>empty</strong></div>";
      }
      if (strlen($fullname) < 6) {
        $errors[] = "<div class='alert alert-danger l-capital'>the full name can't be less than <strong>6 characters</strong></div>";
      }

      // email
      if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = "<div class='alert alert-danger l-capital'>this email isn't <strong>valid</strong></div>";
      }

      // end if statment
    }

    // insert into database
    if (empty($errors)) {
      $_SESSION['fnorname'] = $fullname;
      $stmt = $con->prepare("UPDATE users SET fullname = :fullname, email = :email WHERE userid = :id");
      $stmt->execute([
        'fullname' => $fullname,
        'email' =>  $email,
        'id' => $_SESSION['norid']
      ]);
      $counter = $stmt->rowCount();

      if (!empty($newpass) && !empty($repass)){
        if (strlen($newpass) < 6) {
          $errors[] = "<div class='alert alert-danger l-capital'>the password can't be less than <strong>6 characters</strong></div>";
        }

        if ($newpass != $repass) {
          $errors[] = "<div class='alert alert-danger l-capital'>the password <strong>doesn't match</strong></div>";
        }

        if (empty($errors)) {
          $hashed_pass = sha1($newpass);

          $stmt = $con->prepare("UPDATE users SET Password = ? WHERE UserID = ?");
          $stmt->execute([$hashed_pass, $_SESSION['norid']]);
          $stmt->rowCount();
          $errors[] = "<div class='alert alert-success l-capital'>the data had been Updated <strong>successfully</strong></div>";
        }

      }else {
        $errors[] = "<div class='alert alert-success l-capital'>the data had been Updated <strong>successfully</strong></div>";
      }
    }

    //=============== the image uploading system ==================

    // image upload
    $img_errors = [];
    if (isset($_FILES['profile-img'])){
      $img = $_FILES['profile-img'];
    }else {
      $img_errors[] = "<div class='alert alert-danger l-capital'>The image field isn't <strong>exist</strong></div>";
    }
    // echo "<pre>";
    // print_r($img);
    // echo "</pre>";
    // echo __dir__;
    // echo rand(0,1000000);

    if (!empty($img['name']) && empty($img_errors)) {
      // the allowed exitions
      $allowed_extintions = ['jpg', 'jpeg', 'png', 'gif'];
      // img exition
      $img_ext_arr = explode('.', $img['name']);
      $img_ext = strtolower(end($img_ext_arr));

      // img validation
      if (!in_array($img_ext, $allowed_extintions)){
        $img_errors[] = "<div class='alert alert-danger l-capital'>This type of the image isn't <strong>allowed</strong></div>";
      }
      if ($img['size'] > 4194304) {
        $img_errors[] = "<div class='alert alert-danger l-capital'>this img is <strong>too big</strong></div>";
      }
      // uploading the image
      if (empty($img_errors)) {
        $img_name = rand(0,1000000) . "_" . $img['name'];
        if (is_dir(__dir__ . '/data/profile-imgs')) {
          move_uploaded_file($img['tmp_name'], __dir__ . '/data/profile-imgs/' . $img_name);

          // insert into the database
          $stmt = $con->prepare("UPDATE users SET `profile-img` = :img WHERE userid = :id");
          $stmt->execute([
            'img' => $img_name,
            'id' => $_SESSION['norid']
          ]);

          $img_errors[] = "<div class='alert alert-success l-capital'>the profile image had been uploaded <strong>successfully</strong></div>";
        }else {
          mkdir(__dir__ . '/data/profile-imgs');
          move_uploaded_file($img['tmp_name'], __dir__ . '/data/profile-imgs/' . $img_name);

          // insert into the database
          $stmt = $con->prepare("UPDATE users SET `profile-img` = :img WHERE userid = :id");
          $stmt->execute([
            'img' => $img_name,
            'id' => $_SESSION['norid']
          ]);

          $img_errors[] = "<div class='alert alert-success l-capital'>the profile image had been uploaded <strong>successfully</strong></div>";
        }
      }
    }

    // the end for the request method condition
  }

  // Get user information
  $statement = $con->prepare("SELECT username, email, fullname, `date` FROM users WHERE userid = ?");
  $statement->execute([ $_SESSION['norid'] ]);
  $Userinfo = $statement->fetch(); ?>

<div class="container">
  <div class="settings mt-4">
    <div class="row">
      <div class="photo col-12 col-sm-12 col-md-12 col-lg-5">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-9 border p-2">
            <img class="img-fluid img-thumbnail p-0" src="<?php echo getimg("SELECT `profile-img` FROM users WHERE userid = " . $_SESSION['norid']); ?>" alt="<?php echo $Userinfo[0]; ?>">
          </div>
          <!-- <form class="col-12 col-sm-12 col-md-12 mt-3" action="settings.php" method="post" enctype="multipart/form-data">
            <input type="file" name="profile-img" class="btn btn-secondary m-auto">
          </form> -->
        </div>
      </div>
      <div class="information col-12 col-sm-12 col-md-7">
        <h2 class="text-center mb-5 mt-3">Edit Data</h2>
        <form class="form-group" action="settings.php" method="post" enctype="multipart/form-data">
          <div class="form-row mb-4">
            <label class="col col-form-label h3">Username :</label>
            <input class="col-12 col-sm-12 col-md-10 form-control" type="text" value="<?php echo $Userinfo[0]; ?>" disabled required>
          </div>
          <div class="form-row mb-4">
            <label class="col col-form-label h3">Full-Name :</label>
            <input class='col-12 col-sm-12 col-md-9 form-control' type="text" name="fname" value="<?php echo $Userinfo[2]; ?>" required pattern=".{4,}" title="This field requires more than 4 characters">
          </div>
          <div class="form-row mb-4">
            <label class="col col-form-label h3">New_Password :</label>
            <div class="input-group p-0 col-md-9 col-12 col-sm-12">
              <input type="password" name="npass" class="form-control p-2" placeholder="New Password (Optional)" autocomplete="new-password">
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button" id="show">
                  <i class="fa fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-row mb-4">
            <label class="col col-form-label h3">Re_Password :</label>
            <input class='col-12 col-sm-12 col-md-9 form-control' type="password" name="repass" placeholder="Re-Write The Password" autocomplete="new-password">
          </div>
          <div class="form-row mb-4">
            <label class="col col-form-label h3">E-mail :</label>
            <input class='col-12 col-sm-12 col-md-9 form-control bold' type="text" name="email" value="<?php echo $Userinfo[1]; ?>" required>
          </div>
          <input type="file" name="profile-img" class="border-secondary border p-1 col-12">
          <input type="submit" class="col-12 col-sm-12 col-md-6 btn btn-primary float-md-right float-none mt-2" value="Save Changes">
        </form>
      </div>
      <div class="errors col-12 mt-3">
<?php
        if (isset($errors) && !empty($errors)) {
          foreach ($errors as $error) {
            echo $error;
          }
        }
        if (isset($img_errors) && !empty($img_errors)) {
          foreach ($img_errors as $img_error) {
            echo $img_error;
          }
        } ?>
      </div>
    </div>
  </div>
</div>
<?php
  include "includes/templates/footer.html";
  ob_end_flush(); ?>
