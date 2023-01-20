<?php
get_header();
?>

<?php
get_header();
?>

<div class="et_pb_with_background et_pb_inner_shadow container">
   
        <div class="paper-container">
            

            <div class="paper">
                <div class="main-contents">
                    <div class="failed-icon">!</div>
                    <div class="success-title">
                        Payment Failed !
                    </div>
                    <div class="success-description">
					Your PayPal Transaction has been Canceled !
                    </div>
                    <div class="order-details">
						<?php if(!empty($_SESSION['user_id'])){ ?>
						<a class="et_pb_button et_pb_button_0 et_pb_bg_layout_light" href="<?= home_url('membership'); ?>" data-icon="$">Try Again</a>
						<?php } ?>
                    </div>
                </div>
				
                <div class="jagged-edge">
				</div>
            </div>
        </div>
		
    </div>


	<?php get_footer(); ?>