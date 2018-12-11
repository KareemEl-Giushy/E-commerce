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
  $('select').selectBoxIt({
    // theme: 'bootstrap',
    autoWidth: false
  });

  /* Front-end */

/*I putted the two functions inside each other just like event listener*/
    $('.signup-btn').click(function (){
      if ($('.login-btn').hasClass('clickedy')){
        $('.signup-btn').addClass('clickedy');
        $('.login-btn').removeClass('clickedy');
        $('.login').hide(0,function (){
          $('.signup').show(500);
        });
      }
  });


  $('.login-btn').click(function (){
    if ($('.signup-btn').hasClass('clickedy')){
      $('.login-btn').addClass('clickedy');
      $('.signup-btn').removeClass('clickedy');
      $('.signup').hide(0,function (){
        $('.login').show(500);
      });
    }
  });

  /* Add New item page LiveShow */

  // item name
  $('input[name="itemname"]').keyup(function (){
    $('.card .card-body h6.card-title').text($(this).val());
  });

  // item description
  $('textarea[name="description"]').keyup(function (){
    $('.card .card-body p.item-desc').text($(this).val());
  });

  // The price
  $('input[name="price"]').keyup(function (){
    var pnum = $(this).val();
    if (Number($(this).val()) < 0) {
      var pnum = Math.abs(Number($(this).val()));
    }
    if (!isNaN(pnum)) {
      $('.card .card-header h5.card-text').text(pnum + '$');
    }else {
      $('.card .card-header h5.card-text').text('Numbers Only');
    }
  });
});
