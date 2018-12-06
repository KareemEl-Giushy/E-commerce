<?php
  ob_start();
  session_start();
  if (isset($_SESSION['user'])){
    $pagetitle = 'Categories';
    include 'connect.php';
    include "includes/templates/header.php";
    include "includes/templates/navbar.php";

    $act = isset( $_GET['act']) ? $_GET['act'] : "manage";
    if ($act == 'manage') {
      $stmt = $con->prepare("SELECT * FROM categories ORDER BY ordering ASC");
      $stmt->execute();
      $catsinfo = $stmt->fetchAll();
      echo "<h2 class='text-center mt-3 mb-3'>Manage Categories<span class='h6 cstyle'><sub>Classic</sub></span></h2>";
      echo "<div class='l-capital d-block text-center mb-3'>";
      echo "<a href='?act=add'><i class='fa fa-plus'></i> Add New category</a>";
      echo "</div>";
      echo "<div class='container'>";
      echo "<div class='row'>";
      foreach ($catsinfo as $cat){
        echo "<div class='col-12 col-sm-12 col-md-6 col-lg-4'>";
          echo "<div class='card text-center mb-3' style='min-height: 277px;'>";
            echo "<div class='card-header'>";
              echo "<div class='card-text l-capital'>" . $cat[1] . "</div>";
            echo "</div>";
            echo "<div class='card-body text-left'>";
              echo "<h2 class='text-center h5'>Description</h2>";
              echo "<div class='card-text l-capital desc-hover desc' style='cursor: pointer'
                title='See Description'>"; if( empty($cat[2]) ){ echo "there is no description."; }else{ echo $cat[2]; } echo"</div>";
            echo "</div>";?>

            <div class='card-footer'>
<?php
              echo"<div class='statuses flex-row mb-2'>";
              if ($cat[4] >= 1){
                echo "<span class='l-capital justify-content-center justify-content-md-left d-flex d-md-inline-flex pr-1 pb-1'><kbd class='bg-dark'><i class='fa fa-eye'></i> Visible</kbd></span>";
              }
              if ($cat[5] >= 1){
                echo "<span class='l-capital justify-content-center justify-content-md-left d-flex d-md-inline-flex pr-1 pb-1'><kbd class='bg-secondary'><i class='fa fa-comment'></i> Allow-comments</kbd></span>";
              }
              if ($cat[6] >= 1) {
                echo "<span class='l-capital justify-content-center justify-content-md-left d-flex d-md-inline-flex'><kbd class='bg-info'><i class='fa fa-credit-card'></i> Allow-ads</kbd></span>";
              }
              echo "</div>";?>

              <a class='confirm btn btn-danger mr-2' href='?act=delete&catid=<?php echo $cat[0]; ?>'><i class='fa fa-times'></i></a>
              <a class='btn btn-success ml-2 w-25' href='?act=edit&catid=<?php echo $cat[0]; ?>'><i class='fa fa-edit'></i></a>
            </div>
<?php
          echo "</div>";
        echo "</div>";
      }
      echo "</div>";
      echo "</div>";
    }elseif ($act == 'add'){?>
      <h2 class="text-center mt-3 mb-5">Add New Category</h2>
      <div class="container">
        <form class="form-group w-75 m-auto" action="?act=insert" method="post">
          <div class="form-row mb-3">
            <label class="col col-form-label">Category Name</label>
            <input type="text" name="name" class="form-control col-12 col-sm-12 col-md-9" placeholder="Write The Category Name" required autocomplete="on">
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Descrioption</label>
            <textarea type="text" name='descrioption' class="form-control col-12 col-sm-12 col-md-9" placeholder="Write Your Descrioption"></textarea>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Ordering</label>
            <input type="number" name='ordering' class="form-control col-12 col-sm-12 col-md-9" placeholder="The Oreder Of The Category">
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Visiblity</label>
            <div class="col-12 col-md-9">
              <div class="checky d-inline d-md-block">
                <label for="yes">Yes</label>
                <input type="radio" name='visiblitiy' value="1" checked class="" id='yes'>
              </div>
              <div class="checky d-inline">
                <label for="no">No</label>
                <input type="radio" name='visiblitiy' value="0" class="" id='no'>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label l-capital">allow-comments</label>
            <div class="col-12 col-md-9">
              <div class="checky d-inline d-md-block">
                <label for="yes">Yes</label>
                <input type="radio" name='comments' value="1" checked class="" id='yes'>
              </div>
              <div class="checky d-inline">
                <label for="no">No</label>
                <input type="radio" name='comments' value="0" class="" id='no'>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label l-capital">allow-ads</label>
            <div class="col-12 col-md-9">
              <div class="checky d-inline d-md-block">
                <label for="yes">Yes</label>
                <input type="radio" name='ads' value="1" checked class="" id='yes'>
              </div>
              <div class="checky d-inline">
                <label for="no">No</label>
                <input type="radio" name='ads' value="0" class="" id='no'>
              </div>
            </div>
          </div>
          <input type="submit" value="Add" class="btn btn-primary float-md-right float-sm-none col-12 col-md-3">
        </form>
      </div>
<?php
    }elseif ($act == 'insert'){
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $catname = $_POST['name'];
        $describe = $_POST['descrioption'];
        $order = $_POST['ordering'];
        $visiblity = $_POST['visiblitiy'];
        $allow_comments = $_POST['comments'];
        $allow_ads = $_POST['ads'];

        if (!empty($catname)) {
          $checku = checkuser('cname','categories', $catname);
          if ($checku == false) {
            $stmt = $con->prepare("INSERT INTO categories (cname, description, ordering, visibility, `allow-comments`, `allow-ads`) VALUES(:name, :des, :order, :visible, :comment, :ads)");
            $stmt->execute([
              'name' => $catname,
              'des' => $describe,
              'order' => $order,
              'visible' => $visiblity,
              'comment' => $allow_comments,
              'ads' => $allow_ads
            ]);
            $stmt->rowCount();
            header("location: ?act=add");
          }else {
            echo "<div class='container'>";
            echo "<h2 class='text-center mt-3 mb-5'>Add Error</h2>";
            echo "<div class='alert alert-danger text-center l-capital'>The category name You Entered is Already Exists</div>";
            echo "<a class='btn btn-success text-center' href='?act=add'>Go Back</a>";
            echo "</div>";
          }
        }else {
          echo "<div class='container'>";
          echo "<h2 class='text-center mt-3 mb-5'>Add Error</h2>";
          echo "<div class='alert alert-danger text-center l-capital'>you can't let the category name field empty</div>";
          echo "<a class='btn btn-success text-center' href='?act=add'>Go Back</a>";
          echo "</div>";
        }
      }else {
        gohome("You Can't brows this page directly");
      }
    }elseif ($act == 'edit'){

      $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 1;

      $isis = checkuser('cID', 'categories', $catid);
      if ($isis == true) {
        $stmt = $con->prepare("SELECT * FROM categories WHERE cID = ?");
        $stmt->execute([$catid]);
        $catrow = $stmt->fetch();?>
      <h2 class="text-center mt-3 mb-5">Edit Category</h2>
      <div class="container">
        <form class="form-group w-75 m-auto" action="?act=update&catid=<?php echo $catid; ?>" method="post">
          <input type="hidden" name="hiddenname" value="<?php echo $catrow[1]; ?>">
          <div class="form-row mb-3">
            <label class="col col-form-label">Category Name</label>
            <input type="text" name="name" value="<?php echo $catrow[1]; ?>" class="form-control col-12 col-sm-12 col-md-9" placeholder="Write The Category Name" required autocomplete="on">
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Description</label>
            <textarea type="text" name='descrioption' class="form-control col-12 col-sm-12 col-md-9" placeholder="Write Your Descrioption"><?php echo $catrow[2]; ?></textarea>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Ordering</label>
            <input type="number" name='ordering' value="<?php echo $catrow[3]; ?>" class="form-control col-12 col-sm-12 col-md-9" placeholder="The Oreder Of The Category">
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label">Visiblity</label>
            <div class="col-12 col-md-9">
              <div class="checky d-inline d-md-block">
                <label for="yes">Yes</label>
                <input type="radio" name='visiblitiy' value="1" class="" id='yes' <?php if($catrow[4] == 1){ echo "checked";} ?>>
              </div>
              <div class="checky d-inline">
                <label for="no">No</label>
                <input type="radio" name='visiblitiy' value="0" class="" id='no' <?php if($catrow[4] == 0){ echo "checked";} ?>>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label l-capital">allow-comments</label>
            <div class="col-12 col-md-9">
              <div class="checky d-inline d-md-block">
                <label for="yes">Yes</label>
                <input type="radio" name='comments' value="1" class="" id='yes' <?php if($catrow[5] == 1){ echo "checked";} ?>>
              </div>
              <div class="checky d-inline">
                <label for="no">No</label>
                <input type="radio" name='comments' value="0" class="" id='no' <?php if($catrow[5] == 0){ echo "checked";} ?>>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <label class="col col-form-label l-capital">allow-ads</label>
            <div class="col-12 col-md-9">
              <div class="checky d-inline d-md-block">
                <label for="yes">Yes</label>
                <input type="radio" name='ads' value="1" class="" id='yes' <?php if($catrow[6] == 1){ echo "checked";} ?>>
              </div>
              <div class="checky d-inline">
                <label for="no">No</label>
                <input type="radio" name='ads' value="0" class="" id='no' <?php if($catrow[6] == 0){ echo "checked";} ?>>
              </div>
            </div>
          </div>
          <input type="submit" value="Change" class="btn btn-primary float-md-right float-sm-none col-12 col-md-3">
        </form>
      </div>
<?php
      }else {
        gohome("there is no such an id");
      }
      // End
    }elseif ($act == 'update'){
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if( isset($_GET['catid']) && is_numeric($_GET['catid'])){
          if (checkuser('cid', 'categories', $_GET["catid"]) == true) {
            $cid = $_GET['catid'];
          }else {
            gohome('There Is no such id');
          }
        }else {
          gohome('There Is no such id');
        }

        $cathiddenname = $_REQUEST['hiddenname'];
        $catname = $_POST['name'];
        $describe = $_POST['descrioption'];
        $order = $_POST['ordering'];
        $visiblity = $_POST['visiblitiy'];
        $allow_comments = $_POST['comments'];
        $allow_ads = $_POST['ads'];

        if (!empty($catname)){
          $checku = checkuser('cname','categories', $catname);
          if ($checku == false || $catname == $cathiddenname) {
            $stmt = $con->prepare("UPDATE categories SET cname = :name, description = :des, ordering = :order, visibility = :visible, `allow-comments` = :comment, `allow-ads` = :ads WHERE cID = $cid");
            $stmt->execute([
              'name' => $catname,
              'des' => $describe,
              'order' => $order,
              'visible' => $visiblity,
              'comment' => $allow_comments,
              'ads' => $allow_ads
            ]);
            $stmt->rowCount();
            //header("location: ?act=edit&catid=$cid");
            header("location: ?act=manage");
          }else {
            echo "<div class='container'>";
            echo "<h2 class='text-center mt-3 mb-5'>Add Error</h2>";
            echo "<div class='alert alert-danger text-center l-capital'>The category name You Entered is Already Exists</div>";
            echo "<a class='btn btn-success text-center' href='?act=edit&catid=" . $cid . "'>Go Back</a>";
            echo "</div>";
          }
          }else {
          echo "<div class='container'>";
          echo "<h2 class='text-center mt-3 mb-5'>Add Error</h2>";
          echo "<div class='alert alert-danger text-center l-capital'>you can't let the category name field empty</div>";
          echo "<a class='btn btn-success text-center' href='?act=edit&catid=" . $cid . "'>Go Back</a>";
          echo "</div>";
        }
      }else{
        gohome("You Can't brows this page directly.");
      }
    }elseif ($act == 'delete'){
      $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? $_GET['catid'] : 0;
      $checky = checkuser('cID', 'categories', $catid);
      if ($checky == true){
        $stmt = $con->prepare("DELETE FROM categories WHERE cID = ?");
        $stmt->execute([$catid]);
        header("location: ?act=manage");
      }else {
        gohome("there isn't such a category.");
      }
    }
    include 'includes/templates/footer.html';
  }else {
    header("location: index.php");
    exit();
  }
  ob_end_flush();
