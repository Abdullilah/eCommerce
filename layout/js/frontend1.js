$(function(){
   $(".nameForm").keyup(function(){ $(".nameLive").text($(this).val()); });
   $(".descForm").keyup(function(){ $(".descLive").text($(this).val()); });
   $(".priceForm").keyup(function(){ $(".priceLive").text('$' + $(this).val()); });
});