/* CLASSES */
var _mousehandler; //Handels mouseevents
var _ajaxhandler; //Handels async page cacheing
/* VARS */
var $ = jQuery;

(function($){
	$(window).resize(function() {
		resize();
	});		
	$(window).load(function(){	
		_mousehandler = new mouseHandler(this);
	 	_ajaxhandler = new ajaxHandler(this);

	}); 		
	$(document).ready(function(){	
		
	});	
})(window.jQuery);
