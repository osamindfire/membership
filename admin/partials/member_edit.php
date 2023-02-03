<?php

/**
 * Provide a member edit page for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://odishasociety.org
 * @since      1.0.0
 *
 * @package    Osa_Membership
 * @subpackage Osa_Membership/admin/partials
 */
?>



<div class="wrap" id="member_edit">
    <!-- <?php echo $data; ?> -->

    <?php echo $test; ?>
    <?php if (!empty($data)) {
        foreach ($data as $key => $val) { ?>


            <div class="postbox" id="heading">
                <h1><strong>Member Details - </strong><?php echo $val->first_name . ' ' . $val->last_name; ?> <a class="vers dashicons-before dashicons-visibility" title="View" href="?page=member-view&mid=<?php echo $_GET['mid']; ?>&id=<?php echo $_GET['id']; ?>"></a></h1>
            </div>



            <form method="post" action="" novalidate="novalidate">

                <!-- <button id="mem_detail">clickme</button> -->

                <div id="dashboard-widgets-wrap">
                    <div id="dashboard-widgets" class="metabox-holder">

                        <?php if (!empty($parents)) { ?>
                            <div id="postbox-container-1" class="postbox-container edit-postbox">
                                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                                    <div id="dashboard_site_health" class="postbox ">
                                        <!-- <div class="postbox-header">
                                            <h2 class="hndle ui-sortable-handle">Spouse</h2>
                                        </div> -->
                                        <div class="inside">

                                        <?php if (isset($_GET['success'])) { ?>
    <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible">
        <p><strong>Details updated.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
    </div>
<?php } ?>

                                            <table class="form-table" role="presentation">
                                                <tbody>

                                                    <tr>
                                                        <td><strong><label for="first_name">First Name</label></strong><br>
                                                            <input type="text" name="first_name" value="<?php echo $val->first_name; ?>" required>
                                                            <error><?php if (!empty($errors['first_name'])) {
                                                                        echo $errors['first_name'];
                                                                    } ?></error>
                                                        </td>
                                                        <td><strong><label for="last_name">Last Name</label></strong><br>
                                                            <input type="text" name="last_name" value="<?php echo $val->last_name; ?>" required>
                                                            <error><?php if (!empty($errors['last_name'])) {
                                                                        echo $errors['last_name'];
                                                                    } ?></error>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td><strong><label for="user_email">Member Email</label></strong><br>
                                                            <input type="text" name="user_email" readonly value="<?php echo $val->user_email; ?>" required>
                                                        </td>
                                                        <td><strong><label for="membership">Membership</label></strong><br>
                                                            <input type="text" name="membership" readonly value="<?php echo $val->membership; ?>" required>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td><strong><label for="primary_phone_no">Phone(Primary)</label></strong><br>
                                                            <input type="text" name="primary_phone_no" value="<?php echo $val->primary_phone_no; ?>" required>
                                                            <error><?php if (!empty($errors['primary_phone_no'])) {
                                                                        echo $errors['primary_phone_no'];
                                                                    } ?></error>
                                                        </td>
                                                        <td><strong><label for="secondary_phone_no">Phone(Secondary)</label></strong><br>
                                                            <input type="text" name="secondary_phone_no" value="<?php echo $val->secondary_phone_no; ?>" required>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td><strong><label for="address_line_1">Address Line 1</label></strong><br>
                                                            <!-- <input type="text" name="address_line_1" value="<?php echo $val->address_line_1; ?>" required> -->
                                                            <textarea name="address_line_1" id="" cols="" rows="2"><?php echo $val->address_line_1; ?></textarea>
                                                            <error><?php if (!empty($errors['address_line_1'])) {
                                                                        echo $errors['address_line_1'];
                                                                    } ?></error>
                                                        </td>
                                                        <td><strong><label for="address_line_2">Address Line 2</label></strong><br>
                                                            <textarea name="address_line_2" id="" cols="" rows="2"><?php echo $val->address_line_2; ?></textarea>
                                                            <error><?php if (!empty($errors['address_line_2'])) {
                                                                        echo $errors['address_line_2'];
                                                                    } ?></error>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td><strong><label for="country">Country</label></strong><br>
                                                            <select name="country_id" id="editCountry" class="postform" required>
                                                                <option value="" disabled selected>Select</option>

                                                                <?php
                                                                foreach ($countries as $country) {
                                                                    $selected = '';
                                                                    if ($country->country == $val->country) {
                                                                        $selected = 'selected';
                                                                    }
                                                                ?><option class="level-0" <?php echo $selected ?> value="<?php echo $country->country_type_id; ?>"><?php echo $country->country; ?></option>
                                                                <?php } ?>

                                                            </select>
                                                            <error><?php if (!empty($errors['country_id'])) {
                                                                        echo $errors['country_id'];
                                                                    } ?></error>
                                                        </td>
                                                        <td><strong><label for="state">State</label></strong><br>
                                                            <select name="state_id" id="editState" class="postform" required>
                                                                <option value="" disabled selected>Select</option>

                                                                <?php
                                                                foreach ($states as $state) {
                                                                    $selected = '';
                                                                    if ($state->state == $val->state) {
                                                                        $selected = 'selected';
                                                                    }
                                                                ?><option class="level-0" <?php echo $selected ?> value="<?php echo $state->state_type_id; ?>"><?php echo $state->state; ?></option>
                                                                <?php } ?>

                                                            </select>
                                                            <error><?php if (!empty($errors['state_id'])) {
                                                                        echo $errors['state_id'];
                                                                    } ?></error>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td><strong><label for="chapter_name">Chapter Affiliation</label></strong><br>
                                                            <input type="text" name="chapter_name" readonly value="<?php echo $val->chapter_name; ?>" required>
                                                        </td>
                                                        <td><strong><label for="city">City</label></strong><br>
                                                            <input type="text" name="city" value="<?php echo $val->city; ?>" required>
                                                            <error><?php if (!empty($errors['city'])) {
                                                                        echo $errors['city'];
                                                                    } ?></error>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td><strong><label for="postal_code">Postal Code</label></strong><br>
                                                            <input type="text" name="postal_code" value="<?php echo $val->postal_code; ?>" required>
                                                            <error><?php if (!empty($errors['postal_code'])) {
                                                                        echo $errors['postal_code'];
                                                                    } ?></error>
                                                        </td>
                                                        <td><strong><label for="souvenir">Souvenir</label></strong><br>
                                                            <select name="souvenir" id="" class="postform ">

                                                                <?php $souvenir = array("CD", "Print");
                                                                foreach ($souvenir as $list) {
                                                                    $selected = '';
                                                                    if ($list == $val->souvenir) {
                                                                        $selected = 'selected';
                                                                    }
                                                                ?>
                                                                    <option class="level-0" <?php echo $selected ?> value="<?php echo $list ?>"><?php echo $list ?></option>
                                                                <?php } ?>

                                                            </select>
                                                        </td>


                                                    </tr>

                                                </tbody>

                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($parents)) { ?>
                            <div id="postbox-container-1" class="postbox-container">
                                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                                    <div id="dashboard_site_health" class="postbox ">
                                        <div class="postbox-header">
                                            <h2 class="hndle ui-sortable-handle">Spouse</h2>
                                        </div>
                                        <div class="inside">
                                            <table class="form-table" role="presentation">

                                                <tbody>

                                                    <tr>
                                                        <th scope="row"><label for="spouse_first_name">First Name</label></th>
                                                        <?php foreach ($parents as $parent) { ?>
                                                            <td><input type="text" name="spouse_first_name" value="<?php echo $parent->first_name; ?>">
                                                            </td>
                                                            <input type="text" name="spouse_id" hidden value="<?php echo $parent->id; ?>">
                                                            <error><?php if (!empty($errors['spouse_first_name'])) {
                                                                        echo $errors['spouse_first_name'];
                                                                    } ?></error>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"><label for="spouse_last_name">Last Name</label></th>
                                                        <?php foreach ($parents as $parent) { ?>
                                                            <td><input type="text" name="spouse_last_name" value="<?php echo $parent->last_name; ?>">
                                                                <error><?php if (!empty($errors['spouse_last_name'])) {
                                                                            echo $errors['spouse_last_name'];
                                                                        } ?></error>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row"><label for="spouse_email">Email</label></th>
                                                        <?php foreach ($parents as $parent) { ?>
                                                            <td><input type="text" name="spouse_email" readonly value="<?php echo $parent->user_email; ?>">
                                                            </td>
                                                        <?php } ?>
                                                    </tr>

                                                </tbody>

                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($childs)) { ?>
                            <div id="postbox-container-1" class="postbox-container">
                                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                                    <div id="dashboard_site_health" class="postbox ">
                                        <div class="postbox-header">
                                            <h2 class="hndle ui-sortable-handle">Child(ren)</h2>
                                        </div>
                                        <div class="inside">
                                            <table class="form-table" role="presentation">

                                                <tbody>

                                                    <?php foreach ($childs as $key => $child) { ?>
                                                        <tr>
                                                            <td><strong><label for="child_first">First Name</label></strong><br>
                                                                <input type="text" name="child_first_<?php echo $key; ?>" value="<?php echo $child->first_name; ?>" required>
                                                                <error><?php if (!empty($errors['child_first_' . $key])) {
                                                                            echo $errors['child_first_' . $key];
                                                                        } ?></error>

                                                                <input type="text" hidden name="child_id_<?php echo $key; ?>" value="<?php echo $child->id; ?>" required>

                                                            </td>
                                                            <td><strong><label for="child_last">Last Name</label></strong><br>
                                                                <input type="text" name="child_last_<?php echo $key; ?>" value="<?php echo $child->last_name; ?>" required>
                                                                <error><?php if (!empty($errors['child_last_' . $key])) {
                                                                            echo $errors['child_last_' . $key];
                                                                        } ?></error>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>


                    </div>

                    <input type="hidden" id="closedpostboxesnonce" name="closedpostboxesnonce" value="28615775eb"><input type="hidden" id="meta-box-order-nonce" name="meta-box-order-nonce" value="d78f85f044">
                </div>

                <p class=""><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>


            </form>





    <?php }
    } ?>


</div>