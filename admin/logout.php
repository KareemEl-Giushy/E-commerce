<?php
  session_start();
  session_unset();
  session_Destroy();
  header('location: index.php');
  exit();
