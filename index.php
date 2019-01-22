<?php
  ob_start();
  $pagetitle = 'Home';
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php"; ?>
  <div class="container">
    <h1 class="text-center l-capital mb-5 mt-3">Home</h1>
    <div class="row">
<?php
  if ( !empty( getgitems('items', "WHERE approve = 1", 'itemid', 'DESC') ) ){
    foreach (getgitems('items', "WHERE approve = 1", 'itemid', 'DESC') as $item) {
      echo "<div class='col col-sm-12 col-md-4 col-lg-4'>";
        echo "<div class='card mb-3'>";
          echo "<div class='card-header'>";
            echo "<h5 class='card-text text-center'>$item[3]</h5>";
          echo "</div>";
          echo "<div class='card-text date-tag'>" . $item[4] . "</div>";
          echo "<img class='card-img-top img-fluid item-img' src='" . getimg("SELECT `item-img` FROM items WHERE itemid = " . $item[0], 'item-imgs') . "' alt='$item[1]'/>";
          echo "<div class='card-body'>";
            echo "<h6 class='card-title item-title'>" . $item[1] . "</h6>";
            echo "<p class='card-text item-desc'>" . $item[2] . "</p>";
            echo "<div class='card-footer'>";
            echo "<a class='btn btn-primary d-block' href='item.php?itemid=$item[0]'>View</a>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
    }
  } ?>
    </div>
  </div>
  <?php
    include "includes/templates/footer.html";
    ob_end_flush(); ?>
