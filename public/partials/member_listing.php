<?php
?>
<style>
</style>
<div class="main">
  <div class="column col-1 vertical-menu">
    <p><a href="<?php echo home_url('member-dashboard'); ?>" class="<?php if (home_url($wp->request) == home_url() . '/member-dashboard' || home_url($wp->request) == home_url() . '/member-dashboard/member-info') {
                                                                      echo "active";
                                                                    } ?>"><img src="<?= DIR_URL; ?>/dashboard_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Dashboard</strong></a></p>
    <p><a href="<?php echo home_url('member-dashboard/profile/'); ?>" class="<?php if (home_url($wp->request) == home_url() . '/member-dashboard/profile') {
                                                                                echo "active";
                                                                              } ?>"><img src="<?= DIR_URL; ?>/profile_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Profile</strong></a></p>
    <p><a href="<?php echo home_url('member-dashboard/transaction/'); ?>" class="<?php if (home_url($wp->request) == home_url() . '/member-dashboard/transaction') {
                                                                                    echo "active";
                                                                                  } ?>"><img src="<?= DIR_URL; ?>/transaction_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Transaction</strong></a></p>
    <p><a href="<?php echo wp_logout_url('login'); ?>"><img src="<?= DIR_URL; ?>/logout_icon.png" style="width:36px;margin-bottom: -11px;" /> <strong>Logout</strong></a></p>
    <br>
    <?php if (home_url($wp->request) == home_url() . '/member-dashboard') { ?>

    <div class="et_pb_inner_shadow form_background">
        <div class="et_pb_row et_pb_row_0">
          <div class="">
            <form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET">
            <div style="margin-bottom:30px;">
            <input type="text" name="global_search" placeholder="Global Search..." value="<?= isset($_GET['global_search']) ? $_GET['global_search'] : '' ?>">
            <button style="border:0px solid #fff;margin-top:4px;float:left;background-color:#04AA6D;color:#fff;cursor: pointer;">Search <i class="fa fa-search"></i></button>
            </div>  
            <p>
                <label>Country</label><br>
                <select class="filter_box" name="country" id="country" onchange="getStates()" placeholder="Country">
                  <option value="">Select Country</option>
                  <?php foreach ($countries as $country) { ?>
                    <option class="option_feild" value="<?= $country->country_type_id; ?>" <?php if (!empty($_GET['country']) && $_GET['country'] == $country->country_type_id) {
                                                                                            echo "selected";
                                                                                          } ?>> <?= $country->country; ?> </option>
                  <?php } ?>
                </select>
              <input type="hidden" id="selected_state_id" value="<?php if (!empty($_GET['state'])) {echo $_GET['state'];} ?> ">
              <input type="hidden" id="selected_chapter_id" value="<?php if (!empty($_GET['chapter'])) {echo $_GET['chapter'];} ?> ">
            </p>
            <p>
                <label>State</label><br>
                <span id="state_input"></span>
            </p>
              <p>
                <label>Chapter</label><br>
                <span id="chapter_input"></span>
              </p>
              <p>
              <label>City</label><br>
              <input class="filter_box" type="text" name="city"  class="" placeholder="City " value="<?php if(!empty($_GET['city'])) { echo $_REQUEST['city']; } ?>">
             </p>
             
              <button style="border:0px solid #fff; margin-top:10px;float:right;background-color:deepskyblue;color:#fff;cursor: pointer;">Search <i class="fa fa-search"></i></button>

              <a style="border:0px solid #fff;margin-top:10px;float:left;color:#fff;cursor: pointer;background-color:#d91313;padding:1px 4px 1px 4px" href="<?php echo home_url('member-dashboard'); ?>"><i class="fa fa-refresh"></i></a>
             
            </form>
          </div>
        </div>
      </div>
      <?php } ?>

  </div>
  <div class="column col-2 responsive-table">
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
      <!-- <div class="et_pb_inner_shadow form_background">
        <div class="et_pb_row et_pb_row_0">
          <div class="et_pb_contact">
            <form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET">
            <div style="float:right;margin-bottom:10px;">
            <input type="text" style="font-size:21px;color:grey;" name="global_search" placeholder="Global Search..." value="<?= isset($_GET['global_search']) ? $_GET['global_search'] : '' ?>">
            <button style="font-size:21px;background-color:#04AA6D;color:#fff;cursor: pointer;">Search <i class="fa fa-search"></i></button>
            </div>  
            <div id="hide_div">
            <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
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
              <p class=" et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
                <label>State</label>
                <span id="state_input"></span>
                </select>
              </p>
              <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half">
                <label>Chapter</label>
                <span id="chapter_input"></span>
                </select>
              </p>
              <p class="et_pb_contact_field ui-sortable et_pb_contact_field_half et_pb_contact_field_last">
              <label>City</label>
              <input type="text" name="city"  class="input" placeholder="City " value="<?php if(!empty($_GET['city'])) { echo $_REQUEST['city']; } ?>">
             </p>

              <div class="et_contact_bottom_container">
                <button type="submit" class="et_pb_button" style="background-color: deepskyblue !important;" data-quickaccess-id="button">Search <i class="fa fa-search"></i></button>
                <a class="et_pb_button" href="<?php echo home_url('member-dashboard'); ?>">Reset <i class="fa fa-refresh"></i></a>
              </div>
              </div>

            </form>
          </div>
        </div>
      </div><br> -->

      <table class="table et_pb_with_background et_pb_inner_shadow price" style="width: auto">
        <thead class="thead">
          <tr class="et_pb_pricing_heading">
            <th class="text-center vertical_line" width="10%">Member ID</th>
            <th class="text-center vertical_line">Name</th>
            <th class="text-center vertical_line">Email</th>
            <th class="text-center vertical_line">Join Date</th>
            <th class="text-center vertical_line">Address</th>
            <th class="text-center vertical_line">Phone</th>
           <!--  <th class="text-center vertical_line">Status</th> -->
            <th class="text-center vertical_line">View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rowcount > 0) {
            foreach ($rows as $member) { ?>
              <tr class="price">
                <td class="text-center vertical_line"><?= $member->member_id; ?></td>
                <td class="text-center vertical_line"><?= $member->first_name . ' ' . $member->last_name; ?></td>
                <td class="text-center vertical_line"><?= $member->user_email; ?></td>
                <td class="text-center vertical_line"><?= $member->user_registered; ?></td>
                <td class="text-center vertical_line"><?= $member->address_line_1; ?></td>
                <td class="text-center vertical_line"><?= $member->primary_phone_no; ?></td>
                <!-- <td class="text-center vertical_line"><?= $member->membership; ?></td> -->
                <td class="text-center vertical_line"><a href="<?php echo home_url('member-dashboard/member-info/?id='.$member->user_id); ?>"><i class="fa fa-eye" style="font-size:20px;color:deepskyblue"></i></a></td>
              </tr>
            <?php }
          } else { ?>
            <tr>
              <td colspan='7'>No records found</td>
            </tr>
          <?php  } ?>
        </tbody>

      </table>
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
        echo '<div class="" style="width: 99%;">
                                              <div class="" style="margin: 1em 0">' . $links . '</div></div>';
      }

      ?>

    <?php } ?>
  </div>