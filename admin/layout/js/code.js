$(function (){
  $("[placeholder]").focus(function (){
    $(this).attr("data", $(this).attr("placeholder"));
    $(this).attr("placeholder", "");
  });
  $("[placeholder]").blur(function (){
    $(this).attr("placeholder", $(this).attr("data"));
    $(this).removeAttr("data");
  });
  $("#show").click(function (){
    if($("#show > i").attr('class') == 'fa fa-eye'){
      $('#show > i').removeClass('fa fa-eye');
      $('#show > i').addClass('fa fa-eye-slash');
      $('[name=pass]').attr('type', 'text');
    }else {
      $('#show > i').removeClass('fa fa-eye-slash');
      $('#show > i').addClass('fa fa-eye');
      $('[name=pass]').attr('type', 'password');
    }
  });
  $('input').each(function (){
    if ($(this).attr('required') == 'required') {
      $(this).after("<span class='negma'>*</span>");
    }
  });
  $('.confirm').click(function (){
    return confirm('Do You Want To Delete This Item ?');
  });
  $('.cstyle sub').click(function (){
    var thetext = $(this).text();
    console.log('clicked');
    if (thetext == 'Classic') {
      $(this).text('Full');
      $(".card .card-body").fadeOut();
      $(".card .card-footer").fadeOut();
      $(".card").css("min-height", "auto");
      console.log('hamada');
    }else if (thetext == 'Full') {
      $(this).text('Classic');
      $(".card .card-body").fadeIn();
      $(".card .card-footer").fadeIn(function (){
        $(".card").css("min-height", "277px");
      });
      console.log('mayada');
    }
  });
  $('.desc').click(function (){
    $(this).toggleClass('desc-hover');
  });
  $('select').selectBoxIt({
    // theme: 'bootstrap',
    autoWidth: false
  });
});
