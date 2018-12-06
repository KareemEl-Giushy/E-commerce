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
        <div class="about-me menu mb-3">
          <ul class="list-group">
            <li class="list-group-item l-capital" style="cursor: default;">Username : <?php echo $userinfo[0][1]; ?></li>
            <li class="list-group-item l-capital" style="cursor: default;">Full Name : <?php echo $userinfo[0][4]; ?></li>
            <li class="list-group-item" style="cursor: default;">E-Mail : <?php echo $userinfo[0][3]; ?></li>
            <li class="list-group-item l-capital" style="cursor: default;">Join Date : <?php echo $userinfo[0][5]; ?></li>
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
                  <ul class="list-group list-group-flush menu">
  <?php
                    foreach (getgitems('items', "WHERE member_id = " . $_SESSION['norid'], 'itemid', 'DESC') as $product) {
                      echo "<li class='list-group-item'><a>- " . $product[1] . "</a></li>";
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
                <ul class="list-group list-group-flush menu">
                  <li class="list-group-item">Test</li>
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
