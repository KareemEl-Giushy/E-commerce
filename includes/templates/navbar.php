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
        <ul class="navbar-nav mr-auto">
<?php
          foreach (getgitems('categories', 'WHERE visibility = 1', 'cid') as $cate) {
            echo "<li class='nav-item'>";
            echo "<a class='nav-link' href='category.php?pageid=" . $cate[0] . "&pagename=" . str_replace(" ", "-",$cate[1]) . "'>" . $cate[1] . "</a>";
            echo "</li>";
          } ?>
          <?php if (isset($_SESSION['fnorname']) && isset($_SESSION['norid'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $_SESSION['fnorname']; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="#">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
          <?php else: ?>
            <div class="signs">
              <li class="nav-item float-left">
                <a class="nav-link" href="login.php?act=signup-form" style="border: 3px solid #cdcdcdcd;">Sign UP</a>
              </li>
              <li class="nav-item float-left">
                <a class="nav-link" href="login.php">login</a>
              </li>
            </div>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </div>
</div>
<!-- End Navbar -->
<!-- Start Content -->
