
$("input").focus(function(){
    $(this).parent().children(".input_clear").show();
});

$("input").blur(function(){
    if($(this).val()=='')
    {
        $(this).parent().children(".input_clear").hide();
    }
});

$(".input_clear").click(function(){
    $(this).parent().find('input').val('');
    $(this).hide();
});