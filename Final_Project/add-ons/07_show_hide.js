/*获得btn*/
var btn = document.getElementById("advanced_search_hide_show");
var spread = $(".advanced_ancestor")[0];
// console.log(btn);
// console.log(spread);
// btn.onclick=function(e){spread.style.display="none";}

var iSpread = true;
/*高度*/
var width = spread.scrollWidth
var left = btn.scrollLeft;
/*总时间*/
var time = 420;
/*间隔*/
var interval = 8.4
/*速度*/
var speed = width/(time/interval)
/*点击事件*/
btn.onclick = function show_hide(e) {
    btn.disabled = 'disabled'
    if(!iSpread)
    {
        var speeds = 0
        var timer = setInterval(function () {
            speeds += speed
            spread.style.width = speeds + 'px'
            btn.style.left=speeds + 'px'

            if(parseInt(spread.style.width) >=width)
            {
                clearTimeout(timer)
                btn.disabled = ''
            }
        },interval)
        // $("#advanced_search_hide_show")[0].style.left="25%";
        // $("#advanced_search_add_box")[0].style.display="block";
        // $("#advanced_search_del_box")[0].style.display="inline";
        // $("#advanced_search_submit")[0].style.display="block";
        this.innerHTML = 'Hide'
    }
    else
    {
        var speeds = width
        // $("#advanced_search_hide_show")[0].style.left="0";
        // $("#advanced_search_add_box")[0].style.display="none";
        // $("#advanced_search_del_box")[0].style.display="none";
        // $("#advanced_search_submit")[0].style.display="none";
        this.innerHTML = 'Show'
        var timer = setInterval(function () {
            speeds -= speed
            spread.style.width = speeds + 'px'
            btn.style.left=speeds + 'px'
            if(speeds <= 0)
            {
                clearTimeout(timer)
                btn.disabled = ''
            }
        },interval)
    }
    iSpread = !iSpread
}