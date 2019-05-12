<?php
  if (session_status() == PHP_SESSION_NONE){
    session_start();
  } ?>
<!-- Start Navbar -->
<div class="navey bg-light">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="index.php">eCommerce Site</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit"><i class='fa fa-search'></i></button>
        </form>
        <ul class="navbar-nav mr-auto">
<?php
          /*foreach (getgitems('categories', 'WHERE visibility = 1 AND parent = 0', 'cid') as $cate) {
            echo "<li class='nav-item'>";
            echo "<a class='nav-link' href='category.php?pageid=" . $cate[0] . "&pagename=" . str_replace(" ", "-",$cate[1]) . "'>" . $cate[1] . "</a>";
            echo "</li>";
          } */?>
          <?php if (isset($_SESSION['fnorname']) && isset($_SESSION['norid'])): ?>
            <li class="nav-item dropdown">
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
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Your Account
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="downdroping" href="#">New Customer ?</div>
                <div class="signin-btn text-center m-3">
                  <a href="login.php?act=signup-form" class="">Sign In</a>
                </div>
                <div class="dropdown-divider"></div>
                <div class="downdroping text-center" href="#">Already Here <a href="login.php">Sign in</a></div>
              </div>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </div>
</div>
<!-- End Navbar -->
<!-- Start Content -->
