$(document).ready(function () {

	$('#main_member_phone_no').change(function (e) {
		var phoneNo = $(this).val();
		firsttwodigit = phoneNo.substring(0, 2);
		if(firsttwodigit == '+1')
		{
			phoneNo = phoneNo.slice(2);
		}
			phoneNo = phoneNo.replace(/\D+/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '+1-$1-$2-$3');
		    phoneNo = phoneNo.substring(0, 15);
		
		$('#main_member_phone_no').val(phoneNo);
	});
	$('#partner_member_phone_no').change(function (e) {
		var phoneNo = $(this).val();
		firsttwodigit = phoneNo.substring(0, 2);
		if(firsttwodigit == '+1')
		{
			phoneNo = phoneNo.slice(2);
		}
			phoneNo = phoneNo.replace(/\D+/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '+1-$1-$2-$3');
		    phoneNo = phoneNo.substring(0, 15);
		
		$('#partner_member_phone_no').val(phoneNo);
	});
	getstate();
	var max_fields = 6; //maximum input boxes allowed
	var wrapper = $(".input_fields_wrap"); //Fields wrapper
	var add_button = $(".add_field_button"); //Add button ID

	var x = 1; //initlal text box count
	$(add_button).click(function (e) { //on add input button click
		e.preventDefault();
		if (x < max_fields) { //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div><p class="et_pb_contact_field ui-sortable et_pb_contact_field_half"><label>Child First Name</label><input type="text" name="child_first_name[]"  class="input"  placeholder="Child First Name" value=""/></p><p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last"><label>Child Last Name</label><input type="text" name="child_last_name[]"  class="input" placeholder="Child Last Name" value=""></p><p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last remove_child_text"><a href="#" class="remove_child">Remove</a></p></div>'); //add input box
		}
	});

	$(wrapper).on("click", ".remove_child", function (e) { //user click on remove text
		e.preventDefault(); $(this).parent('p').parent('div').remove(); x--;
	});

	checkAgreement();
	$('.agreement_error').hide();
	$('#register_submit_button').click(function () {
		if ($(this).is(':checked')) {
			checkAgreement();
		} else {
			checkAgreement();

		}
	});
	$('#agreement_page_id').click(function () {
		if ($(this).is(':checked')) {
			checkAgreement();
		} else {
			checkAgreement();

		}
	});

	if (window.location.pathname == '/member-dashboard/') {
		getStates();
		getChapters();
	}
	var notification = $('.success_flash');
	if (notification.length)
		setTimeout(function () {
			notification.addClass('fadeaway');
		}, 10000) // add class after 10 seconds

});
function checkAgreement() {
	$('#register_submit_button').attr('disabled', 'disabled');
	//if(!$('#register_submit_button').hasClass('register_submit_button'))
	$('#register_submit_button').addClass('register_submit_button');

	if ($('#agreement_page_id').is(':checked')) {
		$('.agreement_error').hide();
		$('#register_submit_button').removeAttr('disabled');
		$('#register_submit_button').removeClass('register_submit_button');
	} else {
		//alert('You must agree to Terms of Service');
		$('.agreement_error').show();
		$('#register_submit_button').attr('disabled', 'disabled');
		$('#register_submit_button').addClass('register_submit_button');
	}
}
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
	//getChapters();
	let country = parseInt($("#country").val()) || 0;
	let data = {
		action: "state_action",
		country: country,
	}
	let selected_state_id = parseInt($("#selected_state_id").val()) || 0;
	$.ajax({
		url: ajax_url,
		data: data,
		success: function (response) {

			if (response) {

				//let html = '<select class="et_pb_contact_select input" name="state" id="state_id" onchange="getChapters()">'
				let html = '<select class="et_pb_contact_select input" name="state" id="state_id">'

				html += '<option value="0">Select State</option>';
				for (let i = 0; i < response.length; i++) {
					if (selected_state_id == response[i]['state_type_id']) {

						html += '<option value="' + response[i]['state_type_id'] + '" selected>' + response[i]['state'] + '</option>';
					} else {

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
	let state = 0;//parseInt($("#state_id").val()) || parseInt($("#selected_state_id").val()) || 0;
	let country = parseInt($("#country").val()) || 0;
	let data = {
		action: "chapter_action",
		state: state,
		country: country
	}
	let selected_chapter_id = parseInt($("#selected_chapter_id").val()) || 0;
	$.ajax({
		url: ajax_url,
		data: data,
		success: function (response) {
			if (response) {

				let html = '<select class="et_pb_contact_select input" name="chapter" id="chapter_id">'
				html += '<option value="0">Select Chapter</option>';
				for (let i = 0; i < response.length; i++) {
					if (selected_chapter_id == response[i]['chapter_type_id']) {
						html += '<option class="chapter_option_feild" value="' + response[i]['chapter_type_id'] + '" selected>' + response[i]['name'] + '</option>';
					} else {
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

