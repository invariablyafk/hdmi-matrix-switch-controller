
updateSwitchStatus = function(){
	$.getJSON( "./status/", function( data ) {
		$('.hdmi-switch .btn-group .btn').removeClass('btn-primary');
		$.each(data, function( key, input ) {
			var underscore_pos = key.indexOf("_")
			if(underscore_pos > -1){
				var tv = key.charAt(underscore_pos + 1);
				var selector = '.hdmi-switch .btn-group .btn.' + tv.toLowerCase() + input.replace("Input ", "");
				$(selector).addClass('btn-primary');
			}
		});
		
	});
};


$( document ).ready(function() {
    console.log( "ready!" );
    
    var btnPress = function(){
    	$(this).parent().children('.btn').removeClass('btn-primary');
    	
    	
    	var command = $(this).val();
    	var me = this;
    	
    	
    	$.get( "./hdmi/set/"+command, function( data ) {
		  $(me).addClass('btn-primary');
		  console.log('Switch to Input: ' + command);
		});
    };
    
    $('.hdmi-switch .btn-group .btn').click(btnPress);
    //$('.hdmi-switch .btn-group .btn').on('touchend', btnPress);
    
    
    // setInterval(function(){ updateSwitchStatus(); }, 1000);
});