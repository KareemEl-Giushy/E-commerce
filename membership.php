<?php
  ob_start();
  $pagetitle = 'Home';
  include "connect.php";
  include "includes/templates/header.php";
  include "includes/templates/navbar.php"; ?>
  <div class="container">
    <h2 class="text-center mt-4">Member Ships</h2>
    <div class="row mt-5">
      <div class="col-12 col-sm-12 col-md-12 col-lg-4">
        <div class="stage mb-3">
          <h2 class="l-capital text-center">Free</h2>
          <hr class="bg-light"/>
          <div class="price text-center">
            <span>Free</span>
          </div>
          <div class="stage-body mt-4">
            <ul class="list-group">
              <li class='list-group-item l-capital'>access <i class="fa fa-check fa-fw float-right"></i></li>
              <li class='list-group-item l-capital'>Ads <i class='fa fa-check fa-fw float-right'></i></li>
              <li class='list-group-item l-capital'>services <i class='fa fa-check float-right'></i></li>
            </ul>
          </div>
          <div class="l-capital text-center mt-3"><span>Your are already on it</span></div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-4">
        <div class="stage">
          <h2 class="l-capital text-center">silver</h2>
          <hr class="bg-light"/>
          <div class="price text-center">
            <span>50$/Month</span>
          </div>
          <div class="stage-body mt-4">
            <ul class="list-group s">
              <li class='list-group-item l-capital'>access <i class="fa fa-check fa-fw float-right"></i></li>
              <li class='list-group-item l-capital'>no-Ads <i class='fa fa-ban fa-fw float-right'></i></li>
              <li class='list-group-item l-capital'>services <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital' title="more services">New services <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital'>24/hour support <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital' title="good support">silver support <i class='fa fa-check float-right'></i></li>
            </ul>
          </div>
          <div class="text-center mt-3"><button class="l-capital">Choose this plan</button></div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-4">
        <div class="stage">
          <h2 class="l-capital text-center">Golden</h2>
          <hr class="bg-light"/>
          <div class="price text-center">
            <span>75$/Month</span>
          </div>
          <div class="stage-body mt-4">
            <ul class="list-group g">
              <li class='list-group-item l-capital'>access <i class="fa fa-check fa-fw float-right"></i></li>
              <li class='list-group-item l-capital'>no-Ads <i class='fa fa-ban fa-fw float-right'></i></li>
              <li class='list-group-item l-capital'>services <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital' title="more services">New services <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital'>24/hour support <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital' title="good support">silver support <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital' title="perfect support and help">golden support <i class='fa fa-check float-right'></i></li>
              <li class='list-group-item l-capital' title="better marketing to your productes to reach more customers">more marketing <i class='fa fa-check float-right'></i></li>
            </ul>
          </div>
          <div class="text-center mt-3"><button class="l-capital gold">Choose this plan</button></div>
        </div>
      </div>
    </div>
  </div>
<?php
  include "includes/templates/footer.html";
  ob_end_flush(); ?>
