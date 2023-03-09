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

function recaptchaCallback() {
		$('#recaptcha_value').val(1);
		validatedata();
};
function validatedata() {
	var arr = {};
	arr['first_name']= $("#first_name").val();
	arr['last_name']= $("#last_name").val();
	arr['email']= $("#email").val();
	arr['main_member_phone_no']= $("#main_member_phone_no").val();
	arr['password']= $("#password").val();
	arr['confirm_password']= $("#confirm_password").val();
	
	arr['spouse_first_name']= $("#spouse_first_name").val();
	arr['spouse_last_name']= $("#spouse_last_name").val();
	arr['spouse_email']= $("#spouse_email").val();
	arr['partner_member_phone_no']= $("#partner_member_phone_no").val();
	arr['spouse_password']= $("#spouse_password").val();
	arr['spouse_confirm_password']= $("#spouse_confirm_password").val();

	arr['address_line_1']= $("#address_line_1").val();
	arr['country']= $("#country").val();
	arr['state']= $("#state").val();
	arr['city']= $("#city").val();
	arr['postal_code']= $("#postal_code").val();
	if ($('#agreement_page_id').is(':checked')) {
		arr['agreement_page_id']= 'yes';
	} else {
		arr['agreement_page_id']= 'no';

	}
	arr['recaptcha_value']= $("#recaptcha_value").val();
	/* if ($('#recaptcha-accessible-status').text() == 'You are verified') {
		arr['recaptcha-anchor']= 'yes';
	} else {
		arr['recaptcha-anchor']= 'no';

	} */
	//console.log(arr);
	
	let data = {
		action: "register_validate",
		post_fields: arr,
	}
	$.ajax({
		url: ajax_url,
		type: "POST",
		data: data,
		success: function (response) {

			if (response) {
				
				var blank='';
				var valid = true;
				if(response['first_name']){
					valid = false;
					$("#first_name_error_messages").text(response['first_name']);
					$("#first_name").addClass('et_contact_error');
				}else{
					$("#first_name_error_messages").text(blank);
					$("#first_name").removeClass('et_contact_error');
				}
				
				if(response['last_name']){
					valid = false;
					$("#last_name_error_messages").text(response['last_name']);
					$("#last_name").addClass('et_contact_error');
				}else{
					$("#last_name_error_messages").text(blank);
					$("#last_name").removeClass('et_contact_error');
				}

				if(response['email']){
					valid = false;
					$("#email_error_messages").text(response['email']);
					$("#email").addClass('et_contact_error');
				}else{
					$("#email_error_messages").text(blank);
					$("#email").removeClass('et_contact_error');
				}

				if(response['main_member_phone_no']){
					valid = false;
					$("#main_member_phone_no_error_messages").text(response['main_member_phone_no']);
					$("#main_member_phone_no").addClass('et_contact_error');
				}else{
					$("#main_member_phone_no_error_messages").text(blank);
					$("#main_member_phone_no").removeClass('et_contact_error');
				}

				if(response['password']){
					valid = false;
					$("#password_error_messages").text(response['password']);
					$("#password").addClass('et_contact_error');
				}else{
					$("#password_error_messages").text(blank);
					$("#password").removeClass('et_contact_error');
				}
				if(response['confirm_password']){
					valid = false;
					$("#confirm_password_error_messages").text(response['confirm_password']);
					$("#confirm_password").addClass('et_contact_error');
				}else{
					$("#confirm_password_error_messages").text(blank);
					$("#confirm_password").removeClass('et_contact_error');
				}
				if(response['spouse_first_name']){
					valid = false;
					$("#spouse_first_name_error_messages").text(response['spouse_first_name']);
					$("#spouse_first_name").addClass('et_contact_error');
					$("#spouse_first_name_label").addClass('required_field');
				}else{
					$("#spouse_last_name_error_messages").text(blank);
					$("#spouse_last_name").removeClass('et_contact_error');
					$("#spouse_first_name_label").removeClass('required_field');
				}
				if(response['spouse_last_name']){
					valid = false;
					$("#spouse_last_name_error_messages").text(response['spouse_last_name']);
					$("#spouse_last_name").addClass('et_contact_error');
					$("#spouse_last_name_label").addClass('required_field');
				}else{
					$("#spouse_last_name_error_messages").text(blank);
					$("#spouse_last_name").removeClass('et_contact_error');
					$("#spouse_last_name_label").removeClass('required_field');
				}

				if(response['spouse_email']){
					valid = false;
					$("#spouse_email_error_messages").text(response['spouse_email']);
					$("#spouse_email").addClass('et_contact_error');
					$("#spouse_email_label").addClass('required_field');
				}else{
					$("#spouse_email_error_messages").text(blank);
					$("#spouse_email").removeClass('et_contact_error');
					$("#spouse_email_label").removeClass('required_field');
				}

				if(response['spouse_password']){
					valid = false;
					$("#spouse_password_error_messages").text(response['spouse_password']);
					$("#spouse_password").addClass('et_contact_error');
					$("#spouse_password_label").addClass('required_field');
				}else{
					$("#spouse_password_error_messages").text(blank);
					$("#spouse_password").removeClass('et_contact_error');
					$("#spouse_password_label").removeClass('required_field');
				}

				if(response['spouse_confirm_password']){
					valid = false;
					$("#spouse_confirm_password_error_messages").text(response['spouse_confirm_password']);
					$("#spouse_confirm_password").addClass('et_contact_error');
					$("#spouse_confirm_password_label").addClass('required_field');
					
				}else{
					$("#spouse_confirm_password_error_messages").text(blank);
					$("#spouse_confirm_password").removeClass('et_contact_error');
					$("#spouse_confirm_password_label").removeClass('required_field');
				}

				if(response['address_line_1']){
					valid = false;
					$("#address_line_1_error_messages").text(response['address_line_1']);
					$("#address_line_1").addClass('et_contact_error');
				}else{
					$("#address_line_1_error_messages").text(blank);
					$("#address_line_1").removeClass('et_contact_error');
				}
				if(response['country']){
					valid = false;
					$("#country_error_messages").text(response['country']);
					$("#country").addClass('et_contact_error');
				}else{
					$("#country_error_messages").text(blank);
					$("#country").removeClass('et_contact_error');
				}

				if(response['state']){
					valid = false;
					$("#state_id_error_messages").text(response['state']);
					$("#state").addClass('et_contact_error');
				}else{
					$("#state_id_error_messages").text(blank);
					$("#state").removeClass('et_contact_error');
				}
				if(response['city']){
					valid = false;
					$("#city_error_messages").text(response['city']);
					$("#city").addClass('et_contact_error');
				}else{
					$("#city_error_messages").text(blank);
					$("#city").removeClass('et_contact_error');
				}

				if(response['postal_code']){
					valid = false;
					$("#postal_code_error_messages").text(response['postal_code']);
					$("#postal_code").addClass('et_contact_error');
				}else{
					$("#postal_code_error_messages").text(blank);
					$("#postal_code").removeClass('et_contact_error');
				}
				if(response['agreement_page_id']){
					valid = false;
					$("#agreement_page_id_error_messages").text(response['agreement_page_id']);
					$("#agreement_page_id").addClass('et_contact_error');
				}else{
					$("#agreement_page_id_error_messages").text(blank);
					$("#agreement_page_id").removeClass('et_contact_error');
				}
				if(response['recaptcha_value']){
					valid = false;
					$("#recaptcha_value_error_messages").text(response['recaptcha_value']);
					//$("#recaptcha_value").addClass('et_contact_error');
				}else{
					$("#recaptcha_value_error_messages").text(blank);
					//$("#recaptcha_value").removeClass('et_contact_error');
				}
				var recaptcha_value=$('#recaptcha_value').val();
				if(valid && recaptcha_value) {
					$('#recaptcha_value').val(1);
					$('#register_submit_button').removeAttr('disabled');
					$('#register_submit_button').removeClass('register_submit_button');
				}else{
					$('#valid_form').val(0);
					$('#register_submit_button').attr('disabled','disabled');
					$('#register_submit_button').addClass('register_submit_button');
				}

				
	
			}
		},
		error: function (e, response) {
			console.log("error");
		}
	});
};