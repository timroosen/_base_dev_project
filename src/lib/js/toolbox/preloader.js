var preLoader = function(parentClass){
	var base = this;
	var parent = parentClass;
	var loadArray = [];
	var loadCount = 0;
	var imageLoadCompleteEvent = document.createEvent('Event');
	var callBack;
	var $ = jQuery;

	this.init = function(){
		imageLoadCompleteEvent.initEvent('preload_image_data', true, true);
	};

	this.startLoad = function(){
		TweenMax.to('#preloader-image', 0.8, { rotation: 360, repeat: -1, ease:   Linear.easeNone });

		var postParams = {};
	 	postParams.action ='get_wp_images';

		call(postParams).done(function (data) {
			base.fillArray(JSON.parse(JSON.parse(data)[0].project_images), JSON.parse(JSON.parse(data)[0].base_images));
		}).fail(function() {
			base.startLoad();
		});
		
		function call(postParams){
			return $.post(localvars.ajaxurl, postParams);
		}
	};

	this.fillArray = function(wpData, baseData){
		var i;
		if(WHICHDEVICE.isMobile()){
			for(i=0;i<wpData.length;i++){
				loadArray.push(wpData[i].project_logo);
			}
		}else{
			for(i=0;i<wpData.length;i++){
				loadArray.push(wpData[i].project_logo);
				loadArray.push(wpData[i].project_background_image);
			}
		}

		for(i=0;i<baseData.length;i++){
			loadArray.push(baseData[i]);
		}

		this.startPreload();
	};

	this.startPreload = function(){
		var img = $('<img src="'+loadArray[loadCount]+'" />');
		$(img).load(function() {
		    if(loadCount == loadArray.length-1){
		    	TweenMax.delayedCall(2, base.loadComplete);
		    	img = $('');
		    }else{
		    	loadCount++;
		    	img = $('');
		    	base.startPreload();
		    }
		});
	};

	this.loadComplete = function(){
		TweenMax.killTweensOf('#preloader-image');

		document.dispatchEvent(imageLoadCompleteEvent);
		document.removeEventListener('preload_image_data', callBack, false);
	};

	this.addEventListener = function(callback){
		callBack = callback;
		document.addEventListener('preload_image_data', callBack, false);
	};

	this.init();
};