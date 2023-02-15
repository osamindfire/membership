$(document).ready(function () {
	getstate();
	
	if(window.location.pathname == '/member-dashboard/')
	{
		getStates();
		getChapters();
	}
	var notification = $('.success_flash');
	if (notification.length)
		setTimeout(function () {
			notification.addClass('fadeaway');
		}, 10000) // add class after 10 seconds

});

function getstate() {
	var country_id = $("#country").val();
	var state_id = parseInt($("#state_id").val());
	$.ajax({
		url: ajax_url + '?action=getStates',
		type: "POST",
		data: {
			country_id: country_id,
			state_id: state_id
		},
		cache: false,
		success: function (result) {
			$("#state").html(result);
		}
	});
}

function getStates() {
	getChapters();
	let country =  parseInt($("#country").val()) || 0;
	let data = {
		action: "state_action",
		country: country,
	}
	let selected_state_id =  parseInt($("#selected_state_id").val()) || 0;
	$.ajax({
		url: ajax_url,
		data: data,
		success: function (response) {

			if (response) {

				let html = '<select class="et_pb_contact_select input" name="state" id="state_id" onchange="getChapters()">'

					html += '<option value="0">Select State</option>';
				for (let i = 0; i < response.length; i++) {
					if(selected_state_id == response[i]['state_type_id']){

						html += '<option value="' + response[i]['state_type_id'] + '" selected>' + response[i]['state'] + '</option>';
					}else{

						html += '<option value="' + response[i]['state_type_id'] + '">' + response[i]['state'] + '</option>';
					}
				}

				html += '</select>';

				$("#state_id").remove();
				$("#state_input").append(html);

			}
		},
		error: function (e, response) {
			console.log("error");
		}
	});
};

function getChapters() {
	let state = parseInt($("#state_id").val()) || parseInt($("#selected_state_id").val()) || 0;
	let country =  parseInt($("#country").val()) || 0;
	let data = {
		action: "chapter_action",
		state: state,
		country: country
	}
	let selected_chapter_id =  parseInt($("#selected_chapter_id").val()) || 0;
	$.ajax({
		url: ajax_url,
		data: data,
		success: function (response) {
			if (response) {

				let html = '<select class="et_pb_contact_select input" name="chapter" id="chapter_id">'
						html += '<option value="0">Select Chapter</option>';
				for (let i = 0; i < response.length; i++) {
					if(selected_chapter_id == response[i]['chapter_type_id'])
					{
						html += '<option class="chapter_option_feild" value="' + response[i]['chapter_type_id'] + '" selected>' + response[i]['name'] + '</option>';
					}else{
						html += '<option class="chapter_option_feild" value="' + response[i]['chapter_type_id'] + '">' + response[i]['name'] + '</option>';
					}
				}

				html += '</select>';
				
				$("#chapter_id").remove();
				$("#chapter_input").append(html);

			}
		},
		error: function (e, response) {
			console.log("error");
		}
	});

};

