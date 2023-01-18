$(document).ready(function() {
	getstate();   
	});
	
function getstate(){
	var country_id = $("#country").val();
	var state_id = parseInt($("#state_id").val());
	$.ajax({
		url: ajaxurl,
		type: "POST",
		data: {
			country_id: country_id,
			state_id: state_id
		},
		cache: false,
		success: function(result){
		$("#state").html(result); 
		}
	});
}

		
$(document).ready( function() {
	var notification = $('.success_flash');
		if ( notification.length ) 
			setTimeout( function() {
					notification.addClass('fadeaway');
		}, 10000) // add class after 10 seconds
});
		