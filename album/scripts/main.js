	window.onresize=function(){
		var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
		if($("#sidebar").css("display")=="none"){
			if(width < 900){
				
				$(".small").css("height", "calc(70vw)");
			}
			else if(width <1200){

				$(".small").css("height", "calc(35vw)");

			}
			else{
				$(".small").css("height", "calc(23vw)");
			}
		}
		else{
			if(width < 900){
				
				$(".small").css("height", "calc(70vw - 190px)");
			}
			else if(width <1200){

				$(".small").css("height", "calc(35vw - 98px)");

			}
			else{
				$(".small").css("height", "calc(23vw - 65px)");
			}

		}
	}

	$(document).ready(function(){
		/*
		$("#username").hover(function(){
			$(".log").slideDown();
		})
		*/
		$("#sure_hide").click(function(){
			$("#sure").slideUp();
		})
		$("#sure_show").click(function(){
			$("#sure").slideDown();
		})
		$("#deletealbum_toggle").click(function(){
	        $("#delete_album").slideToggle();
	    });

		$("#sidebar_hide").click(function(){
			$("#sidebar").hide();
			$("#wrapper").css("width","100%");
			var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
			if(width < 900){
				
				$(".small").css("height", "calc(70vw)");
			}
			else if(width <1200){

				$(".small").css("height", "calc(35vw)");

			}
			else{
				$(".small").css("height", "calc(23vw)");
			}
			$("#sidebar_show").fadeIn();
		})

		$("#sidebar_show").click(function(){
			$("#sidebar").fadeIn();
			$("#wrapper").css("width","calc(100% - 280px)");
			var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
			if(width < 900){
				
				$(".small").css("height", "calc(70vw - 190px)");
			}
			else if(width <1200){

				$(".small").css("height", "calc(35vw - 98px)");

			}
			else{
				$(".small").css("height", "calc(23vw - 65px)");
			}
			$("#sidebar_show").hide();
		})

	    $("#addalbum_toggle").click(function(){
	        $("#add_album").slideToggle();
	    });
	    $("#search_toggle").click(function(){
	        $("#search").slideToggle();
	    });
	    $("#allalbum_toggle").click(function(){
	        $("#catalog").slideToggle();
	    });
	    $("#addimg_toggle").click(function(){
	        $("#add_image").slideToggle();
	    });
	});