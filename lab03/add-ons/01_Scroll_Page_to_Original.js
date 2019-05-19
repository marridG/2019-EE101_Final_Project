var _h = 0;
function SetH(o)
{
    h = o.scrollTop
    SetCookie("a", _h)
}

window.onload = function ()
{ //页面加载时设置scrolltop高度
    document.getElementById("x").scrollTop = GetCookie("a");
}

function SetCookie(sName, sValue)
{
    document.cookie = sName + "=" + escape(sValue) + "; ";
}

function GetCookie(sName)
{
    var aCookie = document.cookie.split("; ");
    for (var i = 0; i < aCookie.length; i++)
    {
        var aCrumb = aCookie[i].split("=");
        if (sName == aCrumb[0])
            return unescape(aCrumb[1]);
    }
    return 0;
}


