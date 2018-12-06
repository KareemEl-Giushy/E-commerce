<?php
  ob_start();
  session_start();
  $pagetitle = "Profile";
  $color = 'rgba(0, 0, 0, 0.5)';
  if (isset($_SESSION['user'])){
    // includes
    include 'connect.php';
    include 'includes/templates/header.php';
    include 'includes/templates/navbar.php';
    // Shorted if condition to check the act
    $act = isset($_GET['act']) ? $_GET['act'] : 'manage';
    // Start manage page
    if ($act == 'manage'){
      $query = '';
      if (isset($_GET['page']) && $_GET['page'] == "pending") {
        $query = 'AND regstatus = 0';
      }
      $stmt = $con->prepare("SELECT * FROM users WHERE groupid != 1 $query ORDER BY userid");
      $stmt->execute();
      $usersinfo = $stmt->fetchAll();
      // echo "<pre>";
      // print_r($usersinfo);
      // echo "</pre>";
    ?>
      <h2 class="text-center mb-5 mt-3">Manage</h2>
      <div class="container">
        <div class="table-responsive table-responsive-sm table-responsive-md table-striped table-hover">
          <table class="table table-bordered">
            <tr>
              <td>#ID</td>
              <td>Username</td>
              <td>E-Mail</td>
              <td>Full Name</td>
              <td>Registed Date</td>
              <td>Controls</td>
            </tr>
<?php
            foreach ($usersinfo as $user){
              echo "<tr>";
              echo "<td>" . $user[0] . "</td>";
              echo "<td>" . $user[1] . "</td>";
              echo "<td>" . $user[3] . "</td>";
              echo "<td>" . $user[4] . "</td>";
              echo "<td>" . $user[5] . "</td>";
              echo "<td>
                <a class='btn btn-success' href='users.php?act=edit&userid=" . $user[0] . "'><i class='fa fa-edit'></i> Edit</a>
                <a class='confirm btn btn-danger' href='users.php?act=delete&userid=" . $user[0] . "'><i class='fa fa-trash'></i> Delete</a>";
                if ($user['Regstatus'] == 0) {
                  echo "<a class='btn btn-info ml-1' href='users.php?act=activate&userid=" . $user[0] . "'><i class='fa fa-check-square'></i> Activate</a>";
                }
              echo"</td>";
              echo "</tr>";
            } ?>
          </table>
        </div>
        <a href="?act=add"><i class="fa fa-plus"></i> Add New User</a>
      </div>
<?php
    }elseif ($act == 'edit'){
      $theuser = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : $_SESSION['id'];
      $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
      $stmt->execute([$theuser]);
      $userinfo = $stmt->fetch();
      $count = $stmt->rowCount();
      if ($count > 0){
        // if ($userinfo[0] == $_SESSION['id']){
        // }else {
        // exit();
        // }?>
        <!-- start html -->
        <h2 class="text-center mb-5 mt-3">Edit User</h2>
        <div class="container">
          <div class="data float-left text-center">
            <h3 class="mb-3 pt-3 h4"><a href="?act=manage" style="color: <?php echo $color ?>;">Manage</a></h3>
            <h3 class="mb-3 h4"><a href="users.php?act=edit">Edit</a></h3>
            <h3 class="h4"><a href="users.php?act=add" style="color: <?php echo $color ?>;">Add</a></h3>
          </div>
          <form class="float-right w-75 border-left border-dark pl-5" action="users.php?act=update" method="post">
            <input type="hidden" name="userid" value="<?php echo $userinfo[0]; ?>">
            <div class="form-row mt-2">
              <label class="col-md-2 col-form-label">Username</label>
              <input type="text" name="username" class="form-control col-md-12 col-12 col-sm-12 col-lg-10" value="<?php echo $userinfo[1]; ?>" autocomplete="off" autofocus required>
            </div>
            <div class="form-row mt-2">
              <label class="col-md-2 col-form-label">Password</label>
              <div class="input-group p-0 col-md-12 col-12 col-sm-12 col-lg-10">
                <input type="password" name="pass" class="form-control" placeholder="New Password (Optional)" autocomplete="new-password">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button" id="show">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="form-row mt-2">
              <label class="col-md-2 col-form-label">E-mail</label>
              <input type="email" name="email" class="form-control col-md-12 col-12 col-sm-12 col-lg-10" value="<?php echo $userinfo[3]; ?>" required>
            </div>
            <div class="form-row mt-2">
              <label class="col-md-3 col-lg-2 col-form-label">Full Name</label>
              <input type="text" name="fname" class="form-control col-md-12 col-12 col-sm-12 col-lg-10" value="<?php echo $userinfo[4]; ?>" required>
            </div>
            <input type="submit" value="Send" class="btn btn-primary float-sm-none float-lg-right mt-2 col-md-3 col-12 col-sm-12">
          </form>
        </div>
<?php
      }else {
        gohome("<strong>There Is No Such A User</strong>");
        exit();
      }
    }elseif ($act == 'add'){?>
      <!-- start html -->
      <h2 class="text-center mb-5 mt-3">Add New User</h2>
      <div class="container">
        <div class="data float-left text-center">
          <h3 class="mb-3 pt-3 h4"><a href="?act=manage" style="color: <?php echo $color ?>;">Manage</a></h3>
          <h3 class="mb-3 h4"><a href="users.php?act=edit" style="color: <?php echo $color ?>;">Edit</a></h3>
          <h3 class="h4"><a href="users.php?act=add">Add</a></h3>
        </div>
        <form class="float-right w-75 border-left border-dark pl-5" action="users.php?act=insert" method="post">
          <div class="form-row mt-2">
            <label class="col-md-2 col-form-label">Username</label>
            <input type="text" name="username" class="form-control col-md-12 col-12 col-sm-12 col-lg-10" placeholder="Enter The Username" autocomplete="off" autofocus required>
          </div>
          <div class="form-row mt-2">
            <label class="col-md-2 col-form-label">Password</label>
            <div class="input-group p-0 col-md-12 col-12 col-sm-12 col-lg-10">
              <input type="password" name="pass" class="form-control" placeholder="Put A Complex Password" autocomplete="new-password" required>
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button" id="show">
                  <i class="fa fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-row mt-2">
            <label class="col-md-2 col-form-label">E-mail</label>
            <input type="email" name="email" class="form-control col-md-12 col-12 col-sm-12 col-lg-10" placeholder="Enter Your E-Mail" required>
          </div>
          <div class="form-row mt-2">
            <label class="col-md-3 col-lg-2 col-form-label">Full Name</label>
            <input type="text" name="fname" class="form-control col-md-12 col-12 col-sm-12 col-lg-10" placeholder="Enter Your Full Name" required>
          </div>
          <input type="submit" value="Add User" class="btn btn-primary float-sm-none float-lg-right mt-2 col-md-3 col-12 col-sm-12">
        </form>
      </div>
<?php
    }elseif ($act == 'update') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<h2 class='text-center mb-5 mt-3'>Edit Errors</h2>";
        $id               = $_POST['userid'];
        $username         = $_POST['username'];
        $password         = $_POST['pass'];
        $hashpassword     = sha1($password);
        $email            = $_POST['email'];
        $fname            = $_POST['fname'];
        $errors           = [];

        if (empty($username)){
          $errors[] = "<div class='alert alert-danger'>Username Can't Be<strong> Empty</strong></div>";
        }
        if (strlen($username) < 4){
          $errors[] = "<div class='alert alert-danger'>Username Can't Be Less Than<strong> 4 Characters</strong></div>";
        }
        if (strlen($username) > 20){
          $errors[] = "<div class='alert alert-danger'>Username Can't Be More Than<strong> 20 Characters</strong></div>";
        }
        if (empty($email)){
          $errors[] = "<div class='alert alert-danger'>Email Can't Be<strong> Empty</strong></div>";
        }
        if (empty($fname)){
          $errors[] = "<div class='alert alert-danger'>Full Name Can't Be<strong> Empty</strong></div>";
        }
        if (empty($errors)) {
          /*There is a logical error here you can't change the username for any user to the selected session because of the if statment (solved by recognise by id not by the user name)*/
          if (checkuser('username', 'users', $username) == false || $id == $_SESSION['id']){
            $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, Fullname = ? WHERE UserID = ?");
            $stmt->execute([$username, $email, $fname, $id]);
            $stmt->rowCount();
            if (!empty($_POST['pass'])){
              $stmt = $con->prepare("UPDATE users SET Password = ? WHERE UserID = ?");
              $stmt->execute([$hashpassword, $id]);
              $stmt->rowCount();
            }
            header("location: users.php?act=edit&userid=$id");
          }else {
            echo "<div class='container'>";
            echo "<div class='alert alert-danger text-center l-capital'>The Username You Entered is Already Exists</div>";
            echo "<a class='btn btn-success text-center' href='?act=edit&userid=$id'>Go Back</a>";
            echo "</div>";
          }
        }else {
          echo "<div class='container'>";
          foreach ($errors as $error) {
            echo $error;
          }
          echo "<a class='btn btn-success text-center' href='?act=edit&userid=$id'>Go Back</a>";
          echo "</div>";
          //header("location: ?act=edit&userid=$id");
        }
      }else {
        gohome("<strong>You Can't Brows This Page Directly</strong>");
      }
    }elseif ($act == 'insert'){
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<h2 class='text-center mb-5 mt-3'>Insert Errors</h2>";

        $username         = $_POST['username'];
        $password         = $_POST['pass'];
        $hashpassword     = sha1($password);
        $email            = $_POST['email'];
        $fname            = $_POST['fname'];
        $errors           = [];

        if (empty($username)){
          $errors[] = "<div class='alert alert-danger'>Username Can't Be<strong> Empty</strong></div>";
        }
        if (strlen($username) < 4){
          $errors[] = "<div class='alert alert-danger'>Username Can't Be Less Than<strong> 4 Characters</strong></div>";
        }
        if (strlen($username) > 20){
          $errors[] = "<div class='alert alert-danger'>Username Can't Be More Than<strong> 20 Characters</strong></div>";
        }
        if (empty($password)){
          $errors[] = "<div class='alert alert-danger'>Password Can't Be<strong> Empty</strong></div>";
        }
        if (empty($email)){
          $errors[] = "<div class='alert alert-danger'>Email Can't Be<strong> Empty</strong></div>";
        }
        if (empty($fname)){
          $errors[] = "<div class='alert alert-danger'>Full Name Can't Be<strong> Empty</strong></div>";
        }
        if (empty($errors)){
          if (checkuser('username', 'users', $username) == false){

            $stmt = $con->prepare("INSERT INTO users (Username, Password, Email, Fullname, `Date`, regstatus) VALUES(:user, :password, :email, :fullname, now(), 1)");
            $stmt->execute([
              'user'        => $username,
              'password'    => $hashpassword,
              'email'       => $email,
              'fullname'    => $fname
            ]);
            $stmt->rowCount();
            header("location: ?act=add");
          }else {
            echo "<div class='container'>";
            echo "<div class='alert alert-danger text-center'>The Username You Entered Is Already Exist</div>";
            echo "<a class='btn btn-success text-center' href='?act=add'>Go Back</a>";
            echo "</div>";
          }
        }else {
          echo "<div class='container'>";
          foreach ($errors as $error){
            echo $error;
          }
          echo "<a class='btn btn-success text-center' href='?act=add'>Go Back</a>";
          echo "</div>";
        }
      }else {
        gohome("<strong>You Can't Brows This Page Directly</strong>");
      }
    }elseif ($act == 'delete'){
      $theuser = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
      $stmt = $con->prepare("SELECT * FROM users WHERE userid = ?");
      $stmt->execute([$theuser]);
      if ($stmt->rowCount() > 0){
        $stmt = $con->prepare("DELETE FROM users WHERE userid = :zid");
        $stmt->bindParam(':zid' ,$theuser);
        $stmt->execute();
        header("location: users.php?act=manage");
      }else {
        gohome("There Is No Sush User");
      }
    }elseif ($act == 'activate'){
      $theuser = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
      $stmt = $con->prepare("SELECT * FROM users WHERE userid = ?");
      $stmt->execute([$theuser]);
      if ($stmt->rowCount() > 0){
        $stmt = $con->prepare("UPDATE users SET regstatus = 1 WHERE userid = :zid");
        $stmt->bindParam(':zid' ,$theuser);
        $stmt->execute();
        header("location: users.php?act=manage");
      }else {
        gohome("There Is No Sush User");
      }
    }
    include 'includes/templates/footer.html';
  }else {
    header("location: index.php");
    exit();
  }
ob_end_flush();?>
