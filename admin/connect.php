<?php
  $server = "localhost";
  $user   = "root";
  $pass   = "";
  $option = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  ];
  try {
    $con = new PDO("mysql:host=$server;dbname=shop", $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (PDOException $e) {
    echo "Faild to connect " . $e->getmessage();
  }
