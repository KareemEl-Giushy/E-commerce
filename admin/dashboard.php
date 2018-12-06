<?php
  ob_start();
  session_start();
  if (isset($_SESSION['user'])){
    $pagetitle = "Dashboard";
    include 'connect.php';
    include "includes/templates/header.php";
    include "includes/templates/navbar.php";
  }else {
    header("location: index.php");
    exit();
  }
  $userscount = countitem('userid','users');
?>
<h2 class="text-center mt-3 mb-5">Dashboard</h2>
<div class="container">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
      <div class="card mb-5 border-0">
        <div class="card-header bg-transparent">
          <h5 class="text-center">Total Members</h5>
        </div>
        <div class="card-body">
          <a class="link" href="users.php"><h2 class="card-text text-center"><?php echo $userscount; ?></h2></a>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
      <div class="card mb-5 border-0">
        <div class="card-header bg-transparent">
          <h5 class="text-center">Pending Members</h5>
        </div>
        <div class="card-body bg-transparent">
          <a class='link' href='users.php?page=pending'><h2 class="card-text text-center"><?php echo countitem("userid", "users", "WHERE regstatus = 0");?></h2></a>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
      <div class="card mb-5 border-0">
        <div class="card-header bg-transparent">
          <h5 class="text-center">Total Items</h5>
        </div>
        <div class="card-body">
          <a class='link' href="items.php"><h2 class="card-text text-center"><?php echo countitem('*', 'items'); ?></h2></a>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
      <div class="card mb-5 border-0">
        <div class="card-header bg-transparent">
          <h5 class="text-center">Total Comments</h5>
        </div>
        <div class="card-body">
          <a class="link" href="comments.php"><h2 class="card-text text-center"><?php echo countitem('*', 'comments'); ?></h2></a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container mt-5">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-6 mb-3">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-users"></i> Latest Registerd Users
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
          <?php
           $usersrow = lastrec('*', 'users', 'userid');
           foreach ($usersrow as $user){
            echo "<li class='list-group-item l-capital'>" . $user[1] . " <a class='float-right' href='users.php?act=edit&userid=" . $user[0] . "'><i class='fa fa-edit' title='Edit'></i></a>";
            if ($user['Regstatus'] == 0) {
              echo "<a class='ml-2' href='users.php?act=activate&userid=" . $user[0] . "'><i class='fa fa-check-square' title='Activate'></i></a>";
            }
            echo "</li>";
           }?>
         </ul>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 mb-3">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-tags"></i> Latest Items
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
          <?php
           $itemsrow = lastrec('*', 'items', 'itemid');
           foreach ($itemsrow as $item){
            echo "<li class='list-group-item l-capital'>" . $item[1] . " <a class='float-right' href='items.php?act=edit&userid=" . $item[0] . "'><i class='fa fa-edit' title='Edit'></i></a>";
            if ($item[8] == 0) {
              echo "<a class='ml-2' href='items.php?act=approve&itemid=" . $item[0] . "'><i class='fa fa-check-square' title='Activate'></i></a>";
            }
            echo "</li>";
           }?>
         </ul>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-comments"></i> Latest Comments
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <?php
             $commentsrow = lastrec('*', 'comments', 'comment_id');
             // echo "<pre>";
             // print_r($commentsrow);
             // echo "</pre>";
             foreach ($commentsrow as $comment){
              echo "<li class='list-group-item l-capital'>" . $comment[1] . " <a class='float-right' href='comments.php?act=edit&commentid=" . $comment[0] . "'><i class='fa fa-edit' title='Edit'></i></a>";
              if ($comment[3] == 0) {
                echo "<a class='ml-2' href='comments.php?act=approve&commentid=" . $comment[0] . "'><i class='fa fa-check-square' title='Activate'></i></a>";
              }
              echo "</li>";
             }?>
         </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  include "includes/templates/footer.html";
  ob_end_flush();?>
