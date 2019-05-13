<?php
  if (session_status() == PHP_SESSION_NONE){
    session_start();
  } ?>
<!-- Start Navbar -->
<div class="navey bg-light">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="menu-icon">
        <div class="slach"></div>
        <div class="slach"></div>
        <div class="slach"></div>
      </div>
      <a class="navbar-brand col-lg-2 col-sm-2 col-6 mx-xl-0 pl-0" href="index.php">
        eCommerce Site
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline my-2 my-lg-0 col col-lg-9 pl-0">
          <input class="form-control mr-sm-2 col-lg-10 col-md-9 col-sm-9 col-12" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-primary my-2 my-sm-0 col col-lg-1" type="submit"><i class='fa fa-search'></i></button>
        </form>
        <ul class="navbar-nav mr-auto">
          <div class="row">

<?php
            /*foreach (getgitems('categories', 'WHERE visibility = 1 AND parent = 0', 'cid') as $cate) {
              echo "<li class='nav-item'>";
              echo "<a class='nav-link' href='category.php?pageid=" . $cate[0] . "&pagename=" . str_replace(" ", "-",$cate[1]) . "'>" . $cate[1] . "</a>";
              echo "</li>";
            } */?>
            <?php if (isset($_SESSION['fnorname']) && isset($_SESSION['norid'])): ?>
              <li class="nav-item dropdown pl-0">
                <a class="nav-link dropdown-toggle l-capital" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $_SESSION['fnorname']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                <a class="nav-link dropdown-toggle px-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 1em;">
                  Your Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <div class="up-arrow"></div>
                  <div class="downdroping" href="#">New Customer ?</div>
                  <div class="signin-btn text-center m-3">
                    <a href="login.php?act=signup-form" class="">Sign Up</a>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="downdroping text-center" href="#">Already Here <a href="login.php">login</a></div>
                </div>
              </li>
            <?php endif; ?>
              <li class="nav-item dropdown pl-0 col-6 col-lg-3">
                <div class="cart col pl-0">
                <a class="nav-link float-right" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class='fa fa-shopping-cart fa-2x p-1 text-primary'></i>
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
