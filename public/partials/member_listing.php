<?php
?>
<style>
    .et_pb_row {
    width: 80% !important;
    max-width: 100% !important;
}
</style>
<div class="main">
  <div class="column col-1 vertical-menu">
    <p style="margin-right: 10px;
    width: 200px;"><a href="<?php echo home_url('member-dashboard'); ?>" class="<?php if (home_url($wp->request) == home_url() . '/member-dashboard' || home_url($wp->request) == home_url() . '/member-dashboard/member-info') {
                                                                      echo "active";
                                                                    } ?>"><img src="<?= DIR_URL; ?>/dashboard_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Dashboard</strong></a></p>
    <p style="margin-right: 10px;
    width: 200px;"><a href="<?php echo home_url('member-dashboard/profile/'); ?>" class="<?php if (home_url($wp->request) == home_url() . '/member-dashboard/profile') {
                                                                                echo "active";
                                                                              } ?>"><img src="<?= DIR_URL; ?>/profile_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Profile</strong></a></p>
    <p style="margin-right: 10px;
    width: 200px;"><a href="<?php echo wp_logout_url('login'); ?>"><img src="<?= DIR_URL; ?>/logout_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Logout</strong></a></p>
  </div>
  <div class="column col-2">
    <?php
    if (home_url($wp->request) == home_url() . '/member-dashboard/profile') {
      do_action('profile_update');
    } elseif (home_url($wp->request) == home_url() . '/member-dashboard/member-info') {
      do_action('member_info');
    } elseif (home_url($wp->request) == home_url() . '/member-dashboard/change-password') {
      do_action('update_password');
    } elseif (home_url($wp->request) == home_url() . '/member-dashboard/transaction') {
      do_action('member_transaction');
    } else { ?>
      <div class="et_pb_inner_shadow form_background" style="width: 100%;background-color:#e4e7ed">
        <div class="et_pb_row et_pb_row_0">
          <div class="et_pb_contact">
            <form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET">
            <p class="et_pb_contact_field ui-sortable">
              <input type="text" name="global_search" style="width:100%" class="input" placeholder="Global Search..." value="<?php if(!empty($_GET['global_search'])) { echo $_REQUEST['global_search']; } ?>">
             </p>
            <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half search_member_listing">
                <label for="" class="">Country</label>
                <select name="country" id="country" onchange="getStates()" class="et_pb_contact_select input" placeholder="Country">
                  <option value="">Select Country</option>
                  <?php foreach ($countries as $country) { ?>
                    <option class="option_feild" value="<?= $country->country_type_id; ?>" <?php if (!empty($_GET['country']) && $_GET['country'] == $country->country_type_id) {
                                                                                            echo "selected";
                                                                                          } ?>> <?= $country->country; ?> </option>
                  <?php } ?>
                </select>
              </p>
              <input type="hidden" id="selected_state_id" value="<?php if (!empty($_GET['state'])) {echo $_GET['state'];} ?> ">
              <input type="hidden" id="selected_chapter_id" value="<?php if (!empty($_GET['chapter'])) {echo $_GET['chapter'];} ?> ">
              <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last search_member_listing">
                <label>State</label>
                <span id="state_input"></span>
                </select>
              </p>
              <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half search_member_listing">
                <label>Chapter</label>
                <span id="chapter_input"></span>
                </select>
              </p>
              <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last search_member_listing">
              <label>City</label>
              <input type="text" name="city"  class="input" placeholder="City" value="<?php if(!empty($_GET['city'])) { echo $_REQUEST['city']; } ?>">
             </p>
             <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last search_member_listing">
             <label><strong>Total Members : <?= $total ;?></strong></label>
                
            </p>
              <div class="et_contact_bottom_container">
                <button type="submit" class="et_pb_button" style="background-color: deepskyblue !important;margin-right:5px;" data-quickaccess-id="button"> <i class="fa fa-search"></i></button>
                <a class="et_pb_button" href="<?php echo home_url('member-dashboard'); ?>"> <i class="fa fa-refresh"></i></a>
              </div>

            </form>
          </div>
        </div>
      </div><br>
      <div class="hack1">
    <div class="hack2">
      <table class="table et_pb_with_background et_pb_inner_shadow price responsive-table">
        <thead class="thead">
          <tr class="et_pb_pricing_heading" style="background-color: deepskyblue;font-size:initial">
            <th class="text-center vertical_line" >Member ID</th>
            <th class="text-center vertical_line" >Name</th>
            <th class="text-center vertical_line" >Email</th>
            <th class="text-center vertical_line" >Join Date</th>
            <th class="text-center vertical_line" >State</th>
            <th class="text-center vertical_line" >City</th>
            <th class="text-center vertical_line" >Phone</th>
            <th class="text-center vertical_line" >Details</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rowcount > 0) {
            foreach ($rows as $member) { ?>
              <tr class="price" style="color: #000;">
                <td class="text-center vertical_line" ><?= $member->member_id; ?></td>
                <td class="text-center vertical_line" ><?= $member->first_name . ' ' . $member->last_name; ?></td>
                <td class="text-center vertical_line" ><?= $member->user_email; ?></td>
                <td class="text-center vertical_line" ><?= $member->user_registered; ?></td>
                <td class="text-center vertical_line" ><?= $member->state; ?></td>
                <td class="text-center vertical_line" ><?= $member->city; ?></td>
                <td class="text-center vertical_line" ><?= $member->phone_no; ?></td>
                <td class="text-center vertical_line" ><a href="<?php echo home_url('member-dashboard/member-info/?id='.$member->user_id); ?>"><i class="fa fa-eye" style="font-size:20px;color:deepskyblue"></i></a></td>
              </tr>
            <?php }
          } else { ?>
            <tr>
              <td colspan='7'>No records found</td>
            </tr>
          <?php  } ?>
        </tbody>

      </table>
          </div>
          </div>
      <?php

      $links = paginate_links(array(
        'base' => add_query_arg('pagenum', '%#%'),
        'format' => '',
        'prev_text' => __('&laquo;', 'text-domain'),
        'next_text' => __('&raquo;', 'text-domain'),
        'total' => $num_of_pages,
        'current' => $pagenum
      ));

      if ($links) {
        echo '<div class="" style="width: 99%;"><div class="" style="float:right;margin: 1em 0">'.$total.' Records found ' . $links . '</div></div>';
      }else{
        echo '<div class="" style="width: 99%;"><div class="" style="float:right;margin: 1em 0">'.$total.' Records found ' . $links . '</div></div>';
      }

      ?>

    <?php } ?>
  </div>