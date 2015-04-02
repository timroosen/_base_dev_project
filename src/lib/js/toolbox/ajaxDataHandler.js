/*-------- START USAGE --------/*

	//example prarams to post//
	postParams = {};
	postParams.action = 'get_code';
	postParams.id = id;

	var _ajaxDatahandler = new ajaxDataHandler(baseclass or this);
	_ajaxDatahandler.addEventListener(callbackfunction);
	_ajaxDatahandler.getData(postParams);

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
		call(params).done(function (data) {
			responseObject.data = data;
			document.dispatchEvent(dataCompleteEvent);
			document.removeEventListener('ajax_call', onCompleteCallback, false);
		}).fail(function() {
			this.getPage(params);
		});
	};

	this.addEventListener = function(callback){
		if (callback !== undefined){
			callBack = callback;
			document.addEventListener('ajax_call', onCompleteCallback, false);
		}
	};

	//PRIVATE FUNCTIONS
	function init(){
		dataCompleteEvent.initEvent('ajax_call', true, true);
	}

	function onCompleteCallback(){
		callback(responseObject.data);
	}

	function call(params){
		return $.post(localvars.ajaxurl, params);
	}

	init();
};