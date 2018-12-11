<?php
  ob_start();
  session_start();
  $pagetitle = 'My Products';
  if (isset($_SESSION['norid']) && !empty($_SESSION['norid'])) {
    include "connect.php";
    include "includes/templates/header.php";
    include "includes/templates/navbar.php";
  }else {
    header('location: index.php');
    exit();
  } ?>

<h2 class="text-center mb-5 mt-3">My Products<sub><a class="h6 a l-capital" href="new_item.php" style="color: var(--primary)"><i class="fa fa-plus"></i> new</a></sub></h2>
<div class="container">
  <div class="row">
<?php
      foreach (getgitems('items', "WHERE member_id = " . $_SESSION['norid'] . " AND approve = 1", 'itemid', 'DESC') as $item) {
        echo "<div class='col col-sm-12 col-md-4 col-lg-4'>";
          echo "<div class='card'>";
            echo "<div class='card-header'>";
              echo "<h5 class='card-text text-center'>$item[3]</h5>";
            echo "</div>";
            echo "<div class='card-text date-tag'>" . $item[4] . "</div>";
            echo "<img class='card-img-top img-fluid' src='data/uploads/default.png' alt='$item[1]'/>";
            echo "<div class='card-body'>";
              echo "<h6 class='card-title item-title'>" . $item[1] . "</h6>";
              echo "<p class='card-text item-desc'>" . $item[2] . "</p>";
              echo "<div class='card-footer'>";
              echo "<a class='btn btn-primary d-block' href='item.php?itemid=$item[0]'>View</a>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      } ?>
  </div>
</div>

<?php
  include "includes/templates/footer.html";
  ob_end_flush(); ?>
