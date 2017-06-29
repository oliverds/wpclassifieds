jQuery(document).ready(function($) {

	$("div.field").alternate();

});

function show(id){//displays an html element
	element = document.getElementById(id);
	if(element!=null){
		element.style.display = 'block';
	}
}

function hide(id){//hide an html element
	element = document.getElementById(id);
	if(element!=null){
		element.style.display = 'none';
	}
}

function openClose(id){ //hide/close an element
	element = document.getElementById(id);
	if(element!=null){
		if (element.style.display == 'block') {
			hide(id);
		}
		else{
			show(id);
			}
		}
}

jqueryslidemenu.buildmenu("top_dropdown")
droplinemenu.buildmenu("top_cats")

jQuery(document).ready(function($) {

    		$(".slider").jCarouselLite({
        		btnNext: ".next",
        		btnPrev: ".prev",
        		visible: 5,
				scroll: 5,
				auto: 4000,
				speed: 1000
    		});
});
