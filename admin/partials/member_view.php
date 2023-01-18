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
    <h1>Member Details - <?php if(isset($_GET['id'])){echo $_GET['id'];}?></h1>
    
    <!-- <button id="mem_detail">clickme</button> -->
    <?php foreach($data as $key=>$val){ ?>
    <div id="welcome-panel" class="welcome-panel">
        <div class="">
            <div class="welcome-panel-column-container">
                <!-- <div class="welcome-panel-column">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <rect width="48" height="48" rx="4" fill="#1E1E1E"></rect>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32.0668 17.0854L28.8221 13.9454L18.2008 24.671L16.8983 29.0827L21.4257 27.8309L32.0668 17.0854ZM16 32.75H24V31.25H16V32.75Z" fill="white"></path>
                    </svg>
                    <div class="welcome-panel-column-content">
                        <h3>Author rich content with blocks and patterns</h3>
                        <p>Block patterns are pre-configured block layouts. Use them to get inspired or create new pages in a flash.</p>
                        <a href="http://osa-membership-local.com/wp-admin/post-new.php?post_type=page">Add a new page</a>
                    </div>
                </div>
                <div class="welcome-panel-column">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <rect width="48" height="48" rx="4" fill="#1E1E1E"></rect>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18 16h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H18a2 2 0 0 1-2-2V18a2 2 0 0 1 2-2zm12 1.5H18a.5.5 0 0 0-.5.5v3h13v-3a.5.5 0 0 0-.5-.5zm.5 5H22v8h8a.5.5 0 0 0 .5-.5v-7.5zm-10 0h-3V30a.5.5 0 0 0 .5.5h2.5v-8z" fill="#fff"></path>
                    </svg>
                    <div class="welcome-panel-column-content">
                        <h3>Start Customizing</h3>
                        <p>Configure your site’s logo, header, menus, and more in the Customizer.</p>
                        <a class="load-customize hide-if-no-customize" href="http://osa-membership-local.com/wp-admin/customize.php">Open the Customizer</a>
                    </div>
                </div>
                <div class="welcome-panel-column">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <rect width="48" height="48" rx="4" fill="#1E1E1E"></rect>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M31 24a7 7 0 0 1-7 7V17a7 7 0 0 1 7 7zm-7-8a8 8 0 1 1 0 16 8 8 0 0 1 0-16z" fill="#fff"></path>
                    </svg>
                    <div class="welcome-panel-column-content">
                        <h3>Discover a new way to build your site.</h3>
                        <p>There is a new kind of WordPress theme, called a block theme, that lets you build the site you’ve always wanted — with blocks and styles.</p>
                        <a href="https://wordpress.org/support/article/block-themes/">Learn about block themes</a>
                    </div>
                </div> -->
                <!-- <div></div> -->
                <div>
                    <form method="post" action="" novalidate="novalidate">
                        <input type="hidden" name="option_page" value="general"><input type="hidden" name="action" value="update"><input type="hidden" id="_wpnonce" name="_wpnonce" value="e8b18fe271"><input type="hidden" name="_wp_http_referer" value="/wp-admin/options-general.php">
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="blogname">Member ID</label></th>
                                    <td><input name="" type="text" id="blogname" value="<?php echo $val->member_id; ?>" class="regular-text"></td>
                                </tr>

                                <tr>
                                    <th scope="row"><label for="blogdescription">Email</label></th>
                                    <td><input name="" type="text" id="blogdescription" aria-describedby="tagline-description" value="<?php echo $val->user_email; ?>" class="regular-text" placeholder="">                                    </td>
                                </tr>


                                <tr>
                                    <th scope="row"><label for="siteurl">Chapter Affiliation</label></th>
                                    <td><input name="" type="url" id="siteurl" value="" class="regular-text code"></td>
                                </tr>

                                <tr>
                                    <th scope="row"><label for="home">Parent(s)</label></th>
                                    <td><input name="" type="url" id="home" aria-describedby="home-description" value="" class="regular-text code">
                                    </td>
                                </tr>


                                <tr>
                                    <th scope="row"><label for="new_admin_email">Child(ren)</label></th>
                                    <td><input name="" type="email" id="new_admin_email" aria-describedby="new-admin-email-description" value="" class="regular-text ltr">
                                    </td>
                                </tr>

                            </tbody>

                        </table>


                        <!-- <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p> -->
                    </form>
                </div>
                <div>
                    <table class="form-table" role="presentation">

                        <tbody>
                            <tr>
                                <th scope="row"><label for="blogname">Address</label></th>
                                <td><input name="" type="text" id="blogname" value="" class="regular-text"></td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="blogdescription">Phone</label></th>
                                <td><input name="" type="text" id="blogdescription" aria-describedby="tagline-description" value="" class="regular-text" placeholder="">
                                </td>
                            </tr>


                            <tr>
                                <th scope="row"><label for="siteurl">Membership</label></th>
                                <td><input name="" type="url" id="siteurl" value="" class="regular-text code"></td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="home">Donation</label></th>
                                <td><input name="" type="url" id="home" aria-describedby="home-description" value="" class="regular-text code">
                                </td>
                            </tr>


                            <tr>
                                <th scope="row"><label for="new_admin_email">Role</label></th>
                                <td><input name="" type="email" id="new_admin_email" aria-describedby="new-admin-email-description" value="" class="regular-text ltr">
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
 <?php }?>

</div>