<?php
  ob_start();
  $pagetitle = 'show category';
  // $pagetitle = str_replace('-',' ',$_GET['pagename']);
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php";
  $tag = isset($_GET['name']) ? $_GET['name'] : 'cate';

  if ($tag == 'cate') {
    if ( !isset($_GET['pageid']) && empty($_GET['pageid']) ) {
      gohome("No Such a <strong>category</strong>");
      exit();
    }
    if ( !is_numeric($_GET['pageid']) ) {
      gohome("No Such a <strong>category</strong>");
      exit();
    }
    if (is_numeric($_GET['pageid'])) {
      if ( empty(opened_func("SELECT * FROM categories WHERE cid = " . $_GET['pageid'] )) ) {
        gohome("No Such a <strong>category</strong>");
        exit();
      }
    } ?>

  <div class="container">
    <!-- <h1 class="text-center l-capital mb-5 mt-3"><?php echo opened_func("SELECT cname FROM categories WHERE cid = " . $_GET['pageid'])[0][0]; ?></h1> -->
    <div class="row mt-5">
      <div class="widgets col-12 col-sm-12 col-md-12 col-lg-3">
        <form class="" action="" method="post">
          <aside class="">
            <div class="submiting text-center bg-white p-4 w-100 mb-3">
              <input type="submit" value="Search" class="bg-main-color btn btn-secondary border-0">
            </div>
<?php if ( !empty(getgitems('categories', 'WHERE NOT parent = 0 AND parent = ' . $_GET['pageid'], 'cid')) ): ?>
            <div class="sub-cates bg-white p-4 w-100 mb-3">
              <h5 class="text-main-color font-har-black mb-4">Sub Categories</h5>
              <hr class='bg-main-black'/>
              <ul class="list-group">
  <?php foreach ( getgitems('categories', 'WHERE NOT parent = 0 AND parent = ' . $_GET['pageid'], 'cid') as $sub_cate): ?>
    <li class="list-group-item"><a class="a-hover font-har-regular text-main-color" target='_blank' href="category.php?pageid=<?php echo $sub_cate['cID']; ?>&pagename=<?php echo $sub_cate['cname']; ?>"><?php echo $sub_cate['cname']; ?></a></li>
  <?php endforeach; ?>
              </ul>
            </div>
<?php endif; ?>
            <div class="price-filter bg-white p-4 w-100 mb-3">
              <h5 class="text-main-color font-har-black">Price Filter</h5>
                <div id='ranger' name="price" class="my-4"></div>
                <div class="form-group">
                  <span class='text-main-black font-har-semibd'>From</span><input class='d-inline mx-2 form-control p-1 w-25' name='from' type="text"><span class='text-main-black font-har-semibd'>To</span><input type="text" class='d-inline mx-2 form-control p-1 w-25' name='to'>
                </div>
                <div class='l-capital text-danger' style="opacity: 0;" id='price-ms'>* Must Be a Number</div>
            </div>
            <div class="brand bg-white p-4 w-100 mb-3">
              <h5 class="text-main-color font-har-black mb-4">Brands</h5>
              <label class="l-capital mb-4">Samsung
                <input type="checkbox" name="brands">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">Heawie
                <input type="checkbox" name="brands">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">Apple
                <input type="checkbox" name="brands">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">Xaime
                <input type="checkbox" name="brands">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">Blackbarry
                <input type="checkbox" name="brands">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">Honer
                <input type="checkbox" name="brands">
                <span class="checkmark"></span>
              </label>
            </div>
            <div class="size bg-white p-4 w-100 mb-3">
              <h5 class="text-main-color font-har-black mb-4">Size</h5>
              <label class="l-capital mb-4">Xm
                <input type="checkbox" name="sizes">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">sm
                <input type="checkbox" name="sizes">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">md
                <input type="checkbox" name="sizes">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">lg
                <input type="checkbox" name="sizes">
                <span class="checkmark"></span>
              </label>
              <label class="l-capital mb-4">xl
                <input type="checkbox" name="sizes">
                <span class="checkmark"></span>
              </label>
            </div>
          </aside>
        </form>
      </div>
      <div class="products col-12 col-sm-12 col-md-12 col-lg">
        <div class="row">

<?php
    if (!empty(getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC'))){

      // echo "<pre>";
      // print_r(getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC'));
      // echo "</pre>";

      foreach (getgitems('items', "WHERE cat_id = " . $_GET['pageid'] . " AND approve = 1", 'itemid', 'DESC', 'LIMIT 9') as $item): ?>
        <div class="main-contain col-12 col-sm-12 col-md-6 col-lg-4 mb-3">
          <div class="card-item bg-white">
            <div class="face text-center">
              <img class='w-75 mb-2 p-4' src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $item[0], 'item-imgs'); ?>" alt="<?php echo $item[1]; ?>">
              <h4 class='text-main-black font-har-bold mb-3 px-2'><?php echo $item[1]; ?></h4>
              <div class="text-main-color font-har-bold p-4"><?php echo $item[3]; ?></div>
            </div>
            <div class="back text-center">
              <img class='w-50 mb-2 p-4' src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $item[0], 'item-imgs'); ?>" alt="<?php echo $item[1]; ?>">
              <a href="item.php?itemid=<?php echo $item[0]; ?>"><h4 class='text-main-black font-har-bold px-3'><?php echo $item[1]; ?></h4></a>
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
                <li><a href="item.php?itemid=<?php echo $item[0]; ?>"><i class='fa fa-shopping-cart text-main-color'></i></a></li>
                <li><i class='fa fa-sync' title='reporting'></i></li>
              </ul>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
<?php
    }else {
      echo "<div class='alert alert-info l-capital text-center col-12'>This category is <strong>empty</strong></div>";
      echo "<div class='col text-center mt-3'><a class='btn btn-info col-12 col-sm-12 col-md-3' href='index.php'>Go Home?</a></div>";
    } ?>
        </div>
      </div>
    </div>
  </div>
