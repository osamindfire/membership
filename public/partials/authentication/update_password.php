<?php
//print_r($errors);die;
?> 
<div class="et_pb_inner_shadow form_background">
<div class="et_pb_row et_pb_row_0">
<div class="et_pb_contact">

<form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">Current Password</label>
            <input type="text" name="old_password"  class="input <?php if(!empty($errors['old_password'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="Current Password" value="<?php if(!empty($_REQUEST['old_password'])) { echo $_REQUEST['old_password']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['old_password'])) { echo $errors['old_password']; } ?></span>
        </p>
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
            <label for="" class="et_pb_contact_form_label">New Password</label>
            <input type="text" name="new_password"  class="input <?php if(!empty($errors['new_password'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="New Password" value="<?php if(!empty($_REQUEST['new_password'])) { echo $_REQUEST['new_password']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['new_password'])) { echo $errors['new_password']; } ?></span>
        </p>
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
            <label for="" class="et_pb_contact_form_label">Confirm New Password</label>
            <input type="text" name="confirm_password"  class="input <?php if(!empty($errors['confirm_password'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="Confirm New Password" value="<?php if(!empty($_REQUEST['confirm_password'])) { echo $_REQUEST['confirm_password']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['confirm_password'])) { echo $errors['confirm_password']; } ?></span>
        </p>
        <?php wp_nonce_field("update_password","update_password_form"); ?>
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half">
		<button type="submit" class="et_pb_button" data-quickaccess-id="button">Update</button>
		</p>
    </form>
</div>
</div>
</div>