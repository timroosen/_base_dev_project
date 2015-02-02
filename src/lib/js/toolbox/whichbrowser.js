WHICHBROWSER = {
	isSafari : function(){	
		return /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
	},
	
	isChrome : function(){
		return /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
	},
	
	isMSIE : function(){
		return ((navigator.appName == 'Microsoft Internet Explorer') || ((navigator.appName == 'Netscape') && (new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})").exec(navigator.userAgent) !== null)));
	},
	
	isFireFox : function(){
		return /Firefox/.test(navigator.userAgent);
	},

	isNativeAndroid : function(){
		return ((navigator.userAgent.indexOf('Mozilla/5.0') > -1 && navigator.userAgent.indexOf('Android ') > -1 && navigator.userAgent.indexOf('AppleWebKit') > -1) && !(navigator.userAgent.indexOf('Chrome') > -1));
	},

	isIOSOther : function(){
		return navigator.userAgent.match('CriOS') !== null;
	}
};

WHICHMOBILE = {
	isAndroid: function() {
		return navigator.userAgent.match(/Android/i);
	},
	
	isBlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	
	isIOS: function() {
		if(navigator.userAgent.match(/iPhone|iPad|iPod/i)){
			return true;
		}else{
			return false;
		}
	},

	isOpera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	
	isWindows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
};

WHICHDEVICE = {
	isIpad : function(){
		return navigator.userAgent.match(/iPad/i);
	},

	isMobile : function(){
		return /android|webos|iphone|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase());
	},

	isDesktop  : function(){
		if(!WHICHDEVICE.isMobile() && !WHICHDEVICE.isIpad()){
			if (WHICHBROWSER.isSafari() || WHICHBROWSER.isChrome() || WHICHBROWSER.isMSIE() || WHICHBROWSER.isFireFox()){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
};
