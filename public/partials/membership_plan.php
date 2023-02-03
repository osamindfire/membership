<?php if (isset($_GET["register_success"])){  ?>
  <h4 style="text-align: center;"><span class="success_flash">User has been registered successfully. Please select the membership plan !</span></h4>
<?php }elseif(isset($_GET["membership_expired"])){ ?>
  <h4 style="text-align: center;color:red !important;"><span class="success_flash">Your membership has expired. Please renew the membership plan !</span></h4>
<?php }elseif(isset($_GET["no_membership_plan"])){ ?>
  <h4 style="text-align: center;color:red !important;"><span class="success_flash">Please buy membership plan then you will be able to search other Odia members and manage several activities with this access !</span></h4>
<?php } ?>
<?php $sNo=1; foreach($membershipPlans as $plan) { ;?>
<div class="columns">
<table class="et_pb_with_background et_pb_inner_shadow price">
      <thead>
        <tr class="et_pb_pricing_heading">
        <td class="text-center header" style="background-color:#fff;color:black;">
          <?php if($plan->type == 1) { echo "Single"; }elseif($plan->type == 2){ echo "Family";} ?> 
          <hr><?= $plan->membership;?> </strong>
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
