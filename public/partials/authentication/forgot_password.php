<?php if(!empty($_GET['invalid_link'])) { ?>
<div class="alert" style="background-color:#d91313">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?= 'Invalid password reset link. Please create link again !'; ?></strong>
  </div>
  <?php } ?>

<div class="et_pb_inner_shadow form_background">
<div class="et_pb_row et_pb_row_0">
<div class="et_pb_contact">

<form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        
        <p class=" et_pb_contact_field ui-sortable">
            <label for="" class="et_pb_contact_form_label">Email</label>
            <input type="text" name="email"  class="input <?php if(!empty($errors['email'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="email" value="<?php if(!empty($_REQUEST['email'])) { echo $_REQUEST['email']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </p>
        <div  style="margin-left:22px; transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" class="g-recaptcha" 
                data-sitekey="<?= GOOGLE_CAPTCHA_SITE_KEY ?>">
        </div>
        <span class="error_messages"><?php if(!empty($errors['googlecaptcha'])) { echo $errors['googlecaptcha']; } ?></span>
        <?php wp_nonce_field("forgot_password","forgot_password_form"); ?>
        <div class="et_contact_bottom_container">
		<button type="submit" class="et_pb_button" data-quickaccess-id="button">Submit</button>
		</div>

    </form>
</div>
</div>
</div>