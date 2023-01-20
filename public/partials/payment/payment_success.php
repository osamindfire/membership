<?php
get_header();
?>

<div class="et_pb_with_background et_pb_inner_shadow container">
   
        <div class="paper-container">
            

            <div class="paper">
                <div class="main-contents">
                    <div class="success-icon">&#10004;</div>
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
                        <div class="complement">Thank You!</div>
                    </div>
                </div>
                <div class="jagged-edge"></div>
            </div>
        </div>
    </div>

	<?php get_footer(); ?>