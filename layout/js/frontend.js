$(function(){
   
    // Remove placeholder when focusing
    $('[placeholder]').focus(function(){
        $(this).attr("data-text", $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
        
    }).blur(function(){
        $(this).attr('placeholder', $(this).attr("data-text"));
        console.log("asdas");
    });
    
    $(".loginSignUp span.login").click(function(){
        $(this).addClass("active1");
        $(this).siblings().removeClass("active2");
        $(".signupForm").fadeOut(0);
        $(".loginForm").fadeIn(1000);
    });
    $(".loginSignUp span.signup").click(function(){
        $(this).addClass("active2");
        $(this).siblings().removeClass("active1");
        $(".loginForm").fadeOut(0);
        $(".signupForm").fadeIn(1000);
    });
    
    // Red star beside required fields
    $('input').each(function(){
        if($(this).attr("required") == "required"){
            $(this).after("<span class='star'>*</span>");
        }
    });
    
 
//    // Confirm when you click button
//    $('.confirm').click(function(){
//        return confirm("Are You Sure?");
//    });
});