function setNegative(){
  $("div.wrap").find("input").each(function(){
    val = $(this).val()
    first = val.substring(0, 1);
    $(this).removeClass("negative")
    if(first=="-") $(this).addClass("negative")
  });
}

setNegative();
