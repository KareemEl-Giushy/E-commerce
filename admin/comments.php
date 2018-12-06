<?php
  ob_start();
  session_start();
  $pagetitle = 'Comments';
  if (isset($_SESSION['user'])){
    include 'connect.php';
    include 'includes/templates/header.php';
    include 'includes/templates/navbar.php';

    $act = isset($_GET['act']) ? $_GET['act'] : 'manage';

    if ($act == 'manage'){
      $stmt = $con->prepare("SELECT comments.*, items.itemName, users.Username FROM comments INNER JOIN items ON comments.item_id = items.itemID INNER JOIN users ON users.UserID = comments.user_id");
      $stmt->execute();
      $commentsinfo = $stmt->fetchAll();
      // echo "<pre>";
      // print_r($commentsinfo);
      // echo "</pre>";
    ?>
      <h2 class="text-center mb-5 mt-3">Manage</h2>
      <div class="container">
        <div class="table-responsive table-responsive-sm table-responsive-md table-striped table-hover">
          <table class="table table-bordered">
            <tr>
              <td>#ID</td>
              <td>Comment</td>
              <td>Date</td>
              <td>Item</td>
              <td>User</td>
              <td>Controls</td>
            </tr>
<?php
            foreach ($commentsinfo as $comment){
              echo "<tr>";
              echo "<td>" . $comment[0] . "</td>";
              echo "<td>" . $comment[1] . "</td>";
              echo "<td>" . $comment[2] . "</td>";
              echo "<td>" . $comment[6] . "</td>";
              echo "<td>" . $comment[7] . "</td>";
              echo "<td>
                <a class='btn btn-success mt-1 ml-1' href='comments.php?act=edit&commentid=" . $comment[0] . "'><i class='fa fa-edit'></i></a>
                <a class='confirm btn btn-danger m-1' href='comments.php?act=delete&commentid=" . $comment[0] . "'><i class='fa fa-trash'></i></a>";
                if ($comment[3] == 0) {
                  echo "<a class='btn btn-info m-1 ml-0' href='comments.php?act=approve&commentid=" . $comment[0] . "'><i class='fa fa-check-square'></i></a>";
                }
              echo"</td>";
              echo "</tr>";
            } ?>
          </table>
        </div>
        <a href="?act=add"><i class="fa fa-plus"></i> Add New comment</a>
      </div>
<?php
    }elseif ($act == 'edit'){
      $comment_id = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
      if (checkuser('comment_id', 'comments', $comment_id) == true){
        $stmt = $con->prepare("SELECT * FROM comments WHERE comment_id = ?");
        $stmt->execute([$comment_id]);
        $comment = $stmt->fetch();
      ?>
        <!-- Start html -->
        <h2 class='text-center mb-5 mt-3 l-capital'>edit A comment</h2>
        <div class="container">
          <div class="row">
            <form class="form-group w-75 m-auto" action="?act=update" method="post">
              <input type="hidden" name="commentid" value="<?php echo $comment[0]; ?>">
               <div class="form-row">
                 <label class="col col-form-label l-capital">Comment</label>
                 <textarea class="form-control col-12 col-sm-12 col-md-10 col-lg-10" name="edited" required><?php echo $comment[1]; ?></textarea>
               </div>
               <input type="submit" Value="Update Item" class="btn btn-primary float-sm-none float-md-right mt-2 col-md-3 col-12 col-sm-12">
            </form>
          </div>
        </div>
<?php
      }else {
        gohome("<strong>There Is No Such A comment</strong>");
        exit();
      }
    }elseif ($act == 'update'){
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h2 class='text-center mb-5 mt-3 l-capital'>Update errors</h2>";

        $comment_id = $_POST['commentid'];
        $comment = $_POST['edited'];

        $errors = [];
        if (empty($comment)){
          $errors[] = "<div class='alert alert-danger l-capital'>The Comment Can't Be<strong> Empty</strong></div>";
        }
        if (checkuser('comment_id', 'comments', $comment_id) == false){
          $errors[] = "<div class='alert alert-danger l-capital'>There is no such a comment to update</div>";
        }
        if (empty($errors)){
          $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE comment_id = ?");
          $stmt->execute([$comment, $comment_id]);
          header("location: ?act=edit&commentid=$comment_id");
        }else {
          echo "<div class='container'>";
          foreach ($errors as $error) {
            echo $error;
          }
          echo "<a class='btn btn-success text-center' href='?act=edit&commentid=$comment_id'>Go Back</a>";
          echo "</div>";
        }
      }else {
        gohome("<strong>You Can't Brows This Page Directly</strong>");
      }
    }elseif ($act == 'delete'){
      $comment_id = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? $_GET['commentid'] : 0;
      echo $comment_id;
      if (checkuser("comment_id", 'comments', $comment_id) == true){
        $stmt = $con->prepare("DELETE FROM comments WHERE comment_id = ?");
        $stmt->execute([$comment_id]);
        header("location: ?act=manage");
      }else {
        gohome("<strong>There is no such a comment</strong>");
      }
    }elseif ($act == 'approve'){
      $comment_id = isset($_GET['commentid']) ? intval($_GET['commentid']) : 0;
      if (checkuser('comment_id', 'comments', $comment_id) == true){
        $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE comment_id = ?");
        $stmt->execute([$comment_id]);
        header("location: ?act=manage");
      }else {
        gohome("<strong>There Is No Such A comment</strong>");
      }
    }

    include 'includes/templates/footer.html';
  }else {
    header("location: index.php");
    exit();
  }
ob_end_flush();
