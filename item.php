<?php
  ob_start();
  session_start();

  // opened_func("SELECT itemname FROM items WHERE itemid = $itemid")[0][0]
  $pagetitle = 'show item';
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php";
  // include "includes/functions/func.php";

  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

  if ($itemid == 0) {
    gohome("there is no such an item to <strong>show</strong>.");
    exit();
  }

  // checking if the item is exists or not
  if (checkuser('itemid', 'items', $itemid) == true && opened_func("SELECT approve FROM items WHERE itemID = $itemid")[0][0] == 1){
    // the query (fetching the data)
    $stmt = $con->prepare("SELECT items.*, categories.cname AS catename, users.Username FROM items INNER JOIN categories on categories.cID = items.Cat_ID INNER JOIN users on users.UserID = items.Member_ID WHERE items.itemID = ?");
    $stmt->execute([$itemid]);
    $iteminfo = $stmt->fetch();
    // echo "<pre>";
    // print_r($iteminfo);
    // echo "</pre>";

  }else {
    gohome("there is no such an item to <strong>show</strong>.");
    exit();
  }
  // print_r($iteminfo); ?>
<div class="container mt-5">
  <div class="row">
    <div class="photo col-12 col-sm-12 col-md-5 col-lg-5 border-right border-secondary p-3">
      <img class="img-thumbnail" src="<?php echo getimg("SELECT `item-img` FROM items WHERE itemid = " . $iteminfo[0], 'item-imgs'); ?>" alt="<?php echo $iteminfo[1]; ?>">
    </div>
    <div class="col">
      <h2 class="text-left p-2 h2 mb-3"><?php echo $iteminfo[1]; ?></h2>
      <div class="description">
        <h5 class="mb-3">Description :</h5>
        <p>- <?php echo $iteminfo[2]; ?></p>
      </div>
      <div class="footer">
        <ul class="list-group">
          <li class="l-capital list-group-item"><i class="fa fa-building fa-fw"></i> made in : <?php echo $iteminfo[5]; ?></li>
          <li class="l-capital list-group-item"><i class="fa fa-cog fa-fw"></i> Status : <?php echo $iteminfo[7]; ?></li>
          <li class="l-capital list-group-item"><i class="fa fa-calendar fa-fw"></i> date : <?php echo $iteminfo[4]; ?></li>
          <li class="l-capital list-group-item"><i class="fa fa-money fa-fw"></i> price : <?php echo str_replace("$", "", $iteminfo[3]); ?>$</li>
          <li class="l-capital list-group-item">
            <div class="row">
              <span class="col-6"><i class="fa fa-tags fa-fw"></i> Category : <a class="" href='Category.php?pageid=<?php echo $iteminfo[10]; ?>&pagename=<?php echo str_replace(" ", "-", $iteminfo[13]); ?>' target='_blank'><?php echo $iteminfo[13]; ?></a></span>
              |
              <span class="col"><i class="fa fa-user fa-fw"></i> publisher : <a class="" href='#' target='_blank'><?php echo $iteminfo[14]; ?></a></span>
            </div>
          </li>
          <?php if ( !empty( $iteminfo[12] ) ): ?>
            <li class="list-group-item"><i class="fa fa-tags fa-fw"></i> Tags: <?php
            $tags = explode(',', $iteminfo[12]);
            foreach($tags as $tag){
              $tag = strtolower( str_replace(' ', '', $tag) );
              echo "<a href='category.php?name={$tag}' target='_blank'>" . $tag . "</a> | ";
            } ?></li>
          <?php endif; ?>
        </ul>
        <button type="button" class="btn btn-primary mt-3 col-12 col-sm-12 col-md-6 float-right" style="font-weight: 500;">Add To My Chart</button>
      </div>
    </div>
  </div>
  <hr class="bg-secondary mt-5 mb-3">
  <!-- add comment section -->
<?php if (isset($_SESSION['norid']) && !empty($_SESSION['norid'])): ?>
  <div class="row">
    <div class="offset-md-3 col">
      <h3 class="l-capital p-2">add your comment :-</h3>
      <!-- bugy some how -->
      <form class="" action="item.php?itemid=<?php echo $itemid; ?>" method="POST">
        <textarea class="form-control" name='comment' required></textarea>
          <input class="btn btn-primary mt-2 col-12 col-md-3 float-right" type="submit" value="Add Comment">
      </form>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['comment'])) {
          $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
          $userid = $_SESSION['norid'];
          $comment_itemid = $iteminfo[0];

          if (empty($comment)) {
            $errors[] = "<div class='alert alert-danger l-capital'>You can't let the field <strong>empty</strong></div>";
          }else {
            $stmt = $con->prepare("INSERT INTO comments VALUES(NULL, :icomment, now(), 0, :itemid_c, :iuserid)");
            $stmt->execute([
              'icomment' => $comment,
              'itemid_c' => $comment_itemid,
              'iuserid' => $userid
            ]);
            $errors[] = "<div class='alert alert-success l-capital'>Your comment had been added <strong>successfully</strong></div>";
          }
        }else {
          $errors[] = "<div class='alert alert-danger l-capital'>the field <strong>isn't there<strong></div>";
        }
      } ?>
    </div>
    <div class="offset-md-3 col-12 col-md-9 mt-3">
<?php
    if (!empty($errors)) {
      echo "<div class='col'>";
      foreach ($errors as $error) {
        echo $error;
      }
      echo "</div>";
    } ?>
    </div>
  </div>
<?php else: ?>
  <div class="l-capital text-center">You can <a href='login.php'>login</a> or <a href='login.php?act=signup-form'>Signup</a> to add a comment</div>
<?php endif; ?>
  <hr class="bg-secondary mt-3 mb-3">
  <!-- the comments bar -->
  <div class="row">
<?php

        //get the comments and the users
        $stmt = $con->prepare("SELECT users.Username, comments.*, users.userid FROM comments INNER JOIN users ON comments.user_id = users.UserID WHERE comments.status = 1 AND comments.item_id = ? ORDER BY comments.comment_id DESC");
        $stmt->execute([$iteminfo[0]]);
        $item_comments = $stmt->fetchAll();

        // testing the result
        // echo "<pre class='col-12'>";
        // print_r($item_comments);
        // echo "</pre>";

        foreach ($item_comments as $item_comment) {
          echo "<div class='col-12 col-sm-12 col-md-3 pt-4 pb-3'>";
            echo "<div>";
              echo "<img class='img-thumbnail img-fluid rounded-circle user-img col-5 col-sm-5 col-md-10' src='" . getimg("SELECT `profile-img` FROM users WHERE userid = " . $item_comment[7]) . "' alt='$item_comment[0]'>";
            echo "</div>";
            echo "<div class='col'>" . "<a href='#'>" . $item_comment[0] . "</a>" . "</div>";
            echo "<div class='col'>" . $item_comment[3] . "</div>";
          echo "</div>";
          echo "<div class='col-12 col-sm-12 col-md-9 pt-5 pb-3'>";
            echo $item_comment[2] . "<br>";
          echo "</div>";
          echo "<hr class='bg-light col-12'>";
        } ?>
  </div>
</div>
<?php
  include "includes/templates/footer.html";
  ob_start(); ?>
