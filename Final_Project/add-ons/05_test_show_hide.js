    // console.log(111);
    /*获得btn*/
    var btn = document.getElementById('btn')
    var spread = document.getElementById('spread')
    /*高度*/
    var height = spread.scrollHeight
    /*总时间*/
    var time = 420;
    /*间隔*/
    var interval = 8.4
    /*速度*/
    var speed = height/(time/interval)
    /*点击事件*/
    // php 变量
    var key_word='<?php echo $key_word_temp;>'
    var page_title='<?php echo $page_title;>'
    var page_author='<?php echo $page_author;>'
    var page_conference='<?php echo $page_conference;>'
    var iSpread='<?php echo $show_hide;>'
    console.log(key_word)
    btn.onclick = function (e) {
        btn.disabled = 'disabled'
        if(!iSpread){
            spread.style.display="block"    // 自己改的
            var speeds = 0
            var timer = setInterval(function () {
                speeds += speed
                spread.style.height = speeds + 'px'

                if(parseInt(spread.style.height) >=height){
                    clearTimeout(timer)
                    btn.disabled = ''
                }
            },interval)
            this.innerHTML = 'Hide Detailed Results'
        }else {
            spread.style.display="none"    // 自己改的
            var speeds = height
            this.innerHTML = 'Show Detailed Results'
            var timer = setInterval(function () {
                speeds -= speed
                spread.style.height = speeds + 'px'
                if(speeds <= 0){
                    clearTimeout(timer)
                    btn.disabled = ''
                }
            },interval)
        }
        iSpread = !iSpread
        console.log(iSpread)
        // $.post("/EE101-Final_Project/Final_Project/search.php", {"show_hide":iSpread})
        // $.ajax({  
        //     type:'GET',  
        //     url:"/EE101-Final_Project/Final_Project/search.php",  
        //     data:{"show_hide":iSpread},  
        //     success: function(data){  
        //     alert(data)  
        //     }  
        // });
    }


    // var btn = $('#btn')
    // var spread = $('#spread')
    // btn.click(function () {
    //     spread.slideToggle()
    // })
