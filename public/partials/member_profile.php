<?php
$partnerCount= count($userInfo['oth_member_info']);
?> 

<div class="et_pb_inner_shadow form_background responsive-table">
<div class="et_pb_row et_pb_row_0">
<?php if (isset($_GET["success"])){  ?>
    <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Your profile has been updated successfully !</strong>
  </div><br>
<?php } ?>
<?php if (isset($userInfo[0]->partner_exist) && $userInfo[0]->partner_exist == 0 && !empty($userInfo[0]->family_plan)){  ?>
    <div class="alert" style="background-color: #000;">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Note: No data found for Partner.You can also create partner account ! </strong>
  </div><br>
<?php } ?>
<div class="et_pb_contact">
<p><a style="float:left; margin-bottom:50px;" href="<?php echo home_url('member-dashboard/transaction/'); ?>" class="active"><img src="<?= DIR_URL; ?>/membership_profile_icon.png" style="width:36px;margin-bottom: -11px;"/> <strong> <?= $userInfo[0]->membership;?></strong></a>
<a style="float:right;margin-bottom:50px;" href="<?php echo home_url('member-dashboard/change-password/'); ?>" class="active"><img src="<?= DIR_URL; ?>/change_password.png" style="width:36px;margin-bottom: -11px;"/> <strong>Change Password</strong></a></p>

