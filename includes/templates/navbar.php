<?php
  if (session_status() == PHP_SESSION_NONE){
    session_start();
  } ?>
<!-- Start Navbar -->
<div class="upper-bar px-5 d-none d-lg-block bg-white p-3">
  <div class="row">
    <div class="l-capital col pt-1">
      <span class="pl-1" href="#"><i class="fa fa-envelope text-main-color"></i> kemoo.64123@gmail.com</span>
      <span class="pl-1" href="#"><i class="fa fa-phone text-main-color"></i> (+20) 01144379723</span>
    </div>
    <div class="l-capital col part-2 pt-1 float-right">
      <a class="pl-3" href="#"><i class='fab fa-facebook text-primary'></i></a>
      <a class="pl-3" href="#"><i class='fab fa-twitter'></i></a>
      <a class="pl-3" href="#"><i class='fab fa-pinterest'></i></a>
      <a class="pl-3" href="#"><i class='fab fa-instagram text-danger'></i></a>
    </div>
  </div>
</div>
<div class="navey bg-white">
  <div class="">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="cates-card">
        <div class="menu-icon">
          <div class="slach"></div>
          <div class="slach"></div>
          <div class="slach"></div>
        </div>
        <div class="cates-card-body" style="display: none;">
          <div class="up-arrow"></div>
          <div class="list-group list-group-flush">

<?php
            foreach (getgitems('categories', 'WHERE visibility = 1 AND parent = 0', 'cid') as $cate) {
              echo "<a class='list-group-item text-main-black' href='category.php?pageid=" . $cate[0] . "&pagename=" . str_replace(" ", "-",$cate[1]) . "'>";
                echo "<i class='{$cate['icon']} p-2 text-main-color'></i>";
                echo $cate[1];
              echo "</a>";
            } ?>
          </div>
        </div>
      </div>
      <a class="navbar-brand col-lg-2 col-sm-2 col-6 mx-xl-0 pl-0 font-weight-bold text-secondary text-center" href="index.php">
        <img src="data/uploads/logo.png" alt="eCommerce">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline my-2 my-lg-0 col col-lg-9 pl-0">
          <input class="form-control mr-sm-2 col-lg-10 col-md-9 col-sm-9 col-12" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-secondary my-2 my-sm-0 col col-lg-1" type="submit"><i class='fa fa-search'></i></button>
        </form>
        <ul class="navbar-nav mr-auto">
          <div class="row">
            <?php if (isset($_SESSION['fnorname']) && isset($_SESSION['norid'])): ?>
              <li class="nav-item dropdown px-4 col-6 col-lg-9 px-lg-0">
                <a class="nav-link dropdown-toggle px-1 l-capital" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 1em;">
                  <?php echo explode(' ',$_SESSION['fnorname'])[0]; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <div class="up-arrow"></div>
                  <a class="dropdown-item" href="profile.php">Profile</a>
                <?php if (checkuserstatus($_SESSION['norid']) == true): ?>
                  <a class="dropdown-item" href="new_item.php">Add new item</a>
                <?php else: ?>
                  <a class="dropdown-item disabled" style="cursor: not-allowed" href="#">Add new item</a>
                <?php endif; ?>
                  <a class="dropdown-item" href="settings.php">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
              </li>
            <?php else: ?>
              <li class="nav-item dropdown px-4 col-6 col-lg-9 px-lg-0">
                <a class="nav-link dropdown-toggle px-1 text-main-black" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 1em;">
                  Your Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <div class="up-arrow"></div>
                  <div class="downdroping" href="#">New Customer ?</div>
                  <div class="signin-btn text-center m-3">
                    <a href="login.php?act=signup-form" class="text-white">Sign Up</a>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="downdroping text-center" href="#">Already Here <a href="login.php" class="text-main-color d-block d-sm-inline-block">login</a></div>
                </div>
              </li>
            <?php endif; ?>
              <li class="nav-item dropdown pl-0 col-6 col-lg-3">
                <div class="cart col pl-0">
                <a class="nav-link float-right" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class='fa fa-shopping-cart fa-2x p-1'></i>
                  <span class="text-center"><?php echo 0; ?></span>
                </a>
                <div class="clearfix"></div>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <div class="up-arrow"></div>
                  Not Yet
                  <!--<div class="downdroping" href="#">New Customer ?</div>
                  <div class="signin-btn text-center m-3">
                    <a href="login.php?act=signup-form" class="">Sign Up</a>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="downdroping text-center" href="#">Already Here <a href="login.php">login</a></div>-->
                </div>
              </div>
            </li>
          </div>
        </ul>
      </div>
    </nav>
  </div>
</div>
<!-- End Navbar -->
<!-- Start Content -->
