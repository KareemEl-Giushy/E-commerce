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
<div class="bg-white py-5">
  <div class="container">
    <div class="row">
      <div class="photo col-12 col-sm-12 col-md-5 col-lg-5 border-right border-secondary p-3">
        <div class="row">
          <div class="col-2 col-lg-2 col-xl-1 bg-light p-0">
            <div class="imgs-strip">
              <ul>
<?php if (!empty( opened_func('SELECT `item-img` FROM items WHERE itemid = ' . $iteminfo[0]) )): ?>
  <?php
    // print_r (opened_func('SELECT `item-img` FROM items WHERE itemid = ' . $iteminfo[0]));
    // echo (opened_func('SELECT `item-img` FROM items WHERE itemid = ' . $iteminfo[0])[0][0]);
    $item_imgs = array_slice(explode(',', opened_func('SELECT `item-img` FROM items WHERE itemid = ' . $iteminfo[0])[0][0] ), 0, 3); ?>
  <?php foreach ($item_imgs as $img): ?>
                <li class=""><img class="w-100" src="data/item-imgs/<?php echo $img; ?>"/></li>
  <?php endforeach; ?>
<?php endif; ?>
                <div class="clearfix"></div>
              </ul>
            </div>
          </div>
          <div class="col">
            <img class="img-thumbnail" style="border: none;border-radius: 0;" id='item-photo' src="data/item-imgs/<?php echo $item_imgs[0]; ?>" alt="<?php echo $iteminfo[1]; ?>">
          </div>
        </div>
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
            <!-- <li class="l-capital list-group-item"><i class="fa fa-dollar-sign fa-fw"></i> price : <?php echo str_replace("$", "", $iteminfo[3]); ?>$</li> -->
            <li class="l-capital list-group-item">
              <div class="row">
                <span class="col-6"><i class="fa fa-tags fa-fw"></i> Category : <a class="text-main-color a-hover" href='Category.php?pageid=<?php echo $iteminfo['Cat_ID']; ?>&pagename=<?php echo str_replace(" ", "-", $iteminfo['catename']); ?>' target='_blank'><?php echo $iteminfo['catename']; ?></a></span>
                |
                <span class="col"><i class="fa fa-user fa-fw"></i> publisher : <a class="text-main-color a-hover" href='#' target='_blank'><?php echo $iteminfo['Username']; ?></a></span>
              </div>
            </li>
            <?php if ( !empty( $iteminfo[12] ) ): ?>
              <li class="list-group-item"><i class="fa fa-tags fa-fw"></i> Tags: <?php
              $tags = explode(',', $iteminfo[12]);
              foreach($tags as $tag){
                $tag = strtolower( str_replace(' ', '', $tag) );
                echo "<a class='text-main-color a-hover' href='category.php?name={$tag}' target='_blank'>" . $tag . "</a> | ";
              } ?></li>
            <?php endif; ?>
          </ul>
          <form class="" action="" method="post">
            <input type="hidden" name="itemidcart" value="<?php echo $itemid; ?>">
            <div class="row">
              <div class="text-center text-lg-left col-md-12 col-lg-5 my-3 text-md-center l-capital font-weight-bold py-0 px-3 font-har-black" style='font-size: 25px;'>
                price: <span><?php echo str_replace("$", "", $iteminfo[3]); ?>$</span>
              </div>
              <div class="col-md-12 col-lg my-3">
                <a href="" class="d-inline-block d-sm-inline-block float-md-none float-lg-right p-2 text-main-black buy-icons"><i class="fa fa-sync"></i></a>
                <a href="" class="d-inline-block float-right float-sm-right d-sm-inline-block float-md-none float-lg-right p-2 text-main-color buy-icons ml-2"><i class="far fa-heart"></i></a>
                <input type="submit" class="btn btn-primary col-12 col-sm-12 col-md-6 text-md-center float-lg-right bg-main-color btn-new-style p-2" style="font-weight: 500;" value="Add To My Cart">
                <div class='clearfix'></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if (!empty( getgitems('items', "WHERE cat_id = " . $iteminfo["Cat_ID"], 'itemid', 'LIMIT 4') )): ?>