<form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
        <strong>Member ID:</strong> <?= $userInfo['oth_member_info'][0]->member_id;?>
        </p>
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">First Name</label>
            <input type="text" name="first_name"  class="input <?php if(!empty($errors['firstName'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="First Name" value="<?php if(isset($_REQUEST['first_name'])) { echo $_REQUEST['first_name']; }else{ echo $userInfo[0]->first_name; } ?>">
            <span class="error_messages"><?php if(!empty($errors['firstName'])) { echo $errors['firstName']; } ?></span>
        </p>
        <input type='hidden' name="main_id" value="<?= $userInfo[0]->id;?>">
        <input type='hidden' name="parent_id" value="<?= $userInfo[0]->parent_id;?>">
        <input type='hidden' name="other_id" value="<?= $userInfo['oth_member_info'][0]->id;?>">
        <input type='hidden' name="member_id" value="<?= $userInfo[0]->member_id;?>">
        <input type='hidden' name="partner_exist" value="<?= $userInfo[0]->partner_exist;?>">
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">Last Name</label>
            <input type="text" name="last_name"  class="input <?php if(!empty($errors['lastName'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Last Name" value="<?php if(isset($_REQUEST['last_name'])) { echo $_REQUEST['last_name']; }else{ echo $userInfo[0]->last_name; } ?>">
            <span class="error_messages"><?php if(!empty($errors['lastName'])) { echo $errors['lastName']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">Email</label>
            <input type="text" name="email"  class="input <?php if(!empty($errors['email'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Last Name" value="<?php if(isset($_REQUEST['email'])) { echo $_REQUEST['email']; }else{ echo $userInfo[0]->user_email; } ?>" disabled>
            <span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="<?php if(empty($userInfo[0]->parent_id)) { echo "required_field"; } ?>">Mobile No.</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9-+() ]/g, '').replace(/(\..*)\./g, '$1');" name="main_member_phone_no"  class="input <?php if(!empty($errors['mainMemberMobileNo'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Mobile No." value="<?php if(isset($_REQUEST['main_member_phone_no'])) { echo $_REQUEST['main_member_phone_no']; }else{ echo $userInfo[0]->main_member_phone; }  ?>">
            <span class="error_messages"><?php if(!empty($errors['mainMemberMobileNo'])) { echo $errors['mainMemberMobileNo']; } ?></span>
        </p>
        <?php if(!empty($userInfo[0]->family_plan)) { ?>
            
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="<?php if($userInfo[0]->partner_exist == 1 || !empty($_REQUEST['spouse_first_name']) ){ echo "required_field";}?>">Partner First Name</label>
            <input type="text" name="spouse_first_name"  class="input <?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?>" data-required_mark="required" placeholder="Partner First Name" value="<?php if(isset($_REQUEST['spouse_first_name'])) { echo $_REQUEST['spouse_first_name']; }else{ echo $userInfo['oth_member_info'][0]->first_name; }  ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="<?php if($userInfo[0]->partner_exist == 1 || !empty($_REQUEST['spouse_first_name']) ){ echo "required_field";}?>">Partner Last Name</label>
            <input type="text" name="spouse_last_name"  class="input <?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?>" data-required_mark="required" placeholder="Partner Last Name" value="<?php if(isset($_REQUEST['spouse_last_name'])) { echo $_REQUEST['spouse_last_name']; }else{ echo $userInfo['oth_member_info'][0]->last_name; }  ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="<?php if($userInfo[0]->partner_exist == 1 || !empty($_REQUEST['spouse_first_name']) ){ echo "required_field";}?>">Partner Email</label>
            <input type="text" name="spouse_email"  class="input <?php if(!empty($errors['spouseEmail'])) { echo $errors['spouseEmail']; } ?>" data-required_mark="required" placeholder="Spouse Email" value="<?php if(isset($_REQUEST['spouse_email'])) { echo $_REQUEST['spouse_email']; }else{ echo $userInfo['oth_member_info'][0]->user_email; } ?>" <?php if(!empty($userInfo['oth_member_info'][0]->user_email && $partnerCount == 1 )) { echo "disabled";}?> >
            <span class="error_messages"><?php if(!empty($errors['spouseEmail'])) { echo $errors['spouseEmail']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="<?php if(empty($userInfo['oth_member_info'][0]->parent_id) && count($userInfo['oth_member_info']) >= 1) { echo "required_field"; } ?>">Partner Mobile No.</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9-+() ]/g, '').replace(/(\..*)\./g, '$1');" name="partner_phone_no"  class="input <?php if(!empty($errors['partnerPhoneNo'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Partner Mobile No." value="<?php if(isset($_REQUEST['partner_phone_no'])) { echo $_REQUEST['partner_phone_no']; }else{ echo $userInfo['oth_member_info'][0]->partner_member_phone; }  ?>">
            <span class="error_messages"><?php if(!empty($errors['partnerPhoneNo'])) { echo $errors['partnerPhoneNo']; } ?></span>
        </p>
        <?php if(count($userInfo['oth_member_info'][0]) == 0){ ?>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="<?php if($userInfo[0]->partner_exist == 1 || !empty($_REQUEST['spouse_first_name'])){ echo "required_field";}?>">Spouse Password</label>
            <input type="text" name="spouse_password"  class="input <?php if(!empty($errors['spousePassword'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Spouse Password" value="<?php if(isset($_REQUEST['spouse_password'])) { echo $_REQUEST['spouse_password']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['spousePassword'])) { echo $errors['spousePassword']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="<?php if($userInfo[0]->partner_exist == 1 || !empty($_REQUEST['spouse_first_name'])){ echo "required_field";}?>">Spouse Confirm Password</label>
            <input type="text" name="spouse_confirm_password"  class="input <?php if(!empty($errors['confirmSpousePassword'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Spouse Confirm Password" value="<?php if(isset($_REQUEST['spouse_confirm_password'])) { echo $_REQUEST['spouse_confirm_password']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['confirmSpousePassword'])) { echo $errors['confirmSpousePassword']; } ?></span>
        </p>
        <?php } ?>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="<?php if($userInfo[0]->partner_exist == 1 || !empty($_REQUEST['spouse_first_name'])){ echo "required_field";}?>">Partner Status</label>
            <select name="partner_alive" class="et_pb_contact_select input <?php if(!empty($errors['alive'])) { echo "alive"; } ?>" data-required_mark="required" placeholder="">
            <?php if(count($userInfo['oth_member_info']) >= 1) { $status_array = ['1'=>'Alive','0'=>'Deceased'];}else{ $status_array = ['1'=>'Alive']; } ;?>
            <?php foreach($status_array as $status_key=>$status_value) { ?> 
                <option class="option_feild" value="<?= $status_key;?>" <?php if(isset($_REQUEST['alive']) && $_REQUEST['alive'] == $status_value ){ echo "selected";}elseif( $userInfo['oth_member_info'][0]->alive == $status_key){ echo "selected";} ?> > <?= $status_value;?> </option>
            <?php } ?>
            </select>
            <span class="error_messages"><?php if(!empty($errors['country'])) { echo $errors['country']; } ?></span>
        </p>
           <?php } ?>     
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <label for="" class="required_field">Address Line 1</label>
        <textarea name="address_line_1"  class="input" data-required_mark="required" data-field_type="text" placeholder="Address Line 1"><?php if(isset($_REQUEST['address_line_1'])) { echo $_REQUEST['address_line_1']; }else{ echo $userInfo[0]->address_line_1; }  ?></textarea>
        <span class="error_messages"><?php if(!empty($errors['addressLine1'])) { echo $errors['addressLine1']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <label for="" class="">Address Line 2</label>
        <textarea name="address_line_2"  class="input" data-required_mark="required" data-field_type="text" placeholder="Address Line 2"><?php if(isset($_REQUEST['address_line_2'])) { echo $_REQUEST['address_line_2']; }else{ echo $userInfo[0]->address_line_2; }  ?></textarea>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">City</label>
            <input type="text" name="city"  class="input <?php if(!empty($errors['city'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="City" value="<?php if(isset($_REQUEST['city'])) { echo $_REQUEST['city']; }else{ echo $userInfo[0]->city; } ?>">
            <span class="error_messages"><?php if(!empty($errors['city'])) { echo $errors['city']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">Postal Code</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="postal_code" class="input <?php if(!empty($errors['postalCode'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Postal Code" value="<?php if(isset($_REQUEST['postal_code'])) { echo $_REQUEST['postal_code']; } else{ echo $userInfo[0]->postal_code; }?>">
            <span class="error_messages"><?php if(!empty($errors['postalCode'])) { echo $errors['postalCode']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="required_field">Country</label>
            <select name="country" id="country" onchange="getstate()" class="et_pb_contact_select input <?php if(!empty($errors['country'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Country">
            <option value="">Select Country</option>
            <?php foreach($countries as $country) { ?> 
                <option class="option_feild" value="<?= $country->country_type_id;?>" <?php if(isset($_REQUEST['country']) && $_REQUEST['country'] == $country->country_type_id ){ echo "selected";}elseif( $userInfo[0]->country_id == $country->country_type_id){ echo "selected";} ?> > <?= $country->country;?> </option>
            <?php } ?>
            </select>
            <span class="error_messages"><?php if(!empty($errors['country'])) { echo $errors['country']; } ?></span>
        </p>
        <input type="hidden" id="state_id" value="<?php if(isset($_REQUEST['state'])) { echo $_REQUEST['state']; }else{ echo $userInfo[0]->state_id;} ?> ">
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">State</label>
            <select name="state" id="state" class="et_pb_contact_select input" data-required_mark="required" placeholder="State">
            </select>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">Chapter</label>
            <input type="text" class="input" readonly= true value="<?php if(isset($userInfo[0]->chapter)) { echo $userInfo[0]->chapter; }else{ echo "N/A";} ?>">
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="required_field">Souvenir</label>
            <select name="souvenir" class="et_pb_contact_select input <?php if(!empty($errors['souvenir'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Souvenir">
            <option value="">Select Souvenir</option>
            <?php $souvenir_array = ['CD'=>'CD','PRINT'=>'PRINT'] ;foreach($souvenir_array as $souvenir_value) { ?> 
                <option class="option_feild" value="<?= $souvenir_value;?>" <?php if(isset($_REQUEST['souvenir']) && $_REQUEST['souvenir'] == $souvenir_value ){ echo "selected";}elseif( $userInfo[0]->souvenir == $souvenir_value){ echo "selected";} ?> > <?= $souvenir_value;?> </option>
            <?php } ?>
            </select>
            <span class="error_messages"><?php if(!empty($errors['country'])) { echo $errors['country']; } ?></span>
        </p>

        <?php if(!empty($userInfo[0]->family_plan)) { ?>
        <div class="input_fields_wrap">
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half"><a class="add_field_button add_child_button">Add Child</a></p>
    
        <?php $key = 1;foreach($userInfo['child_info'] as $index=>$values){ if($values->type == 'child'){ ?>
            <input type='hidden' name="child_id[<?= $key;?>]" value="<?= $userInfo['child_info'][$index]->id;?>">
        <div> 
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">Child First Name</label>
            <input type="text" name="child_first_name[<?= $key;?>]"  class="input"  placeholder="Child First Name" value="<?php if(isset($_REQUEST['child_first_name'][$index])) { echo $_REQUEST['child_first_name'][$index]; }else{ echo $userInfo['child_info'][$index]->first_name;} ?>">
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Child Last Name</label>
            <input type="text" name="child_last_name[<?= $key;?>]"  class="input" placeholder="Child Last Name" value="<?php if(isset($_REQUEST['child_last_name'][$index])) { echo $_REQUEST['child_last_name'][$index]; }else{ echo $userInfo['child_info'][$index]->last_name;} ?>">
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last remove_child_text"><a href="#" class="remove_child">Remove</a></p>
        </div>
        <?php $key++;}} ?>
        </div>
        <?php } ?>   
        <?php wp_nonce_field("register","register_form"); ?>
        <div class="et_contact_bottom_container">
		<button type="submit" class="et_pb_button" data-quickaccess-id="button">Update</button>
		</div>

        
        </form>
</div>
</div>
</div>