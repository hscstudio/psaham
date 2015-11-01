$('#myModal').on('shown.bs.modal', function (event) {
    var modal = $(this)
    if(modal.attr('id')=='myModal'){
      var button = $(event.relatedTarget)
      var title = button.data('title')
      var size = button.data('size')
      var href = button.attr('href')
      modal.find('.modal-title').html(title)
      modal.find('.modal-dialog').attr('class','modal-dialog '+size)
      modal.find('.modal-body').html('<span class=\"ajax-loader\"></span>')
      $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
          //options.async = true;
      });
      $.ajax({
        method: 'post',
        url: href,
      }).done(function(data) {
          modal.find('.modal-body').html(data)
      });
    }
})

$('#myModal').on('hidden.bs.modal', function (e) {
  var modal = $(this)
  modal.find('.modal-body').html('')
  modal.find('.modal-title').html('')
  //modal.find('.modal-dialog').attr('class','modal-dialog modal-sm')
})

function setNegative(){
  $("div.wrap").find("input").each(function(){
    val = $(this).val()
    first = val.substring(0, 1);
    $(this).removeClass("negative")
    if(first=="-") $(this).addClass("negative")
  });
}

setNegative();
