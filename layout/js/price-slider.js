$(document).ready(function (){

  /*
  ** Making a range slider with jquery
  ** By: Kareem
  ** Using: jRange
  */
  $('#ranger').slider({
    range: true,
    animate: 'fast',
    min: 0,
    max: 500,
    values: [75, 300],
    step: 5
  });
  document.querySelector("input[name=from]").value = $('#ranger').slider('option').values[0] + '$';
  document.querySelector("input[name=to]").value = $('#ranger').slider('option').values[1] + '$';
  // var cleaner = setInterval(function (){ it was an option

  $('#ranger').on('slide', function (){
      document.querySelector("input[name=from]").value = $('#ranger').slider('option').values[0] + '$';
      document.querySelector("input[name=to]").value = $('#ranger').slider('option').values[1] + '$';
      console.log($('#ranger').slider('option'));
  });
    // }, 1);


  $("input[name=from]").on('keyup', function (){
    if (!isNaN(parseFloat(document.querySelector("input[name=from]").value)) && !isNaN(parseFloat(document.querySelector("input[name=to]").value))) {
      $('#price-ms').css('opacity', 0);
      if ( parseFloat(document.querySelector("input[name=from]").value) <parseFloat(document.querySelector("input[name=to]").value) ) {
        var i = [parseFloat(document.querySelector("input[name=from]").value), parseFloat(document.querySelector("input[name=to]").value)];
        $('#ranger').slider('values', i);
      }else {
        $('#price-ms').text('* From must be less than to');
        $('#price-ms').css('opacity', 1);
      }

    }else {
      $('#price-ms').text('* Must Be a Number');
      $('#price-ms').css('opacity', 1);

    }
    console.log($('#ranger').slider('option').values);

  });


  $("input[name=to]").on('keyup', function (){
    if (!isNaN(parseFloat(document.querySelector("input[name=from]").value)) && !isNaN(parseFloat(document.querySelector("input[name=to]").value))) {
      $('#price-ms').css('opacity', 0);
      if ( parseFloat(document.querySelector("input[name=to]").value) > parseFloat(document.querySelector("input[name=from]").value) ) {
        var i = [parseFloat(document.querySelector("input[name=from]").value), parseFloat(document.querySelector("input[name=to]").value)];
        $('#ranger').slider('values', i);
      }else {
        $('#price-ms').text('* to must be more than from');
        $('#price-ms').css('opacity', 1);
      }

    }else {
      $('#price-ms').text('* Must Be a Number');
      $('#price-ms').css('opacity', 1);

    }
    console.log($('#ranger').slider('option').values);

  });
});
