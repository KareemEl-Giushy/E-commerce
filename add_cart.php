<?php
  ob_start();
  session_start();
  if (!filter_var($_POST['itemidcart'], FILTER_VALIDATE_INT)) {
    header('location: index.php');
    exit();
  }
  if (checkuser('*', 'items', $_POST['itemidcart'])){

    $itemid = filter_var($_POST['itemidcart'], FILTER_SANITIZE_NUMBER_INT);

  }else {
    header('location: index.php');
    exit();
  }
  if (isset($_SESSION['norid']) && !empty($_SESSION['norid']){
    
  }else {
    header('location: item.php?itemid=' . $itemid);
    exit();
  }

  ob_start();
