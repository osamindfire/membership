<?php

/**
 * Provide a member view page for the plugin
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

<div class="wrap">
    <!-- <?php echo $data; ?> -->
    <?php echo $test; ?>



    <?php if (!empty($data)) {
        foreach ($data as $key => $val) { ?>
            <h1>Member Details - <?php echo $val->first_name . ' ' . $val->last_name; ?></h1>

            <div id="dashboard-widgets-wrap" class="member-view">
                <div id="dashboard-widgets" class="metabox-holder">
                    <div id="postbox-container-1" class="postbox-container">
                        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                            <div id="dashboard_site_health" class="postbox ">

                                <div class="inside">

                                    <table class="form-table" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td class="td-lable">Email</td>
                                                <td><?php echo $val->user_email; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">Phone(Primary)</td>
                                                <td><?php echo $val->primary_phone_no; ?></td>
                                            </tr>

                                            <?php if (!empty($val->secondary_phone_no)) { ?>
                                                <tr>
                                                    <td class="td-lable">Phone(Secondary)</td>
                                                    <td><?php echo $val->secondary_phone_no; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td class="td-lable">Address</td>
                                                <td><?php echo $val->address_line_1; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">City</td>
                                                <td><?php echo $val->city; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">State</td>
                                                <td><?php echo $val->state; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">Country</td>
                                                <td><?php echo $val->country; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">Membership</td>
                                                <td><?php echo $val->membership; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">Chapter</td>
                                                <td><?php echo $val->chapter_name; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">Join Date</td>
                                                <td><?php echo $val->user_registered; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="td-lable">Souvenir</td>
                                                <td><?php echo $val->souvenir; ?></td>
                                            </tr>

                                            <tr></tr>

                                            <?php if (!empty($parents)) { ?>
                                                <tr class="border-top">
                                                    <td class="td-lable">Parent(s)</td>
                                                    <td>
                                                        <?php foreach ($parents as $parent) { ?>
                                                            <?php echo $parent->first_name . ' ' . $parent->last_name; ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td-lable">Parent Email</td>
                                                    <td>
                                                        <?php foreach ($parents as $parent) { ?>
                                                            <?php echo $parent->user_email; ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                            <?php }
                                            if (!empty($childs)) {
                                            ?>
                                                <tr class="border-top">
                                                    <td class="td-lable">Child(ren)</td>
                                                    <td>
                                                        <?php foreach ($childs as $child) { ?>
                                                            <?php echo '<span>' . $child->first_name . ' ' . $child->last_name . '</span><br>'; ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>

                                </div>


                            </div>

                        </div>
                    </div>


                </div>

            </div>
    <?php }
    } ?>


</div>