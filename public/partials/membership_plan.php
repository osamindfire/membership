<?php 
/* 
Template Name: Membership Plan 
*/  
global $wpdb, $user_ID;  
$membershipPlans= $wpdb->get_results( "SELECT * FROM wp_membership_type where status=1 " );

?>
<?php if (isset($_GET["register_success"])){  ?>
    <span class="success_flash">User has been registered successfully. Please select the membership plan !</span>
<?php } ?>
	      
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
                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                <input type="hidden" name="membershhip_type_id" value="<?= $plan->membership_type_id;?>" />
                <input type="hidden" name="item_number" value="123456" / >
                <input type="submit" name="submit" value="Submit Payment"/>
          </form>
           <!--  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="osaPayPal">
                <input name="business" type="hidden" value="treasurer@odishasociety.org">
                <input name="cmd" type="hidden" value="_xclick">
                <input name="item_name" type="hidden" value="Family (Life Member) - fees $99">
                <input name="amount" type="hidden" value="99">
                <input name="currency_code" type="hidden" value="USD">
                <input name="lc" type="hidden" value="US">
                <input alt="PayPal - The safer, easier way to pay online" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" style="border: 0;" type="image">&nbsp;
            </form> -->
          </td>
        </tr>
        <?php $sNo++;}?>
        <tr>
          <td><?= $sNo;?> </td>
          <td class="text-center">Other</td>
          <td class="text-center">
            <input data-ng-model="otherDescription" name="description" title="Description" type="text">
        </td>
        <td class="text-center">
            <input data-ng-model="otherAmount" min="1" name="other_amount" step="any" style="max-width: 70px" title="Other Amount" type="number" value="">
        </td>
          <td class="text-center">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="osaPayPal"><input name="business" type="hidden" value="treasurer@odishasociety.org">
                <input name="cmd" type="hidden" value="_xclick"><input name="item_name" type="hidden" value=" -- ">
                <input name="amount" type="hidden" value=""><input name="currency_code" type="hidden" value="USD">
                <input name="lc" type="hidden" value="US"><input alt="PayPal - The safer, easier way to pay online" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" style="border: 0;" type="image">&nbsp;
            </form>
          </td>
        </tr>
      </tbody>
    </table>			

