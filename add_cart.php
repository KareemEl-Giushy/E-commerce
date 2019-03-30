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
    $_SESSION['cart'][0] = ['hamada','soliman'];
    echo "<pre>";
    print_r($_SESSION);

  }else {
    header('location: index.php');
    exit();
  }

  ob_start();
