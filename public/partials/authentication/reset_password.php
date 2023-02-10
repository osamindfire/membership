<?php ?>
<div class="et_pb_inner_shadow form_background">
<div class="et_pb_row et_pb_row_0">
<div class="et_pb_contact">

<form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
        <label for="" class="et_pb_contact_form_label">New Password</label>
            <input type="text" name="new_password"  class="input <?php if(!empty($errors['new_password'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="New Password" value="<?php if(!empty($_REQUEST['new_password'])) { echo $_REQUEST['new_password']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['new_password'])) { echo $errors['new_password']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
        <label for="" class="et_pb_contact_form_label">Confirm New Password</label>
            <input type="text" name="confirm_password"  class="input <?php if(!empty($errors['confirm_password'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="Confirm New Password" value="<?php if(!empty($_REQUEST['confirm_password'])) { echo $_REQUEST['confirm_password']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['confirm_password'])) { echo $errors['confirm_password']; } ?></span>
        </p>
        <div  style="margin-bottom:50px;margin-left:30px;transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" class="g-recaptcha" 
                data-sitekey="<?= GOOGLE_CAPTCHA_SITE_KEY ?>">
        </div>
        <span class="error_messages"><?php if(!empty($errors['googlecaptcha'])) { echo $errors['googlecaptcha']; } ?></span>
        
        <?php wp_nonce_field("reset_password","reset_password_form"); ?>
        <div class="et_contact_bottom_container">
		<button type="submit" class="et_pb_button" data-quickaccess-id="button">Reset Password</button>
		</div>
    </form>
</div>
</div>
</div>