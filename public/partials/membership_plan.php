<?php if (isset($_GET["register_success"])){  ?>
  <h4 style="text-align: center;"><span class="success_flash">User has been registered successfully. Please select the membership plan !</span></h4>
<?php } ?>
<?php $sNo=1; foreach($membershipPlans as $plan) { ;?>
<div class="columns">
<table class="et_pb_with_background et_pb_inner_shadow price" style="width: 100%">
      <thead>
        <tr class="et_pb_pricing_heading">
        <td class="text-center header">
          <?php if($plan->type == 1) { echo "Single"; }elseif($plan->type == 2){ echo "Family";} ?> 
          <br><hr><strong> <?= $plan->membership;?> </strong>
        </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center"><h1>$ <?= $plan->fee; ?> (*)</h1></td>
        </tr>
        <tr>
          <td class="text-center">
          <form class="paypal" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="no_note" value="1" />
                <input type="hidden" name="lc" value="US" />
                <input type="hidden" name="bn" value="DesignerFotos_BuyNow_WPS_US" />
                <input type="hidden" name="membershhip_type_id" value="<?= $plan->membership_type_id;?>" />
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="rm" value="2">
                <button type="submit" class="et_pb_button" name="submit">Pay Now</button>
          </form>
          </td>
        </tr>

      </tbody>
    </table>	
</div>

<?php $sNo++;}?>
<!-- 
<table class="et_pb_with_background et_pb_inner_shadow" style="width: 100%">
      <thead>
        <tr class="et_pb_pricing_heading">
          <th style="text-align: left">&nbsp;</th>
          <th class="text-center">Type</th>
          <th class="text-center">Duration</th>
          <th class="text-center">Fee</th>
          <th class="text-center">Pay</th>
        </tr>
      </thead>
      <tbody>
        <?php $sNo=1; foreach($membershipPlans as $plan) { ;?>
        <tr>
          <td><?= $sNo; ?></td>
          <td class="text-center"><?php if($plan->type == 1) { echo "Single"; }elseif($plan->type == 2){ echo "Family";} ?></td>
          <td class="text-center"><?= $plan->membership; ?></td>
          <td class="text-center"><?= $plan->fee; ?> (*)</td>
          <td class="text-center">
          <form class="paypal" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="no_note" value="1" />
                <input type="hidden" name="lc" value="US" />
                <input type="hidden" name="bn" value="DesignerFotos_BuyNow_WPS_US" />
                <input type="hidden" name="membershhip_type_id" value="<?= $plan->membership_type_id;?>" />
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="rm" value="2">
                <input class="" alt="PayPal - The safer, easier way to pay online" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" style="border: 0;" type="image">
          </form>
          </td>
        </tr>
        <?php $sNo++;}?>

      </tbody>
    </table>			
 -->
