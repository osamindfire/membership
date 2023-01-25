<?php 
?> 

<div class="et_pb_inner_shadow form_background">
<div class="et_pb_row et_pb_row_0">
<div class="et_pb_contact">
    <form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">First Name</label>
            <input type="text" name="first_name"  class="input <?php if(!empty($errors['firstName'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="First Name" value="<?php if(!empty($_REQUEST['first_name'])) { echo $_REQUEST['first_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['firstName'])) { echo $errors['firstName']; } ?></span>
        </p>
        
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="et_pb_contact_form_label">Last Name</label>
            <input type="text" name="last_name"  class="input <?php if(!empty($errors['lastName'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Last Name" value="<?php if(!empty($_REQUEST['last_name'])) { echo $_REQUEST['last_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['lastName'])) { echo $errors['lastName']; } ?></span>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">Primary Mobile No.</label>
            <input type="text" name="primary_mobile_no"  class="input <?php if(!empty($errors['primaryMobileNo'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Primary Mobile No." value="<?php if(!empty($_REQUEST['primary_mobile_no'])) { echo $_REQUEST['primary_mobile_no']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['primaryMobileNo'])) { echo $errors['primaryMobileNo']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="et_pb_contact_form_label">Secondary Mobile No.</label>
            <input type="text" name="primary_mobile_no"  class="input <?php if(!empty($errors['primaryMobileNo'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Secondary Mobile No." value="<?php if(!empty($_REQUEST['primary_mobile_no'])) { echo $_REQUEST['primary_mobile_no']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['primaryMobileNo'])) { echo $errors['primaryMobileNo']; } ?></span>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">Spouse First Name</label>
            <input type="text" name="spouse_first_name"  class="input <?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?>" data-required_mark="required" placeholder="Spouse First Name" value="<?php if(!empty($_REQUEST['spouse_first_name'])) { echo $_REQUEST['spouse_first_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="et_pb_contact_form_label">Spouse Last Name</label>
            <input type="text" name="spouse_last_name"  class="input <?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?>" data-required_mark="required" placeholder="Spouse Last Name" value="<?php if(!empty($_REQUEST['spouse_last_name'])) { echo $_REQUEST['spouse_last_name']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?></span>
        </p>
                
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <label for="" class="et_pb_contact_form_label">Address Line 1</label>
        <textarea name="address_line_1"  class="input" data-required_mark="required" data-field_type="text" placeholder="Address Line 1"><?php if(!empty($_REQUEST['address_line_1'])) { echo $_REQUEST['address_line_1']; } ?></textarea>
        <span class="error_messages"><?php if(!empty($errors['addressLine1'])) { echo $errors['addressLine1']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <label for="" class="et_pb_contact_form_label">Address Line 2</label>
        <textarea name="address_line_2"  class="input" data-required_mark="required" data-field_type="text" placeholder="Address Line 2"></textarea>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">City</label>
            <input type="text" name="city"  class="input <?php if(!empty($errors['city'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="City" value="<?php if(!empty($_REQUEST['city'])) { echo $_REQUEST['city']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['city'])) { echo $errors['city']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="et_pb_contact_form_label">Postal Code</label>
            <input type="text" name="postal_code" class="input <?php if(!empty($errors['postalCode'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Postal Code" value="<?php if(!empty($_REQUEST['postal_code'])) { echo $_REQUEST['postal_code']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['postalCode'])) { echo $errors['postalCode']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">Country</label>
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
            <label for="" class="et_pb_contact_form_label">State</label>
            <select name="state" id="state" class="et_pb_contact_select input" data-required_mark="required" placeholder="State">
            </select>
        </p>
        
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">Child First Name</label>
            <input type="text" name="child_first_name"  class="input"  placeholder="Child First Name" value="<?php if(!empty($_REQUEST['child_first_name'])) { echo $_REQUEST['child_first_name']; } ?>">
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="et_pb_contact_form_label">Child Last Name</label>
            <input type="text" name="child_last_name"  class="input" placeholder="Child Last Name" value="<?php if(!empty($_REQUEST['child_last_name'])) { echo $_REQUEST['child_last_name']; } ?>">
        </p>
        <?php wp_nonce_field("register","register_form"); ?>
        <div class="et_contact_bottom_container">
		<button type="submit" class="et_pb_button" data-quickaccess-id="button">Update</button>
		</div>

        
        </form>
</div>
</div>
</div>