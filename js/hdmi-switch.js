
var dropDownLinkSelector = '.dropdown-menu a';

updateSwitchStatus = function(){
	$.getJSON( "/hdmi/status/", function( data ) {
		$.each(data, function( tv, input ) {

		    input        = input.replace("INPUT_0", "");
		    tv           = String.fromCharCode('a'.charCodeAt(0) + parseInt(tv.replace("TV_0", "") - 1));
            selector     = 'a[href="/hdmi/set/' + tv + input + '"]';
            newLabelHtml = $(selector).html() + ' <span class="caret"></span>';

            $(selector).parents('ul').prev().empty().html(newLabelHtml);

		});
	});
};

$( document ).ready(function() {

    $(dropDownLinkSelector).on('click', function(event){

        event.preventDefault();

        var command       = $(this).attr('href');
        var inputLabel    = $(this).html();
        var newLabelHtml  = inputLabel + ' <span class="caret"></span>';
        var loadLabelHtml = inputLabel + ' <span class="glyphicon glyphicon-refresh spin" aria-hidden="true"></span>';
        var labelElement  = $(this).parents('ul').prev();

        labelElement.empty();
        labelElement.html(loadLabelHtml);

        console.log("Request: " + command);

        $.getJSON( command, function( data ) {
            console.log('Switch ' + (command.includes('all') ? 'all ' : '' ) + 'to Input: ' + inputLabel);
            labelElement.empty();
            labelElement.html(newLabelHtml);
        });

    });

    updateSwitchStatus();

    setInterval(function(){ updateSwitchStatus(); }, 30000);
});


