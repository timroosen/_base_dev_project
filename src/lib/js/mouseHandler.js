var mouseHandler = function(){
	var clickListeners = '';
	var postParams = {};
	var $ = jQuery;

	if (/ip(hone|od)|ipad/i.test(navigator.userAgent)){
		$("body").css ("cursor", "pointer");			   	  
	}
					
	$('body').on('click', clickListeners, function(event){
		event.preventDefault();	
		var arr = clickListeners.split(',');
		for(var i=0;i<arr.length;i++){
			if($(this).attr('id') == arr[i].substring(1)){
				this.buttonClick($(this).attr('id'), $(this));	
				break;
			}
			if($(this).hasClass(arr[i].substring(1))){
				this.buttonClick(arr[i].substring(1), $(this));						
				break;
			}
		}	
	});

	this.buttonClick = function(str, target){
		switch(str){
			case 'test':

			break;
		}
	};
};