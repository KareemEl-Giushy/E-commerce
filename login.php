<?php
  ob_start();
  session_start();
  $pagetitle = 'Login / Sign UP';

  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php";

  $act = isset($_GET['act']) && !empty($_GET['act']) ? $_GET['act'] : 'login-form';

  if (isset($_SESSION['noruser'])){
    header("location: index.php");
    exit();
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login']) && !empty($_POST['login'])){
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
    }elseif (isset($_POST['signup']) && !empty($_POST['signup'])){

      // The full name
      if (isset($_POST['first-name']) && isset($_POST['last-name'])) {

        if (empty($_POST['first-name'])) {
          $formerrors[] = "<div class= 'alert alert-danger l-capital'>The first name can't be <strong>empty</strong></div>";
        }
        if (empty($_POST['last-name'])) {
          $formerrors[] = "<div class= 'alert alert-danger l-capital'>The last name can't be <strong>empty</strong></div>";
        }

        $theuser = $_POST['first-name'] ." ". $_POST['last-name'];
        $newuser = filter_var($theuser, FILTER_SANITIZE_STRING);

        // The Full-Name validate
        if (empty($newuser)) {
          $formerrors[] = "<div class='alert alert-danger l-capital'>The <strong>Full-Name</strong> you entered can't be empty</div>";
        }
        if (strlen($newuser) < 6) {
          $formerrors[] = "<div class='alert alert-danger l-capital'>The <strong>Full-Name</strong> you entered can't be less than 6 characters</div>";
        }

      }else {
        $formerrors[] = "<div class='alert alert-danger l-capital'>There aren't any fields to validate</div>";
      }

      // Username
      if (isset($_POST['usernamey'])) {
        $newusername = filter_var($_POST['usernamey'], FILTER_SANITIZE_STRING);

        // The Username validate
        if (empty($newusername)) {
          $formerrors[] = "<div class='alert alert-danger l-capital'>The <strong>username</strong> can't be empty</div>";
        }
        if ( preg_match('/\s/',$newusername) ){
          $formerrors[] = "<div class='alert alert-danger l-capital'>The username <srtong>mustn't have whitespaces</strong></div>";
        }
        if (strlen($newusername) < 4) {
          $formerrors[] = "<div class='alert alert-danger l-capital'>The <strong>Username</strong> you entered can't be less than 4 characters</div>";
        }

      }else {
        $formerrors[] = "<div class='alert alert-danger l-capital'>There aren't any fields to validate</div>";
      }

      // E-mail
      if (isset($_POST['e-mail'])) {
        $new_email = filter_var($_POST['e-mail'], FILTER_SANITIZE_EMAIL);

        if (filter_var($new_email, FILTER_VALIDATE_EMAIL) == false) {
          $formerrors[] = "<div class='alert alert-danger l-capital'>The e-mail you entered isn't <strong>valid</strong></div>";
        }

      }else {
        $formerrors[] = "<div class='alert alert-danger l-capital'>There aren't any fields to validate</div>";
      }

      // Password
      if (isset($_POST['pass']) && isset($_POST['re-pass'])) {

        // Password empty validate
        if (empty($_POST['pass']) || empty($_POST['re-pass'])) {
          $formerrors[] = "<div class='alert alert-danger l-capital'><strong>The password can't be empty</strong></div>";
        }
        if (strlen($_POST['pass']) < 6) {
          $formerrors[] = "<div class='alert alert-danger l-capital'>The <strong>Password</strong> you entered can't be less than 6 characters</div>";
        }

        $pass = sha1($_POST['pass']);
        $re_pass = sha1($_POST['re-pass']);

        // The password valitdate
        if ($pass !== $re_pass) {
          $formerrors[] = "<div class='alert alert-danger l-capital'>The two passwords don't <strong>match with each other</strong></div>";
        }

      }else {
        $formerrors[] = "<div class='alert alert-danger l-capital'>There aren't any fields to validate</div>";
      }

      // insert into the database
      if (empty($formerrors)){
        if (checkuser('username', 'users', $newusername) == false) {
          $stmt = $con->prepare("INSERT INTO users(username, password, email, fullname, `date`) VALUES(:nuser, :npass, :nemail, :nfullname, now())");
          $stmt->execute([
            'nuser' => $newusername,
            'npass' => $pass,
            'nemail' => $new_email,
            'nfullname' => $newuser
          ]);

          //success message
          $sumass = "<div class='alert alert-success l-capital mt-3'>Thank you for signing up to our site you can now login :).</div>";
        }else {
          $act = 'signup-form';
          $formerrors[] = "<div class='alert alert-danger l-capital'>The username you entered is <strong>already exists</strong></div>";
        }
      }else {
        $act = 'signup-form';
      }
    }else {
      header("location: index.php");
      exit();
    }
  } ?>

<div class="container login-signup" style="height: 625px;">
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
          <input type="submit" class="form-control col-12 col-sm-12 col-lg-6 m-auto d-block" name='login' value="Login" style="cursor: pointer;">
          <?php if (isset($rowcount) && $rowcount <= 0) {
                  echo "<div class='alert alert-danger text-center l-capital mt-3'><strong>* invalid</strong> Username or password</div>";
                }
                if (isset($sumass)) {
                  echo $sumass;
                } ?>
        </form>
      </div>
      <div class="signup" style="<?php if($act == 'login-form'){echo "display: none";} ?>">
        <h2 class="text-center mb-3 mt-3 l-capital">Sign UP</h2>
        <form class="form-group m-auto w-75" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
            <input type="text" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" name="usernamey" pattern=".{4,}" title="Must Be 4 Chars At Least" placeholder="Username" autocomplete="nickname" required/>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">E-mail</label>
            <input type="email" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" name="e-mail" placeholder="E-mail" required/>
          </div>
          <div class="form-row mb-2">
            <label class="col col-form-label">Password</label>
            <div class="input-group p-0 col-md-9 col-12 col-sm-12 col-lg-9">
              <input type="password" name="pass" class="form-control pl-1" minlength='6' placeholder="Password" autocomplete="new-password" required>
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button" id="show">
                  <i class="fa fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Re-Password</label>
            <input type="password" class="form-control col-12 col-sm-12 col-md-9 col-lg-9" name="re-pass" minlength='6' placeholder="Re-Password" autocomplete="new-password" required/>
          </div>
          <input type="submit" class="form-control mt-3 mb-3" name='signup' value="Sign UP" style="cursor: pointer;">
        </form>
        <div class="errors">

<?php
        if (!empty($formerrors)) {
          foreach ($formerrors as $error) {
            echo $error;
          }
          // it make a bug because it reloads the page
          // header("location: login.php?act=signup-form");
        } ?>
       </div>
      </div>
  </div>
</div>

<?php
  include "includes/templates/footer.html";
  ob_end_flush(); ?>
