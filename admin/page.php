<?php
  ob_start();
  session_start();
  if (isset($_SESSION['user'])){
    include 'connect.php';
    include 'includes/templates/header.php';
    include 'includes/templates/navbar.php';

    $act = isset($_GET['act']) ? $_GET['act'] : 'manage';

    if ($act == 'manage'){
      // code...
    }elseif ($act == 'edit'){
      // code...
    }elseif ($act == 'add'){
      // code...
    }elseif ($act == 'update'){
      // code...
    }elseif ($act == 'insert'){
      // code...
    }elseif ($act == 'delete'){
      // code...
    }elseif ($act == 'approve'){
      // code...
    }

    include 'includes/templates/footer.html';
  }else {
    header("location: index.php");
    exit();
  }