<?php
  }
  if ($tag != 'cate'):
    if (!empty($tag)): ?>
    <div class="container">
      <h1 class="text-center l-capital mb-5 mt-3"><?php echo '#' . $tag; ?></h1>
      <div class="row">
<?php
        if (!empty(opened_func("SELECT * FROM items WHERE tags LIKE '%{$tag}%' AND approve = 1 ORDER BY itemid DESC"))):
          foreach (opened_func("SELECT * FROM items WHERE tags LIKE '%{$tag}%' AND approve = 1 ORDER BY itemid DESC") as $item): ?>
                <div class='col col-sm-12 col-md-4 col-lg-4'>
                  <div class='card mb-3'>
                    <div class='card-header'>
                      <h5 class='card-text text-center'><?php echo $item[3]; ?></h5>
                    </div>
                    <div class='card-text date-tag'><?php echo $item[4]; ?></div>
                    <img class='card-img-top img-fluid item-img' src='<?php getimg("SELECT `item-img` FROM items WHERE itemid = " . $item[0], 'item-imgs'); ?>' alt='<?php echo $item[1]; ?>'/>
                    <div class='card-body'>
                      <h6 class='card-title item-title'><?php echo $item[1]; ?></h6>
                      <p class='card-text item-desc'><?php echo $item[2]; ?></p>
                      <div class='card-footer'>
                      <a class='btn btn-primary d-block' href='item.php?itemid=<?php echo $item[0]; ?>'>View</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach;?>
            <?php else: ?>
              <div class='alert alert-info l-capital text-center col-12'>This category is <strong>empty</strong></div>
              <div class='col text-center mt-3'><a class='btn btn-info col-12 col-sm-12 col-md-3' href='index.php'>Go Home?</a></div>
            <?php endif; ?>
      </div>
    </div>
<?php
    else:
      gohome('there is no such <strong>tag</strong>');
      exit();
    endif;
  endif;
  include "includes/templates/footer.html";
  ob_end_flush(); ?>

<script src="layout/js/price-slider.js"></script>
