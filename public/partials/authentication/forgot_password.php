<?php  ?> 
<?php 
?> 
<div class="et_pb_inner_shadow form_background">
<div class="et_pb_row et_pb_row_0">
<div class="et_pb_contact">

<?php if(!empty($errors)) { foreach($errors as $error) { ?>
    <span class="error_messages"><?php if(!empty($error[0])) { echo $error[0]; } ?></span><br>
<?php }} ?>  
<span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
<form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        
        <p class=" et_pb_contact_field ui-sortable">
            <label for="" class="et_pb_contact_form_label">Email</label>
            <input type="text" name="email"  class="input <?php if(!empty($errors['email'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="email" value="<?php if(!empty($_REQUEST['email'])) { echo $_REQUEST['email']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </p>
        <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_last">
        <?php wp_nonce_field("forgot_password","forgot_password_form"); ?>
		<button type="submit" class="et_pb_button" data-quickaccess-id="button">Submit</button>
        </p>
    </form>
</div>
</div>
</div>