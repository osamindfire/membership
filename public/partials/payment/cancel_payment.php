<?php
get_header();
?>


<div class="et_pb_with_background et_pb_inner_shadow">

	<div class="et_pb_row et_pb_row_0 et_pb_equal_columns">
		<div class="et_pb_column et_pb_column_1_2 et_pb_column_0  et_pb_css_mix_blend_mode_passthrough">
			<div class="et_pb_module et_pb_text et_pb_text_0  et_pb_text_align_left et_pb_bg_layout_light">
				<div class="et_pb_text_inner">
					<h2>Payment Failed !</h2>
				</div>
			</div>

			<div class="et_pb_module et_pb_text et_pb_text_2  et_pb_text_align_left et_pb_bg_layout_light">
				<div class="et_pb_text_inner">
					<p>Your PayPal Transaction has been Canceled </p>
				</div>
			</div>
			<div class="et_pb_button_module_wrapper et_pb_button_0_wrapper et_pb_button_alignment_left et_pb_module ">
				<a class="et_pb_button et_pb_button_0 et_pb_bg_layout_light" href="<?= home_url('membership'); ?>" data-icon="$">Try Again</a>
			</div>
		</div>
	</div>



	<?php get_footer(); ?>