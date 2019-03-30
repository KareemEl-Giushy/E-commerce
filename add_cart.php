<?php
  ob_start();
  session_start();
  include 'connect.php';
  include 'includes/functions/func.php';

  // echo $_POST['itemidcart'];
  if (!filter_var($_POST['itemidcart'], FILTER_VALIDATE_INT)) {
    header('location: index.php');
    exit();
  }
  if (checkuser('itemID', 'items', 1)){

    $itemid = filter_var($_POST['itemidcart'], FILTER_SANITIZE_NUMBER_INT);

  }else {
    header('location: index.php');
    exit();
  }

  if ( isset($_SESSION['norid']) && !empty($_SESSION['norid']) ){
    $iteminfo = getgitems('items', "WHERE itemid = $itemid AND approve = 1", 'itemid')[0];
    // echo '<pre>';
    // print_r($iteminfo);
    // echo '</pre>';

    // adding the item into the Cart

    // preparing for adding a new item
    $_SESSION['cart'] = [];
    $countCart = count($_SESSION['cart']);
    // echo "<pre>";
    // print_r($_SESSION);
    // print_r($iteminfo);
    // echo "</pre>";
    $arr = [1,2,3,4,5];
    for ($i=0; $i < 5 ; $i++) {
      $arr2 = [6,7,8,9];
      $arr[] = $arr2;
    }
    // adding the item
    $_SESSION['cart'][] = $iteminfo;
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

  }else {
    header('location: index.php');
    exit();
  }

  ob_start();
