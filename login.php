<?php
  ob_start();
  session_start();
  $pagetitle = 'Login / Sign UP';

  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php";

  $act = isset($_GET['act']) ? $_GET['act'] : 'login-form';

  if (isset($_SESSION['noruser'])){
    header("location: index.php");
    exit();
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pass']) && isset($_POST['uname'])){
      $username = $_POST['uname'];
      $password = $_POST['pass'];
      $hashed_password = sha1($_POST['pass']);

      $stmt = $con->prepare("SELECT Fullname, UserID, Username, Password FROM users WHERE Username = ? AND Password = ?");
      $stmt->execute([$username, $hashed_password]);
      $rowcount = $stmt->rowCount();
      if ($rowcount > 0) {
        $userinfo = $stmt->fetch();
        $_SESSION['noruser'] = strtolower($username);
        $_SESSION['norid'] = $userinfo['UserID'];
        $_SESSION['fnorname'] = strtolower($userinfo['Fullname']); // to use the full name that is stored in the database
        header('location: index.php');
        exit();
      }
    }
  } ?>

<div class="container">
  <div class="m-auto col-12 col-sm-12 col-md-9 col-lg-9">
    <div class="row mt-4">
      <!-- the buttons -->
      <div class="login-btn d-inline-block col-12 col-sm-12 col-md-6 col-lg-6 <?php if($act == 'login-form'){echo 'clickedy';} ?> mt-3">
        <h3>Login</h3>
      </div>
      <div class="signup-btn d-inline-block col-12 col-sm-12 col-md-6 col-lg-6 <?php if($act == 'signup-form'){echo 'clickedy';} ?> mt-3">
        <h3>Sign UP</h3>
      </div>
    </div>
      <!-- The Forms -->
      <div class="login" style="<?php if($act == 'login-form'){echo "display: block";}else{echo 'display: none';} ?>">
        <h2 class="text-center mb-3 mt-3 l-capital">Login</h2>
        <form class="form-group m-auto w-50" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="form-row mb-3">
            <label class="col col-form-label">Username</label>
            <input class='form-control col-12' type="text" name="uname" placeholder="Username"/>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Password</label>
            <input class='form-control col-12' type="password" name="pass" placeholder="The Password"/>
          </div>
          <input type="submit" class="form-control col-12 col-sm-12 col-lg-6 m-auto d-block" value="Login" style="cursor: pointer;">
          <?php if (isset($rowcount) && $rowcount <= 0) {
                  echo "<div class='alert alert-danger text-center l-capital mt-3'>*Sorry, The Username and the password you entered is wrong</div>";
                } ?>
        </form>
      </div>
      <div class="signup" style="<?php if($act == 'login-form'){echo "display: none";} ?>">
        <h2 class="text-center mb-3 mt-3 l-capital">Sign UP</h2>
        <form class="form-group m-auto w-75" action="" method="post">
          <div class="form-row mb-3 mt-5">
            <label class="col col-form-label">Full Name</label>
            <span class="small-negma">*</span>
            <div class="form-row col-12 col-sm-12 col-md-12 col-lg-10">
              <input type="text" class="form-control col-12 col-sm-12 col-md-6 col-lg-6 mb-2" name="first-name" placeholder="First Name"/>
              <span class="negma" style="left: 47%;">*</span>
              <input type="text" class="form-control col-12 col-sm-12 col-md-6 col-lg-6" name="last-name" placeholder="last Name" required/>
            </div>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Username</label>
            <input type="text" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" name="usernamey" placeholder="Username" autocomplete="nickname" required/>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">E-mail</label>
            <input type="email" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" name="e-mail" placeholder="E-mail" required/>
          </div>
          <div class="form-row mb-2">
            <label class="col col-form-label">Password</label>
            <div class="input-group p-0 col-md-9 col-12 col-sm-12 col-lg-9">
              <input type="password" name="pass" class="form-control" placeholder="Password" autocomplete="new-password" required>
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button" id="show">
                  <i class="fa fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Re-Password</label>
            <input type="password" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" name="re-password" placeholder="Re-Password" autocomplete="new-password" required/>
          </div>
          <input type="submit" class="form-control mt-3 float-right" value="Sign UP" style="cursor: pointer;">
        </form>
      </div>
  </div>
</div>

<?php
  include "includes/templates/footer.html";
  ob_end_flush(); ?>
