<?php
  function pageti(){
      global $pagetitle;
    if (isset($pagetitle)) {
      echo "eCommerce | " . $pagetitle;
    }else {
      echo 'Default';
    }
  }

  function gohome($errorma, $seconds = 2){
    echo "<div class='container'>";
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


// the opened function
function opened_func($thequery){
  global $con;
  $statement = $con->prepare("$thequery");
  $statement->execute();
  return $statement->fetchAll();
}
