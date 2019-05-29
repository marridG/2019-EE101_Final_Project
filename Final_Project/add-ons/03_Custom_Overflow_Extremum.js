
console.log("111");
	
// Under Construction!
	var sc=document.getElementsByClassName("all__Turn_Page_jump_to_number");
	sc[0].onblur=function()
	{
		if(sc.validity.rangeUnderflow)
		{
			sc.setCustomValidity("Overflow");
		}
	}
