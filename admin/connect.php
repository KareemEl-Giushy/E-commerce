<?php
  $server = "localhost";
  $user   = "root";
  $pass   = "";
  $options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  ];
  try {
    $con = new PDO("mysql:host=$server;dbname=shopy", $user, $pass, $options);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (PDOException $e) {
    echo "Faild to connect " . $e->getmessage();
  }
