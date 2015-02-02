var ajaxHandler = function(parentClass){
	var base = this;
	var parent = parentClass;
	var responseObject = new Object({});
	var pageDataCompleteEvent = document.createEvent('Event');
	var $ = jQuery;
	var callBack;
	var lastPageCalled;
	
	this.init = function(){
		pageDataCompleteEvent.initEvent('ajax_page_call', true, true);
	};

	this.getPage = function(params){
		lastPageCalled = params.target;
		if(responseObject[params.target]){ //DATA IS ALREADY LOADED
			document.dispatchEvent(pageDataCompleteEvent);
			document.removeEventListener('ajax_page_call', callBack, false);
		}else{ // NEW DATA REQUEST
			call(params).done(function (data) {
				responseObject[params.target] = data;
				document.dispatchEvent(pageDataCompleteEvent);
				document.removeEventListener('ajax_page_call', callBack, false);
			}).fail(function() {
				base.getPage(params);
			});
		}

		function call(params){
			return $.post(localvars.ajaxurl, params);
		}
	};

	this.getData = function(pagename){
		if(pagename !== undefined){
			return responseObject[pagename];
		}else{
			return responseObject[lastPageCalled];
		}
	};

	this.addEventListener = function(callback){
		if (callback !== undefined){
			callBack = callback;
			document.addEventListener('ajax_page_call', callBack, false);
		}
	};

	this.preFillPage = function(pagename, pagedata){
		responseObject[pagename] = pagedata;
	};

	this.init();
};