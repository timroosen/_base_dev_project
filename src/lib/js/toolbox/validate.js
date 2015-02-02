VALIDATE = {
	isEmail : function(val){	
		var regExp = /^(([^<>()[\]\\.,;:\s@\""]+(\.[^<>()[\]\\.,;:\s@\""]+)*)|(\"".+\""))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
		return regExp.test(val);	
	},
	
	isEmpty : function(val){
		if (val == '' || val == null) return false;
		return true;
	},
	
	isEmpty : function(val){
		if (val == '' || val == null) return false;
		return true;
	},
	
	isLength : function(val, maxLength){
		if (val.length<maxLength || val == null) return false;
		return true;
	},
	
	isChecked : function(id){
		return $(id).is(':checked');
	},
	
	isMobileNumberNL : function(val){
		var regExp = /(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)/;
		return regExp.test(val);
	},
	
	isPostcode : function(val){
		var regExp = /^([1-9][\d]{3}\s?(?!(sa|sd|ss|SA|SD|SS|Sa|sA|Sd|sD|Ss|sS))([a-eghj-opr-tv-xzA-EGHJ-OPR-TV-XZ]{2})?$)/;
		return regExp.test(val);
	}
}	