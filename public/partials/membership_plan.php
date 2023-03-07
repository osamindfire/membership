<?php if (isset($_GET["register_success"])){  ?>
  <div class="alert" style="background-color: #003772 !important;">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Member has been registered successfully. Please select the membership plan !</strong>
  </div>
<?php }elseif(isset($_GET["membership_expired"])){ ?>
  <div class="alert" style="background-color: #003772 !important;">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Your membership has expired. Please renew the membership plan !</strong>
  </div>
<?php }elseif(isset($_GET["no_membership_plan"])){ ?>
  <div class="alert" style="background-color: #003772 !important;">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Please buy membership plan then you will be able to search other Odia members and manage several activities with this access !</strong>
  </div>

<?php } ?>
<br><!-- #04AA6D -->
<div class="alert" style="background-color:#04AA6D!important;font-style:italic">
  <strong>For Credit Card/PayPal payment, select a membership plan below and proceed.<br>
  For Zelle, send the payment to treasurer@odishascociety.org, make sure to mention your email address that you used to register as a member.<br>
  For cash, mail a check to the OSA treasurer at the address mentioned <a style="color:yellow" href="<?= home_url('contact-us');?>">here</a>, payable to "Odisha Society of Americas"</strong>
  </div>
<?php if (is_user_logged_in()) { ?>
<div style="float:unset;padding:30px;">
<a href="<?php echo wp_logout_url('login'); ?>"><img src="<?= DIR_URL; ?>/logout_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Logout</strong></a></p>
</div>
<?php } ?>
<?php $sNo=1; foreach($membershipPlans as $plan) { ;?>
<div class="columns">
<table class="et_pb_with_background et_pb_inner_shadow price">
      <thead>
        <tr class="et_pb_pricing_heading">
        <td class="text-center header" style="height:61px !important;background-color:#fff;color:black;">
          <?php if($plan->type == 1) { echo "Single"; }elseif($plan->type == 2){ echo "Family";} ?> 
          <?= $plan->membership;?> </strong>
        </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center" style="background-color:#fff"><h1><strong>$<?= $plan->fee; ?></strong></h1></td>
        </tr>
        <tr>
          <td class="text-center" style="background-color:#fff">
          <img src="<?= DIR_URL; ?>/plan.png" style="width:100px;"/>
          <form class="paypal" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="no_note" value="1" />
                <input type="hidden" name="lc" value="US" />
                <input type="hidden" name="bn" value="DesignerFotos_BuyNow_WPS_US" />
                <input type="hidden" name="membershhip_type_id" value="<?= $plan->membership_type_id;?>" />
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="rm" value="2">
                <button type="submit" class="et_pb_button" name="submit" style="background-color:#003772!important">Pay Now</button>
          </form>
          </td>
        </tr>

      </tbody>
    </table>	
</div>

<?php $sNo++;}?>
