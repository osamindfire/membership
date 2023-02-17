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
                <h1><strong>Add Membership Plan</strong></h1>
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

                                                <tr>
                                                    <td><strong><label for="membership">Membership</label></strong><br>
                                                        <input type="text" name="membership" value="<?php echo $_POST['membership']; ?>" required><br>
                                                        <error><?php if (!empty($errors['membership'])) { echo $errors['membership'];} ?></error>
                                                    </td>
                                                    <td><strong><label for="country">Type</label></strong><br>
                                                        <select name="type" class="postform" required style="width: 100%;">
                                                            <option value="" disabled selected>Select</option>

                                                            <?php
                                                            $types =['1'=>'Single','2'=>'Family','3'=>'Other']; 
                                                            foreach ($types as $key=>$type) {?>
                                                            <option class="level-0" <?php if ($key == $_POST['type']) { echo 'selected'; } ?> value="<?php echo $key; ?>"><?php echo $type; ?></option>
                                                            <?php } ?>

                                                        </select><br>
                                                        <error><?php if (!empty($errors['type'])) { echo $errors['type'];} ?></error>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong><label for="fee">Fee</label></strong><br>
                                                        <input type="text" name="fee" value="<?php echo $_POST['fee']; ?>" required><br>
                                                        <error><?php if (!empty($errors['fee'])) {echo $errors['fee'];} ?></error>
                                                    </td>
                                                    <td><strong><label for="total_days">Duration (In days)</label></strong><br>
                                                        <input type="text" name="total_days" value="<?php echo $_POST['total_days']; ?>" required><br>
                                                        <error><?php if (!empty($errors['total_days'])) {echo $errors['total_days'];} ?></error>
                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="postbox-container-1" class="postbox-container edit-postbox">
                            <div id="normal-sortables" class="meta-box-sortables min-h ui-sortable">
                                <div id="dashboard_site_health" class="postbox ">
                                    <div class="postbox-header">
                                        <h2 class="hndle ui-sortable-handle">Membership Plan Status</h2>
                                    </div>
                                    <div class="inside">
                                        <table class="form-table" role="presentation">

                                            <tbody>

                                                <tr>
                                                    <input type="radio" id="activate" class="idDeleted" name="status" value="1" <?php if ($_POST['status'] == 0) { echo 'checked';}  ?>>
                                                      <label for="html">Activate</label>
                                                      <input type="radio" id="deactivate" class="idDeleted" name="status" value="0" <?php if ($_POST['status'] == 1) {echo 'checked'; }  ?>>
                                                      <label for="css">Deactivate</label>
                                                </tr>
                                            </tbody>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
                    <?php wp_nonce_field("membershiplan","membershiplan_form"); ?>
                </div>

                <p class=""><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>


            </form>
</div>