<div class="container">
  <h1 class="text-center text-uppercase mb-3 mt-5 font-har-black"><span class="text-main-color">related</span> items</h1>
  <div class="text-center mb-5 font-har-regular">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</div>
  <div class="row">
    <?php foreach ( getgitems('items', "WHERE cat_id = " . $iteminfo["Cat_ID"] . " AND approve = 1", 'itemid', 'LIMIT 4') as $r_item): ?>
      <?php if (countitem('itemid', 'items', "WHERE cat_id = " . $iteminfo['Cat_ID'] . " AND approve = 1 LIMIT 4") == 4 ): ?>
        <div class="main-contain col-12 col-sm-12 col-md-6 col-lg-3 my-lg-5 mb-3">
      <?php else: ?>
        <div class="main-contain col-12 col-sm-12 col-md-6 col-lg-4 my-lg-5 mb-3">
      <?php endif; ?>
        <div class="card-item bg-white">
          <div class="face text-center">
            <img class='w-75 mb-2 p-4' src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $r_item[0], 'item-imgs'); ?>" alt="<?php echo $r_item[1]; ?>">
            <h4 class='text-main-black font-har-bold mb-3 px-2'><?php echo $r_item[1]; ?></h4>
            <div class="text-main-color font-har-bold p-4"><?php echo $r_item[3]; ?></div>
          </div>
          <div class="back text-center">
            <img class='w-50 mb-2 p-4' src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $r_item[0], 'item-imgs'); ?>" alt="<?php echo $r_item[1]; ?>">
            <a href="item.php?itemid=<?php echo $r_item[0]; ?>"><h4 class='text-main-black font-har-bold px-3'><?php echo $r_item[1]; ?></h4></a>
            <div class="colors">
              <div class="text-center text-main-black font-har-regular m-3">
                Colors :-
              </div>
              <div class='bg-primary'></div>
              <div class='bg-dark'></div>
              <div class='bg-danger'></div>
            </div>
            <ul class='icons-options text-center mt-3'>
              <li><i class='far fa-heart' title='Love'></i></li>
              <li><a href="item.php?itemid=<?php echo $r_item[0]; ?>"><i class='fa fa-shopping-cart text-main-color'></i></a></li>
              <li><i class='fa fa-sync' title='reporting'></i></li>
            </ul>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>
<div class="bg-white pt-5 mt-5">
<div class="container">
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
  <div class="row bg-white">
<?php

        //get the comments and the users
        $stmt = $con->prepare("SELECT users.Username, comments.*, users.userid FROM comments INNER JOIN users ON comments.user_id = users.UserID WHERE comments.item_id = ? ORDER BY comments.comment_id DESC");
        $stmt->execute([$iteminfo[0]]);
        $item_comments = $stmt->fetchAll();

        // testing the result
        // echo "<pre class='col-12'>";
        // print_r($item_comments);
        // echo "</pre>";

        foreach ($item_comments as $item_comment) {
          echo "<div class='col-4 col-sm-4 col-md-3 col-lg-2 pt-4 pb-3'>";
            echo "<div>";
              echo "<img class='img-thumbnail img-fluid border-0 user-img col' src='" . getimg("SELECT `profile-img` FROM users WHERE userid = " . $item_comment[7]) . "' alt='$item_comment[0]'>";
            echo "</div>";
            echo "<div class='col'>" . "<a href='#'>" . $item_comment[0] . "</a>" . "</div>";
            echo "<div class='col'>" . $item_comment[3] . "</div>";
          echo "</div>";
          echo "<div class='col pt-5 pb-3'>";
            echo $item_comment[2] . "<br>";
          echo "</div>";
          echo "<div class='col-12 p-0'><hr class='bg-light'></div>";
        } ?>
  </div>
</div>
</div>
<?php
  include "includes/templates/footer.html";
  ob_start(); ?>
