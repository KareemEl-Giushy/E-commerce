
//--- All variabels ----

//--- Items vars ----
  var ulItems = $(".text-slider ul");
  var item = $(".text-slider ul li");
  // var itemWidth = item.innerWidth();
//--- Icons ---
  var controls = $(".controlers");
  var bullet = controls.find('i');
//-- controling vars ---
  var controlA = $(".arrows-control");
  var leftArrow = $(".arrows-control i:first-of-type");
  var rightArrow = $(".arrows-control i:last-of-type");
//-- img vars ------
  var ulImgs = $(".image-cont ul");
  var img = ulImgs.find('li');
  // var imgWidth = img.innerWidth();
//-- Global Vars ----
  var sliderTime = 800;
  var sliderDelay = 3000;
  var clicked = true;
  var autoPlay;

//-- adding active class dynamic ----
item.first().addClass('active');
bullet.first().addClass('active');
img.first().addClass('active');
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
            marginLeft: -item.innerWidth() * ($('.text-slider ul li.active').index() + 1)

          }, sliderTime, function (){
            clicked = true;
          });

          $('.text-slider ul li.active').removeClass('active').next().addClass('active');
        }
      }

    }else {

      if (clicked === true) {
        clicked = false;

        if ($('.text-slider ul li.active').is(':first-of-type')) {
          $('.text-slider ul li.active').removeClass('active');
          $('.text-slider ul li').last().addClass('active');

          ulItems.animate({
            marginLeft: -item.innerWidth() * ($('.text-slider ul li.active').index())
          },function (){
            clicked = true;
          });
          console.log('Sliding');
        }else {

          ulItems.animate({
            marginLeft: parseFloat( $('.text-slider ul').css('margin-left').slice(0, -2) ) + $('.text-slider ul li').innerWidth()

          }, sliderTime, function (){
            clicked = true;
          });

          $('.text-slider ul li.active').removeClass('active').prev().addClass('active');
        }
      }
    }
    console.log('run');
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
/********************* Img-slider funcs ***********************/

  // /*
  // ** Running the img slider
  // ** By: Kareem
  // ** Using:
  // */
  // function runImgs (left = false){
  //   console.log('activated');
  //   if (clicked === true) {
  //
  //     clicked = false;
  //
  //     if (left === false) {
  //
  //       ulImgs.animate({
  //         marginTop: -img.innerWidth() * $('.image-cont ul li.active').index()
  //       }, sliderTime, function (){
  //         clicked = true;
  //       });
  //
  //       $('.image-cont ul li.active').removeClass("active").next().addClass('active');
  //     }
  //   }
  // }
  function clicker(){
    // console.log(clicked);
    addActive($('.controlers i.active'));
    runSlider();

    // running the image slider
    if ($('.image-cont ul li.active').is(":last-of-type")) {
      console.log('img-last');
      ulImgs.animate({
        marginTop: 0
      }, function (){
        $('.image-cont ul li').last().removeClass("active");
        img.first().addClass('active');
      });
    }else {
      console.log('img-move');

      ulImgs.animate({

        marginTop: -img.innerHeight() * ($('.image-cont ul li.active').index() + 1)

      }, sliderTime, function (){

        $('.image-cont ul li.active').removeClass("active").next().addClass('active');
      });
    }
    // End running the image slider
    console.log('Switch-right');
  }
//--- End declearing ==================

$(document).ready(function (){

//--- Clicking Funcs ----
  /*
  ** Right arrow click
  ** By: Kareem
  ** Using: the Global Functions
  */
  rightArrow.on('click', function (){
    clicker();
  });
  /*
  ** left arrow click
  ** By: Kareem
  ** Using: the Global Functions
  ** Status: Not Working Yet
  */
  leftArrow.on('click', function (){
    console.log("clicked");
    addActive($('.controlers i.active'), true);
    runSlider(true);
    // running the image slider
    if ($('.image-cont ul li.active').is(":first-of-type")) {
      console.log('img-first');
      ulImgs.animate({
        marginTop: -img.innerHeight() * ($('.image-cont ul li').last().index())
      }, function (){
        $('.image-cont ul li').first().removeClass("active");
        img.last().addClass('active');
      });
    }else {
      console.log('img-move');

      ulImgs.animate({

        marginTop: parseFloat( $('.image-cont ul').css('margin-Top').slice(0, -2) ) + img.innerHeight()

      }, sliderTime, function (){

        $('.image-cont ul li.active').removeClass("active").prev().addClass('active');
      });
    }
    // End running the image slider
    console.log('Switch-left');
  });
//--- Bullets Funcs ---
  bullet.on('click', function (){
    if ($(this).index() == 0) {
      ulItems.animate({
        marginLeft: 0
      });
      ulImgs.animate({
        marginTop: 0
      });
    }
    if ($(this).index() == controls.find('i:last-child').index()) {
      ulItems.animate({
        marginLeft: -$('.text-slider ul li').last().index() * item.innerWidth()
      });
    }else {

      if ($('.text-slider ul li.active').index() !== $(this).index()) {
        console.log('condetion');
        if (clicked === true) {

          ulItems.animate({
            marginLeft: -item.innerWidth() * $(this).index()
          });
          console.log($(this).index());
          console.log(-item.innerWidth() * $(this).index());
        }
      }
    }
    // running the image slider
    if ($(this).index() == controls.find('i:last-child').index()) {
      ulImgs.animate({
        marginTop: -$('.image-cont ul li').last().index() * img.innerHeight()
      });
    }else {

      if ($('.image-cont ul li.active').index() !== $(this).index()) {
        console.log('condetion-image');
        if (clicked === true) {

          ulImgs.animate({
            marginTop: -img.innerHeight() * $(this).index()
          });
          console.log($(this).index());
          console.log(-img.innerHeight() * $(this).index());
        }
      }
    }
    // console.log($(this).index());
  });
//--------------------- AutoPlay ---------------------------------
  function autoPlayy (){
  autoPlay = setInterval(function() { clicker(); }, sliderDelay);

  }
  autoPlayy();

// ======================== slider Hovering ==============
controlA.find('i').on('mouseenter', function (){ clearInterval(autoPlay); console.log('mouse-Enter'); })
  controlA.find('i').on('mouseleave', function (){ autoPlayy(); console.log('mouse-Leave'); })
});
