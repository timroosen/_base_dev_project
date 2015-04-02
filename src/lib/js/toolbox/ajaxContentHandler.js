/*-------- START USAGE --------/*

	//example prarams to post//
	postParams = {};
	postParams.action = 'get_overlay';
	postParams.type = target;			--> Get object data with this target
	postParams.id = id;

	var _ajaxhandler = new ajaxHandler(baseclass or this);
	_ajaxhandler.addEventListener(callbackfunction);
	_ajaxhandler.getData(postParams);

	function callbackfunction(data){
		date = data returned from this.getData(dataObject)
	}

/*-------- END USAGE --------*/
var ajaxHandler = function(baseClass){
	var parent = baseClass;
	var responseObject = new Object({});
	var dataCompleteEvent = document.createEvent('Event');
	var callBack;
	var lastPageCalled;

	//PUBLIC FUNCTIONS
	this.getData = function(params){
		lastPageCalled = params.target;
		if(responseObject[params.target]){ //DATA IS ALREADY LOADED
			document.dispatchEvent(dataCompleteEvent);
			document.removeEventListener('ajax_call', onCompleteCallback, false);
		}else{ //NEW DATA REQUEST
			call(params).done(function (data) {
				responseObject[params.target] = data;
				document.dispatchEvent(dataCompleteEvent);
				document.removeEventListener('ajax_call', onCompleteCallback, false);
			}).fail(function() {
				this.getPage(params);
			});
		}
	};

	this.getData = function(dataObject){
		if(pagename !== undefined){
			return responseObject[dataObject];
		}else{
			return responseObject[lastPageCalled];
		}
	};

	this.addEventListener = function(callback){
		if (callback !== undefined){
			callBack = callback;
			document.addEventListener('ajax_call', onCompleteCallback, false);
		}
	};

	this.preFillPage = function(dataObject, pagedata){
		responseObject[dataObject] = pagedata;
	};

	//PRIVATE FUNCTIONS
	function init(){
		dataCompleteEvent.initEvent('ajax_call', true, true);
	}

	function onCompleteCallback(){
		callback(this.getData);
	}

	function call(params){
		return $.post(localvars.ajaxurl, params);
	}

	init();
};