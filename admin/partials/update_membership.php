<?php
//echo "<pre>";print_r($_REQUEST);die;
?>

<div class="wrap" id="member_add">
            <?php if (isset($_GET['success'])) { ?>
                <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible">
                    <p><strong>Details updated.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                </div>
            <?php } ?>


            <div class="postbox" id="heading">
                <h1><strong>Update Membership Plan</strong></h1>
            </div>

            <form method="post" action="" novalidate="novalidate">
                <div id="dashboard-widgets-wrap">
                    <div id="dashboard-widgets" class="metabox-holder">
                            <div id="postbox-container-1" class="postbox-container edit-postbox">
                                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                                    <div id="dashboard_site_health" class="postbox ">
                                    <div class="inside">
                                        <table class="form-table" role="presentation">
                                            <tbody>
                                            <h2>Current Membership Plan: <strong><?= $currentMembershipInfo[0]->membership;?></strong></h2>
                                                <tr>
                            
                                                    <td><strong><label for="country">Membership Plan</label></strong><br>
                                                        <select name="membership_type" id="membership_type_id" class="postform" required style="width: 100%;">
                                                            <option value="" selected>Select</option>

                                                            <?php
                                                            foreach ($membershipPlans as $key=>$plan) {?>
                                                            <?php if($plan->type == 1){ $type= "Single";}elseif($type==2){ $type= "Family";}else{ $type= "Other";} ?>
                                                            <option class="level-0" value="<?php echo $plan->membership_type_id; ?>" <?php if(isset($_POST['membership_type']) && $_POST['membership_type'] == $plan->membership_type_id ) { echo "selected";}?>><?php echo $plan->membership; ?>( <?= $type;?> )</option>
                                                            <?php } ?>

                                                        </select><br>
                                                        <error><?php if (!empty($errors['membership_type'])) { echo $errors['membership_type'];} ?></error>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong><label for="fee">Fee</label></strong><br>
                                                        <input type="text" name="fee" id="fee" value="" readonly>
                                                    </td>
                                                    <td><strong><label for="total_days">Duration (In days)</label></strong><br>
                                                        <input type="text" name="total_days" id="total_days" value="" readonly>
                                                    </td>
                                                    <td><strong><label for="transaction_id_and_check_no">Reason for update</label></strong><br>
                                                        <input type="text" name="transaction_id_and_check_no" value="<?php if(isset($_POST['transaction_id_and_check_no'])) { echo $_POST['transaction_id_and_check_no']; }else{ echo "Added by Admin";} ?>" required><br>
                                                        <error><?php if (!empty($errors['transaction_id_and_check_no'])) { echo $errors['transaction_id_and_check_no'];} ?></error>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <?php wp_nonce_field("update_membership_plan","update_membershiplan_form"); ?>
                </div>

                <p class=""><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>


            </form>
</div>