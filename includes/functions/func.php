<?php
  // error reporting
  ini_set('display_errors', 'on');
  error_reporting(E_ALL);
  
  function pageti(){
      global $pagetitle;
    if (isset($pagetitle)) {
      echo "eCommerce | " . $pagetitle;
    }else {
      echo 'Default';
    }
  }

  function gohome($errorma, $seconds = 2){
    echo "<div class='container mt-5'>";
    echo "<div class='alert alert-danger text-center l-capital'>" . $errorma . "</div>";
    echo "<div class='alert alert-info text-center'>You Will Redirect To The Dashboard After " . $seconds . "s</div>";
    header("refresh:$seconds;url=index.php");
    exit();
  }

  function checkuser($select, $table, $val){
    global $con;
    $statement = $con->prepare("SELECT $select FROM $table WHERE $select = ?");
    $statement->execute([$val]);
    $rowcount = $statement->rowCount();

    if ($rowcount > 0){
      return true;
    }else {
      return false;
    }
  }


function countitem($item, $table, $query = ""){
  global $con;
  $statement = $con->prepare("SELECT COUNT($item) FROM $table $query");
  $statement->execute();
  return $statement->fetchColumn();
}


function lastrec($col, $table, $by){
  global $con;
  $statement = $con->prepare("SELECT $col FROM $table ORDER BY $by DESC LIMIT 5");
  $statement->execute();
  return $recrow = $statement->fetchAll();
}


function getgitems($table, $condition, $order, $query = ''){
  global $con;
  $statement = $con->prepare("SELECT * FROM $table $condition ORDER BY $order $query");
  $statement->execute();
  return $statement->fetchAll();
}


function checkuserstatus($userid=''){
  global $con;
  $statement = $con->prepare("SELECT * FROM users WHERE userid = ? AND regstatus = 1");
  $statement->execute([$userid]);
  if ($statement->rowCount() > 0){
    return true;
  }else {
    return false;
  }
}


// the opened function
function opened_func($thequery){
  global $con;
  $statement = $con->prepare("$thequery");
  $statement->execute();
  return $statement->fetchAll();
}


// display imgs function
function getimg($thequery, $file = 'profile-imgs'){
  if (empty( opened_func($thequery)[0][0] )){
    return "data/default.png";
  }else {
    if (file_exists("data/$file/" . opened_func($thequery)[0][0])) {
      return "data/$file/" . opened_func($thequery)[0][0];
    }else {
      return "data/default.png";
    }
  }
}
