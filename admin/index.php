<?php
  ob_start();
  session_start();
  $pagetitle = 'Login';
  if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
    exit();
  }
  include "connect.php";
  include "includes/templates/header.php";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if( isset($_POST["passlog"]) && isset($_POST["userlog"]) ){
      $username   = $_POST["userlog"];
      $password   = $_POST["passlog"];
      $hachpass   = sha1($password);
      //checking and queries by prepare and statments
      $stmt = $con->prepare("SELECT Fullname, UserID, Username, Password FROM users WHERE Username = ? AND Password = ? AND groupid = 1");
      $stmt->execute([$username, $hachpass]);
      $userinfo = $stmt->fetch();
      $count = $stmt->rowcount();
      if ($count > 0){
        $_SESSION['user'] = strtolower($username);
        $_SESSION['id'] = $userinfo['UserID'];
        $_SESSION['fname'] = strtolower($userinfo['Fullname']); // to use the full name that is stored in the database
        header('location: dashboard.php');
        exit();
      }//else {
      //   $err = '<h3 class="err">*Sorry, The Username and the Password are wrong</h3>';
      //   echo $err;
      // }
    }
  }
?>
    <!-- Start Body -->
    <form class="login col-12 col-sm-10 col-md-9 col-lg-7 col-xl-5 m-auto" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h4 class="text-center">Admin Login</h4>
      <input class="form-control mt-3" name="userlog" type="text" placeholder="User Name">
      <input class="form-control mt-3" name="passlog" type="password" placeholder="Password">
      <input class="btn btn-primary btn-block mt-3" type="submit" value="Log in">
      <?php if (isset($count) && $count <= 0) {
              echo "<div class='alert alert-danger text-center l-capital mt-3'>*Sorry, The Username and the password you entered is wrong</div>";
            } ?>
    </form>
    <!-- End Body -->
<?php
  include "includes/templates/footer.html";
  ob_end_flush();?>
