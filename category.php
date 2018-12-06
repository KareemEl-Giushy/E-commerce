<?php
  $pagetitle = str_replace('-',' ',$_GET['pagename']);
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php"; ?>

  <div class="container">
    <h1 class="text-center l-capital mb-5 mt-3"><?php echo str_replace('-',' ',$_GET['pagename']); ?></h1>
    <div class="row">

<?php
    if (!empty(getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC'))){
      foreach (getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC') as $item) {
        echo "<div class='col col-sm-12 col-md-4 col-lg-4'>";
          echo "<div class='card'>";
            echo "<div class='card-header'>";
              echo "<h5 class='card-text text-center'>$item[3]</h5>";
            echo "</div>";
            echo "<img class='card-img-top img-fluid' src='data/uploads/default.png' alt='$item[1]'/>";
            echo "<div class='card-body'>";
              echo "<h6 class='card-title item-title'>" . $item[1] . "</h6>";
              echo "<p class='card-text item-desc'>" . $item[2] . "</p>";
              echo "<div class='card-footer'>";
              echo "<a class='btn btn-primary d-block' href='#'>View</a>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      }
    }else {
      echo "cate is empty";
    } ?>
    </div>
  </div>

<?php  include "includes/templates/footer.html"; ?>
