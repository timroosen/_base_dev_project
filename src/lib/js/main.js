/* VARS */
var $ = jQuery;

/* ON PAGE LOAD */
(function($){
	$(window).resize(function() {
		
	});		
	$(window).load(function(){	
		this.mousehandler = new mouseHandler(); //Handels mouseevents		
		this.ajaxhandler = new ajaxHandler(this); //Handels async page cacheing
		this.smoothscroll = new smoothScroll(); //Smooth scrolling
		this.main = new main(); //Main document
	 	
	 	main.init(); //Init main document
	 	smoothscroll.start();
	}); 		
	$(document).ready(function() {
		
	});
})(window.jQuery);

/* MAIN DOCUMENT */
var main = function(){

	//PUBLIC FUNCTIONS
	this.init = function(){
		console.log('INIT');
	};

	this.helloPublic = function(){
		console.log('PUBLIC');
	};

	//PRIVATE FUNCTIONS
	function helloPrivate(){
		console.log('PRIVATE');
	}
};

