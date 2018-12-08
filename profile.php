<?php
  ob_start();
  session_start();
  $pagetitle = 'Profile';

  if (isset($_SESSION['norid']) && !empty($_SESSION['norid'])){

    include 'connect.php';
    include 'includes/templates/header.php';
    include 'includes/templates/navbar.php';

    $userinfo = getgitems('users', "WHERE userid = " . $_SESSION['norid'], 'userid');
    // echo "<pre>";
    // print_r($userinfo);
    // echo "</pre>";

  }else {
    header("location: login.php");
    exit();
  } ?>
  <div class="container">
  <?php if (checkuserstatus($_SESSION['norid']) == false): ?>
    <div class="alert alert-warning l-capital"><i class="fa fa-exclamation-triangle"></i> Your account is't activated yet. It will be activated soon.</div>
  <?php endif; ?>
  <div class="row">
      <div class="col-12 col-sm-12 col-md-5 col-lg-3">
        <div class="d-flex d-sm-flex d-md-inline justify-content-center">
          <div class="profile-img col-12 col-sm-6 col-md-12 col-lg-12 mb-3 border p-2">
            <a href="profile.php">
              <img class="img-fluid img-thumbnail p-0" src="data/uploads/default.png" alt="<?php echo $_SESSION['noruser']; ?>" title="<?php echo ucwords($_SESSION['fnorname']); ?>">
            </a>
          </div>
        </div>
        <div class="menu col-12 p-0">
          <ul class="list-group">
            <li class="list-group-item"><a href="#"><i class="fa fa-shopping-cart"></i> My Orders</a></li>
            <li class="list-group-item <?php if(checkuserstatus($_SESSION['norid']) == false){echo "disabled";} ?>"><a <?php if(checkuserstatus($_SESSION['norid']) == true){echo "href='#'";} ?> ><i class="fa fa-tags"></i> My Products</a></li>
            <li class="list-group-item"><a href="#"><i class="fa fa-cog"></i> Account Settings</a></li>
            <li class="list-group-item"><a href="#"><i class="fa fa-user"></i> Memberships</a></li>
          </ul>
        </div>
      </div>
      <div class="col">
        <h2 class="text-center mb-5 mt-3">My Profile</h2>
        <div class="about-me mb-3">
          <ul class="list-group">
            <li class="list-group-item pl-3 l-capital"><i class="fa fa-unlock-alt fa-fw"></i> Username : <?php echo $userinfo[0][1]; ?></li>
            <li class="list-group-item pl-3 l-capital"><i class="fa fa-user fa-fw"></i> Full Name : <?php echo $userinfo[0][4]; ?></li>
            <li class="list-group-item pl-3"><i class="fa fa-envelope fa-fw"></i> E-Mail : <?php echo $userinfo[0][3]; ?></li>
            <li class="list-group-item pl-3 l-capital"><i class="fa fa-calendar fa-fw"></i> Join Date : <?php echo $userinfo[0][5]; ?></li>
          </ul>
        </div>
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-6 p-1">
            <div class="card">
              <div class="card-header">
                <h6 class="card-text"><i class="fa fa-shopping-cart"></i> My Last Orders</h6>
              </div>
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item l-capital">test</li>
                </ul>
              </div>
            </div>
          </div>
          <?php if (checkuserstatus($_SESSION['norid']) == true): ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 p-1">
              <div class="card">
                <div class="card-header">
                  <h6 class="card-text"><i class="fa fa-tags"></i> My Products</h6>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush <?php if( !empty(getgitems('items', "WHERE member_id = " . $_SESSION['norid'], 'itemid', 'DESC')) ){echo "menu";} ?>">
  <?php
                    if (!empty( getgitems('items', "WHERE member_id = " . $_SESSION['norid'], 'itemid', 'DESC') )) {
                      foreach (getgitems('items', "WHERE member_id = " . $_SESSION['norid'], 'itemid', 'DESC') as $product) {
                        echo "<li class='list-group-item'><a href='item.php?itemid=$product[0]'>- " . $product[1] . "</a></li>";
                      }
                    }else {
                      echo "<li class='list-group-item l-capital'>- You Don't Have any products. <a href='new_item.php' target='_blank'><i class='fa fa-plus fa-xs'></i> add a item</a></li>";
                    } ?>
                  </ul>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <div class="col-12 col-sm-12 col-md-12 col-lg-6 p-1">
            <div class="card">
              <div class="card-header">
                <h6 class="card-text"><i class="fa fa-comments"></i> The Comments</h6>
              </div>
              <div class="card-body">
                <ul class="list-group list-group-flush <?php if( !empty(getgitems('comments', "WHERE user_id = " . $_SESSION['norid'], 'comment_id', 'DESC')) ){echo "menu";} ?>">
<?php
                  if (!empty(getgitems('comments', "WHERE user_id = " . $_SESSION['norid'], 'comment_id', 'DESC'))){
                    foreach (getgitems('comments', "WHERE user_id = " . $_SESSION['norid'], 'comment_id', 'DESC') as $comment) {
                      echo "<li class='list-group-item'><a>- " . $comment[1] . "</a></li>";
                    }
                  }else {
                    echo "<li class='list-group-item l-capital'>- you don't have any comments yet.</li>";
                  } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  include 'includes/templates/footer.html';
  ob_end_flush(); ?>
