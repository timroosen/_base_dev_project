var smoothScroll = function(){
	this.start = function(){
		if(window.addEventListener) {
	        var eventType = (navigator.userAgent.indexOf('Firefox') !=-1) ? "DOMMouseScroll" : "mousewheel";            
	        window.addEventListener(eventType, this.customSmoothScroll, false);
	    }
	};

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
};