<?php  ?> 
<?php 
?> 
<div class="et_pb_inner_shadow form_background">
<div class="et_pb_row">
<div class="et_pb_contact">
<?php if (isset($_GET["forgot_password"])){  ?>
<div class="alert">
<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
<strong>Reset password link has been sent on your mail. Please reset and login using new password !</strong>
</div><br>
<?php }elseif(isset($_GET["password_updated"])){ ?>
<div class="alert">
<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
<strong>Password has been updated. Please login using new password !</strong>
</div><br>
<?php }elseif(isset($_GET["member_deactivated"])){ ?>
<div class="alert">
<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
<strong>Your account is deactivated !</strong>
</div><br>
<?php }elseif(isset($_GET["member_deceased"])){ ?>
<div class="alert">
<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
<strong>Your account is marked as Deceased !</strong>
</div><br>
<?php }elseif(isset($_GET["email_updated"])){ ?>
<div class="alert">
<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
<strong>Your email has been updated. Please login again !</strong>
</div><br>
<?php }  ?>
<?php if(!empty($errors)) { foreach($errors as $error) { ?>
    <span class="error_messages"><?php if(!empty($error[0])) { echo $error[0]; } ?></span><br>
<?php }} ?>  
<span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
<form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        
        <p class=" et_pb_contact_field ui-sortable">
            <label for="" class="et_pb_contact_form_label">Email</label>
            <input type="text" name="username"  class="input <?php if(!empty($errors['email'])) { echo "et_contact_error"; } ?>"  data-field_type="input" placeholder="Email" value="<?php if(!empty($_REQUEST['username'])) { echo $_REQUEST['username']; } ?>">
            <span class="error_messages"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </p>
        
        <p class="et_pb_contact_field ui-sortable">
            <label for="" class="et_pb_contact_form_label">Password</label>
            <input type="password" name="password"  class="input <?php if(!empty($errors['password'])) { echo "et_contact_error"; } ?>" data-required_mark="required" placeholder="Password" value="">
            <span class="error_messages"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
        </p>
        <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half" data-type="checkbox">
				<span class="et_pb_contact_field_options_wrapper">
						<span class="et_pb_contact_field_options_list"><span class="et_pb_contact_field_checkbox">
							<input type="checkbox" id="et_pb_contact_field_7_6_0" name="rememberme"class="input" value="yes">
							<label for="et_pb_contact_field_7_6_0"><i></i>Remember Me</label>
						</span></span>
				</span>
                <span class="error_messages"><?php if(!empty($errors['agree'])) { echo $errors['agree']; } ?></span>
		</p>
        <p class="et_pb_contact_field ui-sortable" data-type="checkbox">
        <a class="anchor_as_button" href="<?php echo home_url() . '/forgot-password';?>">Forgot password ?</a>
        <a class="anchor_as_button" href="<?php echo home_url() . '/become-a-member';?>" style="float:right">Become a member</a>
		</p>
		<button type="submit" class="et_pb_contact_submit et_pb_button" data-quickaccess-id="button">Login</button>
    </form>
</div>
</div>
</div>