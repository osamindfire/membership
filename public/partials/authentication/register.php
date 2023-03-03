<?php 
?> 
<div class="et_pb_inner_shadow form_background">
<div class="et_pb_row et_pb_row_0">
<div class="et_pb_contact">
    <form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">First Name</label>
            <input type="text" name="first_name"  class="input <?php if(!empty($errors['firstName'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="First Name" value="<?php if(!empty($_REQUEST['first_name'])) { echo $_REQUEST['first_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['firstName'])) { echo $errors['firstName']; } ?></span>
        </p>
        
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">Last Name</label>
            <input type="text" name="last_name"  class="input <?php if(!empty($errors['lastName'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Last Name" value="<?php if(!empty($_REQUEST['last_name'])) { echo $_REQUEST['last_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['lastName'])) { echo $errors['lastName']; } ?></span>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">Email</label>
            <input type="email" name="email"  class="input <?php if(!empty($errors['email'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Email" value="<?php if(!empty($_REQUEST['email'])) { echo $_REQUEST['email']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">Mobile No.</label>
            <input type="text" id="phone_no" name="primary_mobile_no"  class="input <?php if(!empty($errors['primaryMobileNo'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Format eg +1-XXX-XXX-XXXX" maxlength="15" oninput="this.value = this.value.replace(/[^0-9-+() ]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if(!empty($_REQUEST['primary_mobile_no'])) { echo $_REQUEST['primary_mobile_no']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['primaryMobileNo'])) { echo $errors['primaryMobileNo']; } ?></span>
        </p>
        
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">Password</label>
            <input type="password" name="password" class="input <?php if(!empty($errors['password'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Password" value="">
            <span class="error_messages"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">Confirm Password</label>
            <input type="password" name="confirm_password"  class="input <?php if(!empty($errors['confirmPassword'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Confirm Password" value="">
            <span class="error_messages"><?php if(!empty($errors['confirmPassword'])) { echo $errors['confirmPassword']; } ?></span>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="<?php if(!empty($errors['spouseFirstName'] || $_REQUEST['spouse_first_name'])) { echo 'required_field'; } ?>">Spouse First Name</label>
            <input type="text" name="spouse_first_name"  class="input <?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?>" data-required_mark="required" placeholder="Spouse First Name" value="<?php if(!empty($_REQUEST['spouse_first_name'])) { echo $_REQUEST['spouse_first_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="<?php if(!empty($errors['spouseFirstName'] || $_REQUEST['spouse_first_name'])) { echo 'required_field'; } ?>">Spouse Last Name</label>
            <input type="text" name="spouse_last_name"  class="input <?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?>" data-required_mark="required" placeholder="Spouse Last Name" value="<?php if(!empty($_REQUEST['spouse_last_name'])) { echo $_REQUEST['spouse_last_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?></span>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half" data-type="email">
            <label for="" class="<?php if(!empty($errors['spouseFirstName'] || $_REQUEST['spouse_first_name'])) { echo 'required_field'; } ?>">Spouse Email</label>
            <input type="email" name="spouse_email"  class="input <?php if(!empty($errors['spouseEmail'])) { echo "et_contact_error"; } ?>" data-required_mark="required"  data-field_type="email" placeholder="Spouse Email" value="<?php if(!empty($_REQUEST['spouse_email'])) { echo $_REQUEST['spouse_email']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseEmail'])) { echo $errors['spouseEmail']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Spouse Mobile No.</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9-+() ]/g, '').replace(/(\..*)\./g, '$1');"  name="secondary_mobile_no"  class="input" data-required_mark="required" placeholder="Format eg +1-XXX-XXX-XXXX" value="<?php if(!empty($_REQUEST['secondary_mobile_no'])) { echo $_REQUEST['secondary_mobile_no']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['secondaryMobileNo'])) { echo $errors['secondaryMobileNo']; } ?></span>
        </p>
        
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="<?php if(!empty($errors['spouseFirstName'] || $_REQUEST['spouse_first_name'])) { echo 'required_field'; } ?>">Spouse Password</label>
            <input type="password" name="spouse_password"  class="input <?php if(!empty($errors['spousePassword'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Spouse Password" value="">
            <span class="error_messages"><?php if(!empty($errors['spousePassword'])) { echo $errors['spousePassword']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="<?php if(!empty($errors['spouseFirstName'] || $_REQUEST['spouse_first_name'])) { echo 'required_field'; } ?>">Spouse Confirm Password</label>
            <input type="password" name="spouse_confirm_password"  class="input <?php if(!empty($errors['confirmSpousePassword'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Spouse Confirm Password" value="">
            <span class="error_messages"><?php if(!empty($errors['confirmSpousePassword'])) { echo $errors['confirmSpousePassword']; } ?></span>
        </p>

        <div class="input_fields_wrap">
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last"><a class="add_field_button add_child_button">Add Child</a></p>
    
        
        <?php foreach($_REQUEST['child_first_name'] as $index=>$childValues){ ?>
            <input type='hidden' name="child_id[<?= $key;?>]" value="<?= $_REQUEST['child_first_name'][$index];?>">
        <div> 
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">Child First Name</label>
            <input type="text" name="child_first_name[<?= $key;?>]"  class="input"  placeholder="Child First Name" value="<?php if(isset($_REQUEST['child_first_name'][$index])) { echo $_REQUEST['child_first_name'][$index]; } ?>">
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Child Last Name</label>
            <input type="text" name="child_last_name[<?= $key;?>]"  class="input" placeholder="Child Last Name" value="<?php if(isset($_REQUEST['child_last_name'][$index])) { echo $_REQUEST['child_last_name'][$index]; } ?>">
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last remove_child_text"><a href="#" class="remove_child">Remove</a></p>
        </div>
        <?php $key++;} ?>
        
        </div>
        
        <p class="et_pb_contact_field ui-sortable">
        <label for="" class="required_field">Address Line 1</label>
        <textarea name="address_line_1"  class="input <?php if(!empty($errors['addressLine1'])) { echo "et_contact_error"; } ?>" data-required_mark="required" data-field_type="text" placeholder="Address Line 1"><?php if(!empty($_REQUEST['address_line_1'])) { echo $_REQUEST['address_line_1']; } ?></textarea>
        <span class="error_messages"><?php if(!empty($errors['addressLine1'])) { echo $errors['addressLine1']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <label for="" class="et_pb_contact_form_label">Address Line 2</label>
        <textarea name="address_line_2"  class="input" data-required_mark="required" data-field_type="text" placeholder="Address Line 2"></textarea>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">Country</label>
            <select name="country" id="country" onchange="getstate()" class="et_pb_contact_select input <?php if(!empty($errors['country'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Country">
            <option value="">Select Country</option>
            <?php foreach($countries as $country) { ?> 
                <option class="option_feild" value="<?= $country->country_type_id;?>" <?php if(!empty($_REQUEST['country']) && $_REQUEST['country'] == $country->country_type_id ){ echo "selected";} ?> > <?= $country->country;?> </option>
            <?php } ?>
            </select>
            <span class="error_messages"><?php if(!empty($errors['country'])) { echo $errors['country']; } ?></span>
        </p>
        <input type="hidden" id="state_id" value="<?php if(!empty($_REQUEST['state'])) { echo $_REQUEST['state']; } ?> ">
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">State</label>
            <select name="state" id="state" class="et_pb_contact_select input" data-required_mark="required" placeholder="State">
            </select>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">City</label>
            <input type="text" name="city"  class="input <?php if(!empty($errors['city'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="City" value="<?php if(!empty($_REQUEST['city'])) { echo $_REQUEST['city']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['city'])) { echo $errors['city']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">Postal Code</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="postal_code" class="input <?php if(!empty($errors['postalCode'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Postal Code" value="<?php if(!empty($_REQUEST['postal_code'])) { echo $_REQUEST['postal_code']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['postalCode'])) { echo $errors['postalCode']; } ?></span>
        </p>
        
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last" data-type="checkbox">
				<span class="et_pb_contact_field_options_wrapper">
						<span class="et_pb_contact_field_options_list"><span class="et_pb_contact_field_checkbox">
							<input type="checkbox" id="agreement_page_id" name="agree"class="input" value="yes" <?php if(!empty($_REQUEST['agree']) && $_REQUEST['agree'] == 'yes') { echo 'checked'; } ?>>
							<label for="agreement_page_id"><i></i><a href="<?= home_url('agreement-page')?>" target="_blank">I acknowledge the Statement of Rights</a></''/span>
				</span>
                <span class="error_messages agreement_error"><?php if(!empty($errors['agree'])) { echo $errors['agree']; } ?></span>
                <span class="error_messages agreement_error">You must agree to Terms of Service</span>
		</p>
        <?php wp_nonce_field("register","register_form"); ?>
        <div style="margin-left:22px;transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" class="g-recaptcha" 
                data-sitekey="<?= GOOGLE_CAPTCHA_SITE_KEY ?>">
            </div>
        <span class="error_messages"><?php if(!empty($errors['googlecaptcha'])) { echo $errors['googlecaptcha']; } ?></span>
            
        <div class="et_contact_bottom_container">
		<button type="submit" id="register_submit_button" class="et_pb_button" data-quickaccess-id="button">Register</button>
		</div>

        
        </form>
</div>
</div>
</div>