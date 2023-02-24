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
      <div class="et_pb_inner_shadow form_background" style="width: 100%;">
        <div class="et_pb_row et_pb_row_0">
          <div class="et_pb_contact">
            <form class="et_pb_contact_form clearfix" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET">
            <p class="et_pb_contact_field ui-sortable">
              <input type="text" name="global_search" style="width:100%" class="input" placeholder="Global Search..." value="<?php if(!empty($_GET['global_search'])) { echo $_REQUEST['global_search']; } ?>">
             </p>
            <!-- <button type="submit" class="" style="color:#fff;float: right;background-color: deepskyblue !important;height:30px;border:1px solid #fff;cursor: pointer;" data-quickaccess-id="button"><i class="fa fa-search"></i></button>
            <div style="overflow: hidden; padding-right: .5em;">
              <input type="text" name="global_search" class="et_pb_contact_field ui-sortable input" placeholder="Global Search......" value="<?php if(!empty($_GET['global_search'])) { echo $_REQUEST['global_search']; } ?>" style="margin-bottom:10px;margin-left:30px;width: 97%;height:30px" />
            </div> -->

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
             <input type="text" readonly style="color: #fff;background-color: #04AA6D;font-weight: bold;" value="Total Members :  <?= $total ;?>">
                
            </p>
              <div class="et_contact_bottom_container">
                <button type="submit" class="et_pb_button" style="background-color: deepskyblue !important;" data-quickaccess-id="button"> <i class="fa fa-search"></i></button>
                <a class="et_pb_button" href="<?php echo home_url('member-dashboard'); ?>"> <i class="fa fa-refresh"></i></a>
              </div>

            </form>
          </div>
        </div>
      </div><br>

      <table class="table et_pb_with_background et_pb_inner_shadow price responsive-table" style="width: 100%;table-layout:fixed;">
        <thead class="thead">
          <tr class="et_pb_pricing_heading">
            <th class="text-center vertical_line" style="width:10%;word-wrap: break-word;">Member ID</th>
            <th class="text-center vertical_line" style="width:12%;word-wrap: break-word;">Name</th>
            <th class="text-center vertical_line" style="width:20%;word-wrap: break-word;">Email</th>
            <th class="text-center vertical_line" style="width:15%;word-wrap: break-word;">Join Date</th>
            <th class="text-center vertical_line" style="width:20%;word-wrap: break-word;">Address</th>
            <th class="text-center vertical_line" style="width:15%;word-wrap: break-word;">Phone</th>
            <th class="text-center vertical_line" style="width:8%;word-wrap: break-word;">Details</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rowcount > 0) {
            foreach ($rows as $member) { ?>
              <tr class="price">
                <td class="text-center vertical_line" style="width:10%;word-wrap: break-word;"><?= $member->member_id; ?></td>
                <td class="text-center vertical_line" style="width:12%;word-wrap: break-word;"><?= $member->first_name . ' ' . $member->last_name; ?></td>
                <td class="text-center vertical_line" style="width:20%;word-wrap: break-word;"><?= $member->user_email; ?></td>
                <td class="text-center vertical_line" style="width:15%;word-wrap: break-word;"><?= $member->user_registered; ?></td>
                <td class="text-center vertical_line" style="width:20%;word-wrap: break-word;"><?= $member->address_line_1; ?></td>
                <td class="text-center vertical_line" style="width:15%;word-wrap: break-word;"><?= $member->primary_phone_no; ?></td>
                <td class="text-center vertical_line" style="width:8%;word-wrap: break-word;"><a href="<?php echo home_url('member-dashboard/member-info/?id='.$member->user_id); ?>"><i class="fa fa-eye" style="font-size:20px;color:deepskyblue"></i></a></td>
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
        echo '<div class="" style="width: 99%;"><div class="" style="float:right;margin: 1em 0">'.$total.' Records found ' . $links . '</div></div>';
      }else{
        echo '<div class="" style="width: 99%;"><div class="" style="float:right;margin: 1em 0">'.$total.' Records found ' . $links . '</div></div>';
      }

      ?>

    <?php } ?>
  </div>