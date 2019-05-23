<?php
  ob_start();
  $pagetitle = 'Home';
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php"; ?>
  <div class="container-fluid bg-white">
    <div class="slider-body">
      <div class="row">
        <div class="text-main-black col-6 text-center">
          <h2 class="p-5">iPhone X Max</h2>
          <p class='px-5 pb-5'>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          <div class="signin-btn text-center m-auto font-har-bold w-25">
            <a href="#" class="text-white"> See More</a>
          </div>
        </div>
        <div class="img col-6 text-center">
          <img class="w-50 px-3 pt-5" src="data\item-imgs\Apple-iPhoneX-SpaceGray-1-3x.jpg" alt="iphonex">
        </div>
      </div>
    </div>
    <div class="controlers text-center mb-3">
      <div class="bullet active"></div>
      <div class="bullet"></div>
      <div class="bullet"></div>
      <div class="bullet"></div>
    </div>
  </div>
  <div class="container">
    <div class="section-1 mt-5 bg-light">
      <h1 class="text-center text-uppercase mb-3 mt-3 font-har-black"><span class="text-main-color">New</span> arrivals</h1>
      <div class="text-center mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</div>
      <div class="row">
<?php if ( !empty( getgitems('items', 'WHERE approve = 1', 'udate', 'LIMIT 4') )): ?>
  <?php foreach (getgitems('items', 'WHERE approve = 1', 'udate', 'LIMIT 4') as $item): ?>
        <div class="main-contain col-12 col-sm-12 col-md-6 col-lg-3">
          <div class="card-item bg-white">
            <div class="face text-center">
              <img class='w-75 mb-2 p-4' src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $item[0], 'item-imgs'); ?>" alt="<?php echo $item[1]; ?>">
              <a href="item.php?itemid=<?php echo $item[0]; ?>"><h4 class='text-main-black font-har-bold mb-3'><?php echo $item[1]; ?></h4></a>
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
                <li><i class='far fa-heart'></i></li>
                <li><a href="item.php?itemid=<?php echo $item[0]; ?>"><i class='fa fa-shopping-cart text-main-color'></i></a></li>
                <li><i class='fa fa-sync'></i></li>
              </ul>
            </div>
          </div>
        </div>
  <?php endforeach; ?>
<?php endif; ?>
      </div>
    </div>
  </div>
  <?php
    include "includes/templates/footer.html";
    ob_end_flush(); ?>
