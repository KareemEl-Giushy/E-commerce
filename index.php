<?php
  ob_start();
  $pagetitle = 'Home';
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php"; ?>
  <div class="container-fluid bg-white">
    <div class="slider-body">
      <div class="row">
        <div class="text-slider col-12 col-md-6">
          <ul>
<?php if ( !empty( getgitems('items', 'WHERE approve = 1 AND slider = 1', 'price', 'LIMIT 4') ) ): ?>
  <?php $it = 0 ?>
  <?php foreach (getgitems('items', 'WHERE approve = 1 AND slider = 1', 'price', 'LIMIT 4') as $item): ?>
    <?php $it = $it + 1 ?>
            <li>
              <div class="text-main-black text-center">
                <h2 class="p-5 text-limit"><?php echo $item['itemName']; ?>...</h2>
                <p class='px-5 pb-5'>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="signin-btn text-center m-auto font-har-bold w-25">
                  <a href="item.php?id=<?php echo $item[0]; ?>" target="_blank" class="text-white"> See More</a>
                </div>
              </div>
            </li>
  <?php endforeach; ?>
<?php endif; ?>
          </ul>
          <div class="arrows-control">
            <i class='fa fa-angle-left fa-2x'></i>
            <i class='fa fa-angle-right fa-2x'></i>
          </div>
          <div class="controlers text-center my-5">
<?php if ( !empty( getgitems('items', 'WHERE approve = 1 AND slider = 1', 'price', 'LIMIT 4') ) ): ?>
  <?php for ($i = 0;$i < $it;$i++): ?>
            <i class="far fa-circle"></i>
  <?php endfor; ?>
<?php endif; ?>
          </div>
        </div>
        <div class="image-cont col-12 col-md-6 text-center">
          <ul>
<?php if ( !empty( getgitems('items', 'WHERE approve = 1 AND slider = 1', 'price', 'LIMIT 4') ) ): ?>
  <?php foreach (getgitems('items', 'WHERE approve = 1 AND slider = 1', 'price', 'LIMIT 4') as $item): ?>
            <li>
              <div class="img">
                <img class="w-50 px-3 pt-5" src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $item[0], 'item-imgs'); ?>" alt="<?php echo $item[1]; ?>">
              </div>
            </li>
  <?php endforeach; ?>
<?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="section-1 my-5 bg-light">
      <h1 class="text-center text-uppercase mb-3 mt-3 font-har-black"><span class="text-main-color">New</span> arrivals</h1>
      <div class="text-center mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</div>
      <div class="row">
<?php if ( !empty( getgitems('items', 'WHERE approve = 1', 'udate', 'LIMIT 4') )): ?>
  <?php foreach (getgitems('items', 'WHERE approve = 1', 'udate', 'LIMIT 4') as $item): ?>
        <div class="main-contain col-12 col-sm-12 col-md-6 col-lg-3 mb-3">
          <div class="card-item bg-white">
            <div class="face text-center">
              <img class='w-75 mb-2 p-4' src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $item[0], 'item-imgs'); ?>" alt="<?php echo $item[1]; ?>">
              <h4 class='text-main-black font-har-bold mb-3'><?php echo $item[1]; ?></h4>
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
      <div class="controlers text-center mt-4">
        <div class="m-auto" style="cursor: pointer; width: 50px;">
          <div class="bullet m-0" style="background-color: var(--main-color)"></div>
          <div class="bullet m-0" style="background-color: var(--main-color)"></div>
          <div class="bullet m-0" style="background-color: var(--main-color)"></div>
        </div>
      </div>
    </div>
    <div class="section-2 my-5 bg-light">
      <div class="row">
        <div class="col-12 col-md-8 my-3">
          <div class="offers bg-white">
            <div class="row">
              <div class="col-2">
                <img class='p-1 sales-img' src="data/uploads/sales-1.png" width="100px" height="100px" alt="Sales" srcset="data/uploads/sales-1.svg">
              </div>
              <div class="col-6 col-sm-7 py-3 ml-3">
                <div class="texty d-inline-block">
                  <h4>Full Summer Kit</h4>
                  <p class="d-none d-sm-inline-block">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
              </div>
              <div class="col-3 col-sm-2">
                <div class="buyy text-center py-4">
                  <i class='fa fa-shopping-cart text-main-color'></i>
                  <div class="text-main-color d-inline-block font-har-bold" style="font-size: 30px;">120$</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 my-3">
          <div class="service text-center bg-white">
            <div class="">
              <img class='img-fluid' src="data/uploads/aramex-logo.png" width="100px" height="100px" alt="Sales" srcset="data/uploads/aramex-logo.svg">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section-3 my-5 bg-light">
      <div class="best-s">
        <div class="text-center mb-5">
          <h1 class="text-main-color font-har-black">Best <span class='text-main-black'>Sales</span></h1>
          <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed</p>
        </div>
        <div class="row">
<?php if( !empty( getgitems('items', 'WHERE approve = 1 AND `best-sale` = 1', 'price', 'LIMIT 3') ) ): ?>
  <?php // print_r( getgitems('items', 'WHERE approve = 1 AND `best-sale` = 1', 'price', 'LIMIT 3') ); ?>
  <?php foreach (getgitems('items', 'WHERE approve = 1 AND `best-sale` = 1', 'price', 'LIMIT 3') as $item): ?>
          <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-5">
            <div class="best-card bg-white p-3">
              <div class="row">
                <div class="col-4">
                  <img class="p-0 col-12" src="<?php echo getimg('SELECT `item-img` FROM items WHERE itemid = ' . $item[0], 'item-imgs') ?>" alt="<?php echo $item[1]; ?>">
                </div>
                <div class="col-8 text-center">
                  <h5 class="d-inline-block col-12 mb-5 text-main-black font-har-bold text-limit"><?php echo $item[1]; ?></h5>
                  <div class="float-right text-main-color font-har-bold"><?php echo $item[3]; ?></div>
                  <div class=" text-main-color float-left font-har-bold"><a class='text-main-color a-hover' href='item.php?itemid=<?php echo $item[0]; ?>'><i class="fa fa-shopping-cart"></i> Add to cart</a></div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
  <?php endforeach; ?>
<?php endif; ?>
        </div>
      </div>
    </div>
    <div class="section-4 my-5 bg-light">
      <div class="News bg-white">
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="en-message">
              <h4 class="text-main-color d-sm-inline-block mx-3 mb-0 text-center">New User ?</h6>
              <p class='l-capital text-main-black d-sm-inline-block m-0 text-center'>Sign Up now to get every new deal</p>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="signing-b">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="m-3 text-center">
                    <div class="row">
                      <div class="col-3 pr-0">
                        <div class="iconic">
                          <i class="text-main-color far fa-envelope"></i>
                        </div>
                      </div>
                      <div class="col p-0 email-pa">
                        <input class='form-control' style="height: 44px;" type="email" name="email" placeholder="Your Email">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="signin-btn text-center m-3 font-har-bold">
                    <a class="text-white" href="">Sign Up</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
    include "includes/templates/footer.html";
    ob_end_flush(); ?>
