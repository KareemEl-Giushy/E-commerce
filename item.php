<?php
  ob_start();
  session_start();
  $pagetitle = '';
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php";

  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

  if ($itemid == 0) {
    gohome("there is no such an item to <strong>show</strong>.");
    exit();
  }
  // checking if the item is exists or not
  if (checkuser('itemid', 'items', $itemid) == true) {
    // the query (fetching the data)
    $stmt = $con->prepare("SELECT * FROM items WHERE itemid = ?");
    $stmt->execute([$itemid]);
    $iteminfo = $stmt->fetch();
  }else {
    gohome("there is no such an item to <strong>show</strong>.");
  }

  ?>
<?php echo $iteminfo[1]; ?>
<?php
  include "includes/templates/footer.html";
  ob_start(); ?>
