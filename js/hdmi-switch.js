
updateSwitchStatus = function(){
	$.getJSON( "/hdmi/status/", function( data ) {
		console.log(data);
		$.each(data, function( tv, input ) {
		    // console.log([tv, input]);
		    input   = input.replace("INPUT_0", "");
		    tv       = String.fromCharCode('a'.charCodeAt(0) + parseInt(tv.replace("TV_0", "") - 1));
		    selector = 'select.tv_' + tv;
		    console.log([tv, input, selector]);
            $(selector).val(input);

		});
	});
};

$( document ).ready(function() {

    $('select').on('change', function() {

        var tvSlug   = $(this).attr('data-tv-slug');
        var inputNum = this.value;
        var command  = tvSlug + inputNum;
        
        $.get( "./hdmi/set/"+command, function( data ) {
            
            console.log('Switch to Input: ' + command);
            
            if(tvSlug == 'all'){
                $('select').val(inputNum);
            }
            
        });

    });

    updateSwitchStatus();

    setInterval(function(){ updateSwitchStatus(); }, 30000);
});