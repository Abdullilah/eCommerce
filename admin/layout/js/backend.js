$(function(){
    
    // To add the select Box with special style
    $("select").selectBoxIt({
        autoWidth: false
    });
    
    //Dashbord
    $('.panel-heading i.plus').click(function(){
        $(this).parent().next().fadeToggle(500);
        if($(this).attr("class") == "fa fa-minus plus"){
            $(this).attr("class", "fa fa-plus plus");
        } else{
            $(this).attr("class", "fa fa-minus plus");
        }
    });
    
    // Remove placeholder when focusing
    $('[placeholder]').focus(function(){
        $(this).attr("data-text", $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function(){
        $(this).attr('placeholder', $(this).attr("data-text"));
    });
    
    // Red start beside required fields
    $('input').each(function(){
        if($(this).attr("required") == "required"){
            $(this).after("<span class='star'>*</span>");
        }
    });
    
    // Conver tpassword field to text
    var passField = $('.password');
    $('.show-pass').hover(function(){
        passField.attr('type', 'text');
    }, function(){
        passField.attr('type', 'password');
    });
    
    // Confirm when you click button
    $('.confirm').click(function(){
        return confirm("Are You Sure?");
    });
 
});
});