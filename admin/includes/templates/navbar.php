<div class="navey bg-light">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="index.php">eCommerce Site</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="categories.php">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="items.php">Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="users.php">Members</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="comments.php">Comments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Statistics</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Logs</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['fname']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

              <a class="dropdown-item l-capital" href="../index.php" target="_blank">Visit the shop</a>
              <a class="dropdown-item" href="users.php?act=edit&userid=<?php echo $_SESSION['id']; ?>">Edit Profile</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>
