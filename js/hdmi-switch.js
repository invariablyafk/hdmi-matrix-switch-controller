
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

    var menuPress = function(){
    	var command = $(this).attr('value');
    	var me = this;

		$(me).parents('.btn-group').children('.btn').html($(me).html()+' <span class="caret"></span>');	  	
 	    
    	$.get( "./hdmi/set/"+command, function( data ) {
		  console.log('Switch to Input: ' + command);
		});
    };

    $('.hdmi-switch .btn-group .dropdown-menu li a').click(menuPress);
    //$('.hdmi-switch .btn-group .dropdown-menu li a').on('touchend', btnPress);
    
    // setInterval(function(){ updateSwitchStatus(); }, 1000);
});