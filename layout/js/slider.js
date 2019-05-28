$(document).ready(function (){

//--- All variabels ----
//--- Items vars ----
  var ulItems = $(".text-slider ul");
  var item = $(".text-slider ul li");
  var itemWidth = item.innerWidth();
//--- Icons ---
  var controls = $(".controlers");
  var bullet = controls.find('i');
//-- controling vars ---
  var controlA = $(".arrows-control");
  var leftArrow = $(".arrows-control i:first-of-type");
  var rightArrow = $(".arrows-control i:last-of-type");
//-- Global Vars ----
  var sliderTime = 600;
  var sliderDelay = 3000;
  var clicked = true;
  var autoPlay;

//-- adding active class dynamic ----
item.first().addClass('active');
bullet.first().addClass('active');
//-- Global Funcs ---

  /*
  ** Running the Slider
  ** By: Kareem
  ** Using: Increasing the left margin of the ul that contains the items
  */
  function runSlider (left = false){
    if (left === false) {

      if (clicked === true) {
        clicked = false;

        if ($('.text-slider ul li.active').is(':last-of-type')) {
          $('.text-slider ul li.active').removeClass('active');
          $('.text-slider ul li').first().addClass('active');

          ulItems.animate({
            marginLeft: 0
          },function (){
            clicked = true;
          });
        }else {

          ulItems.animate({
            marginLeft: -itemWidth * ($('.text-slider ul li.active').index() + 1)

          }, sliderTime, function (){
            clicked = true;
          });

          $('.text-slider ul li.active').removeClass('active').next().addClass('active');
        }
      }

    }else {
      // not Working
      if (clicked === true) {
        clicked = false;

        if ($('.text-slider ul li.active').is(':first-of-type')) {
          // $('.text-slider ul li.active').removeClass('active');
          $('.text-slider ul li').removeClass('active');
          $('.text-slider ul li').last().addClass('active');

          ulItems.animate({
            marginLeft: 0
          },function (){
            clicked = true;
          });
        }else {

          ulItems.animate({
            marginLeft: itemWidth * ($('.text-slider ul li.active').index() + 1)

          }, sliderTime, function (){
            clicked = true;
          });

          $('.text-slider ul li.active').removeClass('active').next().addClass('active');
        }
      }

    console.log('run');
    }
  }

  /*
  ** add the active class to the bullets (the circles)
  ** By: Kareem
  ** Using: addClass of active and remove if from the others;
  */
  function addActive (bullet,left = false){
    if (left === false) {
      if (clicked === true) {
        if (bullet.is(':last-child')) {
          bullet.removeClass('active');
          $('.controlers i:first-of-type').addClass("active");
        }else {
          bullet.next().addClass('active').siblings("i").removeClass("active");
        }
      }
    }else {
      if (clicked === true) {
        if (bullet.is(':first-child')) {
          bullet.removeClass('active');
          $('.controlers i:last-of-type').addClass("active");
        }else {
          bullet.prev().addClass('active').siblings("i").removeClass("active");
        }
      }
      console.log('Changed');
    }
  }

//--- Clicking Funcs ----
  /*
  ** left arrow click
  ** By: Kareem
  ** Using: the Global Functions
  */
  rightArrow.on('click', function (){
    // console.log(clicked);
    addActive($('.controlers i.active'));
    runSlider();
    console.log('Switch-right');
  });
  /*
  ** left arrow click
  ** By: Kareem
  ** Using: the Global Functions
  ** Status: Not Working Yet
  */
  leftArrow.on('click', function (){
    // console.log(clicked);
    addActive($('.controlers i.active'), true);
    runSlider(true);
    console.log('Switch-left');
  });
//--- Bullets Funcs ---

});
