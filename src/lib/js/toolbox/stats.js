STATS = {
	setSat : function(type, target){	
		var device= $('body').attr('class');			
		$.post("inc/php/calls.php", { action: "set_stat", device: device, type:type,target:target}, function(){});	
		ga('send', 'event', device, type, target);
	}
};