jQuery(window).ready(function(){
	if(!WHICHBROWSER.isSafari && !WHICHBROWSER.isMobile()){
		document.onmousewheel = function(){
			customSmoothScroll();
		};

		if(document.addEventListener){
			document.addEventListener('DOMMouseScroll', customSmoothScroll, false);
		}
	}

	function customSmoothScroll(event){
		if(!WHICHBROWSER.isSafari && !WHICHBROWSER.isMobile()){
			var delta = 0;
			if (!event){
			   event = window.event;
			}		   
			if (event.wheelDelta) {
			   delta = event.wheelDelta/120;
			} else if(event.detail) {
			   delta = -event.detail/3;
			}
			if(delta){
				var scrollTop = jQuery(window).scrollTop();
				var endScroll = scrollTop - parseInt(delta*100) * 3;
				TweenMax.to(jQuery(window), 1.5, {scrollTo:{y: endScroll, autoKill:true}, ease: Power4.easeOut, autoKill: true, overwrite: 5});
			}
			if (event.preventDefault){
				event.preventDefault();
			}
			event.returnValue = false;
		}
	}
});