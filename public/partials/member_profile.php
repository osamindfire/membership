<?php //echo "<pre>";print_r($_REQUEST);die;
?> 

<div class="et_pb_inner_shadow form_background responsive-table">
<div class="et_pb_row et_pb_row_0">
<?php if (isset($_GET["success"])){  ?>
    <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Your profile has been updated successfully !</strong>
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
            <label for="" class="">First Name</label>
            <input type="text" name="first_name"  class="input <?php if(!empty($errors['firstName'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="First Name" value="<?php if(isset($_REQUEST['first_name'])) { echo $_REQUEST['first_name']; }else{ echo $userInfo[0]->first_name; } ?>">
            <span class="error_messages"><?php if(!empty($errors['firstName'])) { echo $errors['firstName']; } ?></span>
        </p>
        <input type='hidden' name="main_id" value="<?= $userInfo[0]->id;?>">
        <input type='hidden' name="other_id" value="<?= $userInfo['oth_member_info'][0]->id;?>">
        <input type='hidden' name="member_id" value="<?= $userInfo[0]->member_id;?>">
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Last Name</label>
            <input type="text" name="last_name"  class="input <?php if(!empty($errors['lastName'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Last Name" value="<?php if(isset($_REQUEST['last_name'])) { echo $_REQUEST['last_name']; }else{ echo $userInfo[0]->last_name; } ?>">
            <span class="error_messages"><?php if(!empty($errors['lastName'])) { echo $errors['lastName']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Email</label>
            <input type="text" name="email"  class="input <?php if(!empty($errors['email'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Last Name" value="<?php if(isset($_REQUEST['email'])) { echo $_REQUEST['email']; }else{ echo $userInfo[0]->user_email; } ?>" disabled>
            <span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">Primary Mobile No.</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="primary_phone_no"  class="input <?php if(!empty($errors['primaryMobileNo'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Primary Mobile No." value="<?php if(isset($_REQUEST['primary_phone_no'])) { echo $_REQUEST['primary_phone_no']; }else{ echo $userInfo[0]->primary_phone_no; }  ?>">
            <span class="error_messages"><?php if(!empty($errors['primaryMobileNo'])) { echo $errors['primaryMobileNo']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Secondary Mobile No.</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="secondary_phone_no"  class="input" data-required_mark="required" placeholder="Secondary Mobile No." value="<?php if(isset($_REQUEST['secondary_phone_no'])) { echo $_REQUEST['secondary_phone_no']; }else{ echo $userInfo[0]->secondary_phone_no; }  ?>">
        </p>
        <?php if(!empty($totalParent) && $totalParent > 1) { ?>
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">Partner First Name</label>
            <input type="text" name="spouse_first_name"  class="input <?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?>" data-required_mark="required" placeholder="Spouse First Name" value="<?php if(isset($_REQUEST['spouse_first_name'])) { echo $_REQUEST['spouse_first_name']; }else{ echo $userInfo['oth_member_info'][0]->first_name; }  ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseFirstName'])) { echo $errors['spouseFirstName']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Partner Last Name</label>
            <input type="text" name="spouse_last_name"  class="input <?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?>" data-required_mark="required" placeholder="Spouse Last Name" value="<?php if(isset($_REQUEST['spouse_last_name'])) { echo $_REQUEST['spouse_last_name']; }else{ echo $userInfo['oth_member_info'][0]->last_name; }  ?>">
            <span class="error_messages"><?php if(!empty($errors['spouseLastName'])) { echo $errors['spouseLastName']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Partner Email</label>
            <input type="text" name="spouse_last_name"  class="input <?php if(!empty($errors['spouseEmail'])) { echo $errors['spouseEmail']; } ?>" data-required_mark="required" placeholder="Spouse Email" value="<?php if(isset($_REQUEST['email'])) { echo $_REQUEST['email']; }else{ echo $userInfo['oth_member_info'][0]->user_email; } ?>" disabled>
            <span class="error_messages"><?php if(!empty($errors['spouseEmail'])) { echo $errors['spouseEmail']; } ?></span>
        </p>
           <?php } ?>     
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <label for="" class="">Address Line 1</label>
        <textarea name="address_line_1"  class="input" data-required_mark="required" data-field_type="text" placeholder="Address Line 1"><?php if(isset($_REQUEST['address_line_1'])) { echo $_REQUEST['address_line_1']; }else{ echo $userInfo[0]->address_line_1; }  ?></textarea>
        <span class="error_messages"><?php if(!empty($errors['addressLine1'])) { echo $errors['addressLine1']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <label for="" class="">Address Line 2</label>
        <textarea name="address_line_2"  class="input" data-required_mark="required" data-field_type="text" placeholder="Address Line 2"><?php if(isset($_REQUEST['address_line_2'])) { echo $_REQUEST['address_line_2']; }else{ echo $userInfo[0]->address_line_2; }  ?></textarea>
        </p>

        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">City</label>
            <input type="text" name="city"  class="input <?php if(!empty($errors['city'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="City" value="<?php if(isset($_REQUEST['city'])) { echo $_REQUEST['city']; }else{ echo $userInfo[0]->city; } ?>">
            <span class="error_messages"><?php if(!empty($errors['city'])) { echo $errors['city']; } ?></span>
        </p>
            
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="">Postal Code</label>
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="postal_code" class="input <?php if(!empty($errors['postalCode'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Postal Code" value="<?php if(isset($_REQUEST['postal_code'])) { echo $_REQUEST['postal_code']; } else{ echo $userInfo[0]->postal_code; }?>">
            <span class="error_messages"><?php if(!empty($errors['postalCode'])) { echo $errors['postalCode']; } ?></span>
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">Country</label>
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
            <label for="" class="">State</label>
            <select name="state" id="state" class="et_pb_contact_select input" data-required_mark="required" placeholder="State">
            </select>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="">Souvenir</label>
            <select name="souvenir" class="et_pb_contact_select input <?php if(!empty($errors['souvenir'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Souvenir">
            <option value="">Select Souvenir</option>
            <?php $souvenir_array = ['CD'=>'CD','PRINT'=>'PRINT'] ;foreach($souvenir_array as $souvenir_value) { ?> 
                <option class="option_feild" value="<?= $souvenir_value;?>" <?php if(isset($_REQUEST['souvenir']) && $_REQUEST['souvenir'] == $souvenir_value ){ echo "selected";}elseif( $userInfo[0]->souvenir == $souvenir_value){ echo "selected";} ?> > <?= $souvenir_value;?> </option>
            <?php } ?>
            </select>
            <span class="error_messages"><?php if(!empty($errors['country'])) { echo $errors['country']; } ?></span>
        </p>
        <?php if(!empty($totalParent) && $totalParent > 1) { ?>
        <?php $key = 1;foreach($userInfo['oth_member_info'] as $index=>$values){ if($values->type == 'child'){ ?>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half"><?= $key;?>
            <label for="" class="">Child First Name</label>
            <input type="text" name="child_first_name[<?= $key;?>]"  class="input"  placeholder="Child First Name" value="<?php if(isset($_REQUEST['child_first_name'][$index])) { echo $_REQUEST['child_first_name'][$index]; }else{ echo $userInfo['oth_member_info'][$index]->first_name;} ?>">
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last"><?= $key;?>
            <label for="" class="">Child Last Name</label>
            <input type="text" name="child_last_name[<?= $key;?>]"  class="input" placeholder="Child Last Name" value="<?php if(isset($_REQUEST['child_last_name'][$index])) { echo $_REQUEST['child_last_name'][$index]; }else{ echo $userInfo['oth_member_info'][$index]->last_name;} ?>">
        </p>
        <input type='hidden' name="child_id[<?= $key;?>]" value="<?= $userInfo['oth_member_info'][$index]->id;?>">
        <?php $key++;}} ?>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half"><?= $key;?>
            <label for="" class="">Child First Name</label>
            <input type="text" name="child_first_name[<?= $key;?>]"  class="input"  placeholder="Child First Name" value="<?php if(isset($_REQUEST['child_first_name'][$key])) { echo $_REQUEST['child_first_name'][$key]; } ?>">
        </p>

        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last"><?= $key;?>
            <label for="" class="">Child Last Name</label>
            <input type="text" name="child_last_name[<?= $key;?>]"  class="input" placeholder="Child Last Name" value="<?php if(isset($_REQUEST['child_last_name'][$key])) { echo $_REQUEST['child_last_name'][$key]; } ?>">
        </p>
        <input type='hidden' name="child_id[<?= $key;?>]" value="">
        <?php } ?>
        <?php wp_nonce_field("register","register_form"); ?>
        <div class="et_contact_bottom_container">
		<button type="submit" class="et_pb_button" data-quickaccess-id="button">Update</button>
		</div>

        
        </form>
</div>
</div>
</div>