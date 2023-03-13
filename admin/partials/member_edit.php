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

            <?php if (isset($_GET['success'])) { ?>
                <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible">
                    <p><strong>Details updated.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                </div>
            <?php } ?>


            <div class="postbox" id="heading">
                <h1><strong>Member Details - </strong><?php echo $val->first_name . ' ' . $val->last_name; ?> <a class="vers dashicons-before dashicons-visibility" title="View" href="?page=member-view&mid=<?php echo $_GET['mid']; ?>&id=<?php echo $_GET['id']; ?>"></a></h1>
            </div>

            <div id="member_info">
                <input type="text" hidden name="" id="id" value="<?php echo $_GET['id'] ?>">
                <input type="text" hidden name="" id="mid" value="<?php echo $_GET['mid'] ?>">
            </div>

            <form method="post" action="" novalidate="novalidate">

                <!-- <button id="mem_detail">clickme</button> -->

                <div id="dashboard-widgets-wrap">
                    <div id="dashboard-widgets" class="metabox-holder">
                        <div id="postbox-container-1" class="postbox-container edit-postbox">
                            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                                <div id="dashboard_site_health" class="postbox ">
                                    <div class="postbox-header">
                                        <h2 class="hndle ui-sortable-handle">Main Member</h2>
                                    </div>
                                    <div class="inside">

                                        <table class="form-table" role="presentation">
                                            <tbody>

                                                <tr>
                                                    <td><strong><label for="first_name" class="required">First Name</label></strong><br>
                                                        <input type="text" name="first_name" value="<?php if(isset($_POST['first_name'])){echo $_POST['first_name'];} else {echo $val->first_name;}?>" required><br>
                                                        <error><?php if (!empty($errors['first_name'])) {
                                                                    echo $errors['first_name'];
                                                                } ?></error>
                                                    </td>
                                                    <td><strong><label for="last_name" class="required">Last Name</label></strong><br>
                                                        <input type="text" name="last_name" value="<?php if(isset($_POST['last_name'])){echo $_POST['last_name'];} else {echo $val->last_name;} ?>" required><br>
                                                        <error><?php if (!empty($errors['last_name'])) {
                                                                    echo $errors['last_name'];
                                                                } ?></error>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td><strong><label for="user_email" class="required">Member Email</label></strong><br>
                                                        <input type="text" name="user_email" value="<?php if(isset($_POST['user_email'])){echo $_POST['user_email'];} else {echo $val->user_email;} ?>" ><br>
                                                        <error><?php if (!empty($errors['user_email'])) {
                                                                            echo $errors['user_email'];
                                                                        } ?></error>    
                                                    </td>
                                                    <td><strong><label for="membership">Membership</label></strong><br>
                                                        <input type="text" name="membership" readonly value="<?php echo $val->membership; ?>" >
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <?php
                                                    $required = '';
                                                    if ($val->parent_id == 0) {
                                                        $required = 'required';
                                                    }
                                                    ?>
                                                    <td><strong><label for="phone_no" class="<?= $required ?> ">Phone</label></strong><br>
                                                        <input type="text" name="phone_no" id="main_phone_no" maxlength="15" oninput="this.value = this.value.replace(/[^0-9-+() ]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if(isset($_POST['phone_no'])){echo $_POST['phone_no'];} else { echo $val->phone_no; } ?>" required><br>
                                                        <error><?php if (!empty($errors['phone_no'])) {
                                                                    echo $errors['phone_no'];
                                                                } ?></error>

                                                        <input type="text" name="parent_id" hidden value="<?php echo $val->parent_id; ?>">

                                                    </td>


                                                </tr>

                                                <tr>
                                                    <td><strong><label for="address_line_1" class="required">Address Line 1</label></strong><br>
                                                        <!-- <input type="text" name="address_line_1" value="<?php echo $val->address_line_1; ?>" required> -->
                                                        <textarea name="address_line_1" id="" cols="" rows="2"><?php if(isset($_POST['address_line_1'])){echo $_POST['address_line_1'];} else {  echo $val->address_line_1; } ?></textarea><br>
                                                        <error><?php if (!empty($errors['address_line_1'])) {
                                                                    echo $errors['address_line_1'];
                                                                } ?></error>
                                                    </td>
                                                    <td><strong><label for="address_line_2">Address Line 2</label></strong><br>
                                                        <textarea name="address_line_2" id="" cols="" rows="2"><?php if(isset($_POST['address_line_2'])){echo $_POST['address_line_2'];} else { echo $val->address_line_2; }?></textarea>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td><strong><label for="country" class="required">Country</label></strong><br>
                                                        <select name="country_id" id="editCountry" class="postform" required>
                                                            <option value="" disabled selected>Select</option>

                                                            <?php
                                                            foreach ($countries as $country) {
                                                                $selected = '';
                                                                if (isset($_POST['country_id']) && $country->country_type_id == $_POST['country_id']) {
                                                                    $selected = 'selected';
                                                                } else
                                                                if ($country->country == $val->country) {
                                                                    $selected = 'selected';
                                                                }
                                                            ?><option class="level-0" <?php echo $selected ?> value="<?php echo $country->country_type_id; ?>"><?php echo $country->country; ?></option>
                                                            <?php } ?>

                                                        </select><br>
                                                        <error><?php if (!empty($errors['country_id'])) {
                                                                    echo $errors['country_id'];
                                                                } ?></error>
                                                    </td>
                                                    <td><strong><label for="state" class="required">State</label></strong><br>
                                                        <select name="state_id" id="editState" class="postform" required>
                                                            <option value="" disabled selected>Select</option>

                                                            <?php
                                                            foreach ($states as $state) {
                                                                $selected = '';
                                                                if (isset($_POST['state_id']) && $state->state_type_id == $_POST['state_id']) {
                                                                    $selected = 'selected';
                                                                } else
                                                                if ($state->state == $val->state) {
                                                                    $selected = 'selected';
                                                                }
                                                            ?><option class="level-0" <?php echo $selected ?> value="<?php echo $state->state_type_id; ?>"><?php echo $state->state; ?></option>
                                                            <?php } ?>

                                                        </select><br>
                                                        <error><?php if (!empty($errors['state_id'])) {
                                                                    echo $errors['state_id'];
                                                                } ?></error>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td><strong><label for="chapter_id" class="required">Chapter Affiliation</label></strong><br>
                                                        <!-- <input type="text" name="chapter_name" readonly value="<?php //echo $val->chapter_name; 
                                                                                                                    ?>" required> -->
                                                        <select name="chapter_id" id="" class="postform" required>
                                                            <option value="" disabled selected>Select</option>

                                                            <?php
                                                            foreach ($chapters as $chapter) {
                                                                $selected = '';
                                                                if (isset($_POST['chapter_id']) && $chapter->chapter_type_id == $_POST['chapter_id']) {
                                                                    $selected = 'selected';
                                                                } else
                                                                if ($chapter->chapter_type_id == $val->chapter_id) {
                                                                    $selected = 'selected';
                                                                }
                                                            ?><option class="level-0" <?php echo $selected ?> value="<?php echo $chapter->chapter_type_id; ?>"><?php echo $chapter->name; ?></option>
                                                            <?php } ?>

                                                        </select><br>
                                                        <error><?php if (!empty($errors['chapter'])) {
                                                                    echo $errors['chapter'];
                                                                } ?></error>
                                                    </td>
                                                    <td><strong><label for="city" class="required">City</label></strong><br>
                                                        <input type="text" name="city" value="<?php if(isset($_POST['city'])){echo $_POST['city'];} else { echo $val->city;} ?>" required><br>
                                                        <error><?php if (!empty($errors['city'])) {
                                                                    echo $errors['city'];
                                                                } ?></error>
                                                    </td>
                                                </tr>



                                                <tr>
                                                    <td><strong><label for="postal_code" class="required">Postal Code</label></strong><br>
                                                        <input type="text" name="postal_code" value="<?php if(isset($_POST['postal_code'])){echo $_POST['postal_code'];} else{ echo $val->postal_code; }?>" required><br>
                                                        <error><?php if (!empty($errors['postal_code'])) {
                                                                    echo $errors['postal_code'];
                                                                } ?></error>
                                                    </td>
                                                    <td><strong><label for="souvenir">Souvenir</label></strong><br>
                                                        <select name="souvenir" id="" class="postform ">

                                                            <?php $souvenir = array("CD", "Print");
                                                            foreach ($souvenir as $list) {
                                                                $selected = '';
                                                                if (isset($_POST['souvenir']) && $list == $_POST['souvenir']) {
                                                                    $selected = 'selected';
                                                                } else
                                                                if ($list == $val->souvenir) {
                                                                    $selected = 'selected';
                                                                }
                                                            ?>
                                                                <option class="level-0" <?php echo $selected ?> value="<?php echo $list ?>"><?php echo $list ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><strong><label for="status">Status</label></strong><br>
                                                        <select name="status" id="" class="postform ">

                                                            <?php $status = array("Alive" => 1, "Deceased" => 0);
                                                            foreach ($status as $key => $value) {
                                                                $selected = '';
                                                                if (isset($_POST['status']) && $value == $_POST['status']) {
                                                                    $selected = 'selected';
                                                                } else
                                                                if ($val->alive == $value) {
                                                                    $selected = 'selected';
                                                                }
                                                            ?>
                                                                <option class="level-0" <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $key; ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>


                                    </div>
                                </div>

                                <div id="dashboard_site_health" class="postbox ">
                                    <div class="postbox-header">
                                        <h2 class="hndle ui-sortable-handle">Change Password</h2>
                                    </div>
                                    <div class="inside">
                                        <table class="form-table" role="presentation">

                                            <tbody>
                                                <tr>
                                                    <td><strong><label for="password">Password</label></strong><br>
                                                        <input type="password" name="password" oninput="this.value = this.value.replace(/[^0-9|a-z|A-Z|!@#$%^&*_=+-]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if (isset($_POST['password'])) {
                                                                                                                                                                                                                echo $_POST['password'];
                                                                                                                                                                                                            } ?>"><br>
                                                        <error><?php if (!empty($errors['password'])) {
                                                                    echo $errors['password'];
                                                                } ?></error>

                                                        <input type="text" name="user_id" hidden value="<?php echo $val->user_id; ?>">
                                                    </td>
                                                    <td><strong><label for="confirm_password">Confirm Password</label></strong><br>
                                                        <input type="password" name="confirm_password" oninput="this.value = this.value.replace(/[^0-9|a-z|A-Z|!@#$%^&*_=+-]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if (isset($_POST['confirm_password'])) {
                                                                                                                                                                                                                        echo $_POST['confirm_password'];
                                                                                                                                                                                                                    } ?>"><br>
                                                        <error><?php if (!empty($errors['confirmPassword'])) {
                                                                    echo $errors['confirmPassword'];
                                                                } ?></error>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="postbox-container-1" class="postbox-container edit-postbox">
                            <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                                <?php if (!empty($parents)) { ?>
                                    <div id="dashboard_site_health" class="postbox ">
                                        <div class="postbox-header">
                                            <h2 class="hndle ui-sortable-handle">Partner</h2>
                                        </div>
                                        <div class="inside">
                                            <table class="form-table" role="presentation">

                                                <tbody>
                                                    <?php foreach ($parents as $parent) { ?>
                                                        <tr>
                                                            <!-- <th scope="row"><label for="spouse_first_name" class="required">First Name</label></th> -->

                                                            <td><strong><label for="spouse_first_name" class="required">First Name</label></strong><br>
                                                                <input type="text" name="spouse_first_name" value="<?php if (isset($_POST['spouse_first_name'])) {
                                                                                                                        echo $_POST['spouse_first_name'];
                                                                                                                    } else { echo $parent->first_name; }?>"><br>
                                                                <error><?php if (!empty($errors['spouse_first_name'])) {
                                                                            echo $errors['spouse_first_name'];
                                                                        } ?></error>
                                                            </td>

                                                            <td><strong><label for="spouse_last_name" class="required">Last Name</label></strong><br>
                                                                <input type="text" name="spouse_last_name" value="<?php if (isset($_POST['spouse_last_name'])) {
                                                                                                                        echo $_POST['spouse_last_name'];
                                                                                                                    } else { echo $parent->last_name; } ?>"><br>
                                                                <error><?php if (!empty($errors['spouse_last_name'])) {
                                                                            echo $errors['spouse_last_name'];
                                                                        } ?></error>
                                                            </td>

                                                            <input type="text" name="spouse_id" hidden value="<?php echo $parent->id; ?>">
                                                            <input type="text" name="spouse_user_id" hidden value="<?php echo $parent->user_id; ?>">
                                                            <input type="text" name="spouse_parent_id" hidden value="<?php echo $parent->parent_id; ?>">

                                                        </tr>

                                                        <tr>
                                                            <td><strong><label for="spouse_email" class="required">Email</label></strong><br>
                                                                <input type="text" name="spouse_email" value="<?php if (isset($_POST['spouse_email'])) {
                                                                                                                            echo $_POST['spouse_email'];
                                                                                                                        } else{ echo $parent->user_email;}?>"><br>
                                                                <error><?php if (!empty($errors['spouse_email'])) {
                                                                            echo $errors['spouse_email'];
                                                                        } ?></error>                                                       
                                                            </td>

                                                            <?php
                                                            $requiredParent = '';
                                                            if ($parent->parent_id == 0) {
                                                                $requiredParent = 'required';
                                                            }
                                                            ?>
                                                            <td><strong><label for="spouse_phone_no" class="<?= $requiredParent ?>">Phone</label></strong><br>
                                                                <input type="text" name="spouse_phone_no" id="spouse_phone_no" maxlength="15" class="phone_no" oninput="this.value = this.value.replace(/[^0-9-+() ]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if (isset($_POST['spouse_phone_no'])) {
                                                                                                                        echo $_POST['spouse_phone_no'];
                                                                                                                    } else{ echo $parent->phone_no; }?>" required><br>
                                                                <error><?php if (!empty($errors['spouse_phone_no'])) {
                                                                            echo $errors['spouse_phone_no'];
                                                                        } ?></error>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong><label for="spouse_status">Status</label></strong><br>
                                                                <select name="spouse_status" id="" class="postform ">

                                                                    <?php $status = array("Alive" => 1, "Deceased" => 0);
                                                                    foreach ($status as $key => $value) {
                                                                        $selected = '';
                                                                        if (isset($_POST['spouse_status']) && $value == $_POST['spouse_status']) {
                                                                            $selected = 'selected';
                                                                        } else
                                                                        if ($parent->alive == $value) {
                                                                            $selected = 'selected';
                                                                        }
                                                                    ?>
                                                                        <option class="level-0" <?php echo $selected ?> value="<?php echo $value ?>"><?php echo $key ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                            </td>
                                                        </tr>

                                                    <?php } ?>
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                <?php } else if (empty($parents) && $val->membership_type != 1) { ?>
                                    <div id="dashboard_site_health" class="postbox ">
                                        <div class="postbox-header">
                                            <h2 class="hndle ui-sortable-handle">Add Partner</h2>
                                        </div>
                                        <div class="inside">
                                        <p id="alertPartnerNotFound">Note: No data found for Partner. You can also create partner account !</p>

                                            <table class="form-table" role="presentation">
                                                <tbody>
                                                    <tr>
                                                        <td><strong><label for="spouse_first_name" class="">First Name</label></strong><br>
                                                            <input type="text" name="spouse_first_name" value="<?php if (isset($_POST['spouse_first_name'])) {
                                                                                                                    echo $_POST['spouse_first_name'];
                                                                                                                } ?>"><br>
                                                            <error><?php if (!empty($errors['spouse_first_name'])) {
                                                                        echo $errors['spouse_first_name'];
                                                                    } ?></error>
                                                        </td>

                                                        <td><strong><label for="spouse_last_name" class="">Last Name</label></strong><br>
                                                            <input type="text" name="spouse_last_name" value="<?php if (isset($_POST['spouse_last_name'])) {
                                                                                                                    echo $_POST['spouse_last_name'];
                                                                                                                } ?>"><br>
                                                            <error><?php if (!empty($errors['spouse_last_name'])) {
                                                                        echo $errors['spouse_last_name'];
                                                                    } ?></error>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong><label for="spouse_email" class="">Email</label></strong><br>
                                                            <input type="email" name="spouse_email" value="<?php if (isset($_POST['spouse_email'])) {
                                                                                                                echo $_POST['spouse_email'];
                                                                                                            } ?>"><br>
                                                            <error><?php if (!empty($errors['spouse_email'])) {
                                                                        echo $errors['spouse_email'];
                                                                    } ?></error>
                                                        </td>

                                                        <td><strong><label for="spouse_phone_no" class="">Phone</label></strong><br>
                                                            <input type="text" name="spouse_phone_no" maxlenght="15" id="add_spouse_phone_no" class="phone_no" value="<?php if (isset($_POST['spouse_phone_no'])) {
                                                                                                                    echo $_POST['spouse_phone_no'];
                                                                                                                } ?>"><br>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong><label for="spouse_password" class="">Password</label></strong><br>
                                                            <input type="password" name="spouse_password" oninput="this.value = this.value.replace(/[^0-9|a-z|A-Z|!@#$%^&*_=+-]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if (isset($_POST['spouse_password'])) {
                                                                                                                    echo $_POST['spouse_password'];
                                                                                                                } ?>"><br>
                                                            <error><?php if (!empty($errors['spouse_password'])) {
                                                                        echo $errors['spouse_password'];
                                                                    } ?></error>
                                                        </td>

                                                        <td><strong><label for="spouse_confirm_password" class="">Confirm Password</label></strong><br>
                                                            <input type="password" name="spouse_confirm_password" oninput="this.value = this.value.replace(/[^0-9|a-z|A-Z|!@#$%^&*_=+-]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if (isset($_POST['spouse_confirm_password'])) {
                                                                                                                            echo $_POST['spouse_confirm_password'];
                                                                                                                        } ?>" required><br>
                                                            <error><?php if (!empty($errors['spouse_confirm_password'])) {
                                                                        echo $errors['spouse_confirm_password'];
                                                                    } ?></error>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!empty($childs)) { ?>
                                    <div id="dashboard_site_health" class="postbox ">
                                        <div class="postbox-header">
                                            <h2 class="hndle ui-sortable-handle">Child(ren)</h2>
                                        </div>
                                        <div class="inside">
                                            <table class="form-table" role="presentation">
                                                <tbody>

                                                    <?php foreach ($childs as $key => $child) { ?>
                                                        <tr>
                                                            <td><strong><label for="child_first" class="required">First Name</label></strong><br>
                                                                <input type="text" name="child_first_<?php echo $key; ?>" value="<?php if (isset($_POST['child_first_'.$key])) { echo $_POST['child_first_'.$key]; } else { echo $child->first_name; }?>" ><br>
                                                                <error><?php if (!empty($errors['child_first_' . $key])) {
                                                                            echo $errors['child_first_' . $key];
                                                                        } ?></error>

                                                                <input type="text" hidden name="child_id_<?php echo $key; ?>" value="<?php echo $child->id; ?>" required>

                                                            </td>
                                                            <td><strong><label for="child_last" class="required">Last Name</label></strong><br>
                                                                <input type="text" name="child_last_<?php echo $key; ?>" value="<?php if (isset($_POST['child_last_'.$key])) { echo $_POST['child_last_'.$key]; } else { echo $child->last_name; }?>" required><br>
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
                                <?php } ?>

                                <div id="dashboard_site_health" class="postbox ">
                                    <div class="postbox-header">
                                        <h2 class="hndle ui-sortable-handle">Member Status</h2>
                                    </div>
                                    <div class="inside">
                                        <table class="form-table" role="presentation">

                                            <tbody>

                                                <tr>
                                                    <input type="radio" id="activate" class="idDeleted" name="is_deleted" value="0" <?php if ($val->is_deleted == 0) {
                                                                                                                                        echo 'checked';
                                                                                                                                    }  ?>>
                                                      <label for="html">Activate</label>
                                                      <input type="radio" id="deactivate" class="idDeleted" name="is_deleted" value="1" <?php if ($val->is_deleted == 1) {
                                                                                                                                            echo 'checked';
                                                                                                                                        }  ?>>
                                                      <label for="css">Deactivate</label>
                                                </tr>
                                            </tbody>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

                    <!-- <p class=""><input type="submit" name="submit" id="submit" class="button button-primary" value="Deactivate Member"></p> -->
                    <!-- <button type="submit"><a href="/wp-admin/admin.php?page=member-edit">Deactivate Member</a></button> -->


                    <input type="hidden" id="closedpostboxesnonce" name="closedpostboxesnonce" value="28615775eb"><input type="hidden" id="meta-box-order-nonce" name="meta-box-order-nonce" value="d78f85f044">
                </div>

                <p class=""><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>


            </form>





    <?php }
    } ?>


</div>