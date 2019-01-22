<?php
  ob_start();
  $pagetitle = 'show category';
  // $pagetitle = str_replace('-',' ',$_GET['pagename']);
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php";
  $tag = isset($_GET['name']) ? $_GET['name'] : 'cate';

  if ($tag == 'cate') {
    if ( !isset($_GET['pageid']) && empty($_GET['pageid']) ) {
      gohome("No Such a <strong>category</strong>");
      exit();
    }
    if ( !is_numeric($_GET['pageid']) ) {
      gohome("No Such a <strong>category</strong>");
      exit();
    }
    if (is_numeric($_GET['pageid'])) {
      if ( empty(opened_func("SELECT * FROM categories WHERE cid = " . $_GET['pageid'] )) ) {
        gohome("No Such a <strong>category</strong>");
        exit();
      }
    } ?>

  <div class="container">
    <h1 class="text-center l-capital mb-5 mt-3"><?php echo opened_func("SELECT cname FROM categories WHERE cid = " . $_GET['pageid'])[0][0]; ?></h1>
    <div class="row">

<?php
    if (!empty(getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC'))){

      // echo "<pre>";
      // print_r(getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC'));
      // echo "</pre>";

      foreach (getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC') as $item) {
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
    }else {
      echo "<div class='alert alert-info l-capital text-center col-12'>This category is <strong>empty</strong></div>";
      echo "<div class='col text-center mt-3'><a class='btn btn-info col-12 col-sm-12 col-md-3' href='index.php'>Go Home?</a></div>";
    } ?>

    </div>
  </div>
<?php
  }
  if ($tag != 'cate'):
    if (!empty($tag)): ?>
    <div class="container">
      <h1 class="text-center l-capital mb-5 mt-3"><?php echo '#' . $tag; ?></h1>
      <div class="row">
        <?php
            if (!empty(opened_func("SELECT * FROM items WHERE tags LIKE '%{$tag}%' AND approve = 1 ORDER BY itemid DESC"))){
              foreach (opened_func("SELECT * FROM items WHERE tags LIKE '%{$tag}%' AND approve = 1 ORDER BY itemid DESC") as $item) {
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
            }else {
              echo "<div class='alert alert-info l-capital text-center col-12'>This category is <strong>empty</strong></div>";
              echo "<div class='col text-center mt-3'><a class='btn btn-info col-12 col-sm-12 col-md-3' href='index.php'>Go Home?</a></div>";
            } ?>
      </div>
    </div>
<?php
    else:
      gohome('there is no such <strong>tag</strong>');
      exit();
    endif;
  endif;
  include "includes/templates/footer.html";
  ob_end_flush(); ?>
