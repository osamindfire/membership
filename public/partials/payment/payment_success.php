<?php ?>
<div class="et_pb_with_background et_pb_inner_shadow container price">
        <div class="paper-container">
                    <!-- <div class="success-icon">&#10004;</div> -->
                    <p style="text-align: center;"><i class="fa fa-check" style="font-size:70px;color:#32a852"></i><p>
                    <div class="success-title">
                        Payment Complete
                    </div>
                    
                    <div class="success-description">
                        Thank you for completing the payment! You will shortly receive an email of your payment.
                    </div>
                    <div class="order-details">
                        <div class="order-number-label">Payer ID</div>
                        <div class="order-number"><?php if (isset($_REQUEST['PayerID'])) {
                            echo $_REQUEST['PayerID'];
                        } ?></div>
                        <div class="order-number-label">Transaction ID: <?php echo isset($_REQUEST['txn_id']) ? $_REQUEST['txn_id'] : ''; ?></div>
                         <div class="order-number-label">Plan: <?php echo isset($membershipPackage[0]->membership) ? $membershipPackage[0]->membership : ''; ?></div>
                         <div class="order-number-label">Amount: $ <?php echo isset($membershipPackage[0]->fee) ? $membershipPackage[0]->fee : ''; ?></div>
                        <div class="complement order-number">Thank You! Please login to continue <a class="et_pb_button" href="<?= home_url() . '/login';?>">Login</a></div>
                    </div>
                <div class="jagged-edge"></div>
        </div>
    </div>