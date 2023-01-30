<?php 
?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
/* * {
    box-sizing: border-box;
}
body{
  height: 100vh;
  font-family: 'Poppins', sans-serif;
  
} */
.col-1{
  width: 20%;/* 
  background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
	background-size: 400% 400%;
	animation: gradient 15s ease infinite; */
}
.col-2{
  width: 80%;
  /* background-color:#ddd;
  box-shadow: 2px 0 0 2px #ddd; */
}
@keyframes gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}
.column {
    float: left;
    padding: 10px 0 0 10px;
    height: auto; 
}
/* Mobile responsive */
@media screen and (max-width: 600px) {
    .column {
        width: 100%;
    }
}
  </style>
<div class="main">
  <div class="column col-1 vertical-menu">
    <p><a href="<?php echo home_url('member-dashboard'); ?>" class="<?php if(home_url($wp->request) == home_url() . '/member-dashboard'){ echo "active";}?>"><img src="<?= DIR_URL; ?>/dashboard_icon.png" style="width:36px;margin-bottom: -11px;"/> Dashboard</a></p>
    <p><a href="<?php echo home_url('member-dashboard/profile/'); ?>" class="<?php if(home_url($wp->request) == home_url() . '/member-dashboard/profile'){ echo "active";}?>"><img src="<?= DIR_URL; ?>/profile_icon.png" style="width:36px;margin-bottom: -11px;"/> Profile</a></p>
    <p><a href="<?php echo home_url('member-dashboard/transaction/'); ?>" class="<?php if(home_url($wp->request) == home_url() . '/member-dashboard/transaction'){ echo "active";}?>"><img src="<?= DIR_URL; ?>/transaction_icon.png" style="width:36px;margin-bottom: -11px;"/> Transaction</a></p>
    <p><a href="<?php echo wp_logout_url('login'); ?>"><img src="<?= DIR_URL; ?>/logout_icon.png" style="width:36px;margin-bottom: -11px;"/> Logout</a></p>
  </div>
  <div class="column col-2">
    <?php 
                            if (home_url($wp->request) == home_url() . '/member-dashboard/profile') {
                                do_action('profile_update');

                            }elseif (home_url($wp->request) == home_url() . '/member-dashboard/member-info') {
                                do_action('member_info');

                          }else { ?>

                                <table class="table et_pb_with_background et_pb_inner_shadow price" style="width: auto">
                                <thead class="thead">
                                  <tr class="et_pb_pricing_heading">
                                  <th class="text-center vertical_line" width="10%">Member ID</th>
                                  <th class="text-center vertical_line" >Name</th>
                                  <th class="text-center vertical_line" >Join Date</th>
                                  <th class="text-center vertical_line" >Address</th>
                                  <th class="text-center vertical_line" >Phone</th>
                                  <th class="text-center vertical_line" >Status</th>
                                  <th class="text-center vertical_line">View Details</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php if($rowcount>0){ foreach($rows as $member){ ?>
                                  <tr class="price">
                                    <td class="text-center vertical_line"><?= $member->member_id; ?></td>
                                    <td class="text-center vertical_line"><?= $member->first_name.' '.$member->last_name; ?></td>
                                    <td class="text-center vertical_line"><?= $member->user_registered; ?></td>
                                    <td class="text-center vertical_line"><?= $member->address_line_1; ?></td>
                                    <td class="text-center vertical_line"><?= $member->primary_phone_no; ?></td>
                                    <td class="text-center vertical_line"><?= $member->membership; ?></td>
                                    <td class="text-center vertical_line"><a href="<?php echo home_url('member-dashboard/member-info/'); ?>"><i class="fa fa-eye"style="font-size:20px;color:deepskyblue"></i></a></td>
                                  </tr>
                                  <?php }}else{?>
                                    <tr><td colspan='7'>No records found</td></tr>
                                <?php  } ?>
                                  </tbody>
                                
                                  </table>
                                  <?php

                                    $links = paginate_links( array(
                                        'base' => add_query_arg( 'pagenum', '%#%' ),
                                        'format' => '',
                                        'prev_text' => __( '&laquo;', 'text-domain' ),
                                        'next_text' => __( '&raquo;', 'text-domain' ),
                                        'total' => $num_of_pages,
                                        'current' => $pagenum
                                    ) );

                                    if ( $links ) {
                                        echo '<div class="" style="width: 99%;">
                                              <div class="" style="margin: 1em 0">' . $links . '</div></div>';
                                    }

                                    ?>

                            <?php } ?>
</div>
                       