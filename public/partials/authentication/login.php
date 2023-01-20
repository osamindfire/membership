<?php  ?> 
<div class="et_pb_inner_shadow et_pb_row et_pb_row_0">
<div class="et_pb_contact">
<?php if(!empty($errors)) { foreach($errors as $error) { ?>
    <span class="error_messages"><?php if(!empty($error[0])) { echo $error[0]; } ?></span><br>
<?php }} ?>  
<span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    <form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        
        <p class=" et_pb_contact_field ui-sortable">
            <label for="" class="et_pb_contact_form_label">Username</label>
            <input type="text" name="username"  class="input <?php if(!empty($errors['email'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="Username" value="<?php if(!empty($_REQUEST['username'])) { echo $_REQUEST['username']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </p>
        
        <p class="et_pb_contact_field ui-sortable">
            <label for="" class="et_pb_contact_form_label">Password</label>
            <input type="password" name="password"  class="input <?php if(!empty($errors['password'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Password" value="">
            <span class="error_messages"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_last" data-type="checkbox">
				<span class="et_pb_contact_field_options_wrapper">
						<span class="et_pb_contact_field_options_list"><span class="et_pb_contact_field_checkbox">
							<input type="checkbox" id="et_pb_contact_field_7_6_0" name="rememberme"class="input" value="yes">
							<label for="et_pb_contact_field_7_6_0"><i></i>Remember Me</label>
						</span></span>
				</span>
                <span class="error_messages"><?php if(!empty($errors['agree'])) { echo $errors['agree']; } ?></span>
		</p>
		<button type="submit" class="et_pb_contact_submit et_pb_button" data-quickaccess-id="button">Login</button>
    </form>
</div>
</div>