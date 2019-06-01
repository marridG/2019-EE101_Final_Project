
// $("input").focus(function(){
$(".input_button").focus(function(){
    $(this).parent().children(".input_clear").show();
});

// $("input").blur(function(){
$(".input_button").blur(function(){
    if($(this).val()=='')
    {
        $(this).parent().children(".input_clear").hide();
    }
});

$(".input_clear").click(function(){
    // $(this).parent().find('input').val('');
    $(this).parent().find('.input_button').val('');
    $(this).hide();
});