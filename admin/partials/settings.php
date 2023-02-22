<?php

/**
 * Provide a admin menu - Members settings for the plugin
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
    <h1>Settings</h1>

    <form method="post" action="" novalidate="novalidate">
        <!-- <input type="hidden" name="option_page" value="general"><input type="hidden" name="action" value="update"><input type="hidden" id="_wpnonce" name="_wpnonce" value="e7b492fe91"><input type="hidden" name="_wp_http_referer" value="/wp-admin/options-general.php"> -->
        <table class="form-table" role="presentation">

            <tbody>

                <tr>
                    <th scope="row"><label for="app_key">GOOGLE APP KEY</label></th>
                    <td><input name="app_key" type="url" id="siteurl" value="<?= get_option('app_key') ?>" class="regular-text code">
                        <error><?php if (!empty($errors['app_key'])) {
                                    echo $errors['app_key'];
                                } ?></error>
                    </td>
                </tr>
                <!-- <tr>
                    <th scope="row"><label for="auth_token_url">GOOGLE AUTH TOKEN (URL)</label></th>
                    <td><input name="auth_token_url" type="text" id="blogname" value="<?= get_option('auth_token_url') ?>" class="regular-text">
                        <error><?php if (!empty($errors['auth_token_url'])) {
                                    echo $errors['auth_token_url'];
                                } ?></error>
                    </td>
                </tr> -->

                <tr>
                    <th scope="row"><label for="auth_client_id">GOOGLE AUTH CLIENT ID</label></th>
                    <td><input name="auth_client_id" type="text" id="blogdescription" aria-describedby="tagline-description" value="<?= get_option('auth_client_id') ?>" class="regular-text" placeholder="">
                        <error><?php if (!empty($errors['auth_client_id'])) {
                                    echo $errors['auth_client_id'];
                                } ?></error>
                        <!-- <p class="description" id="tagline-description">In a few words, explain what this site is about.</p> -->
                    </td>
                </tr>


                <tr>
                    <th scope="row"><label for="auth_client_secret">GOOGLE AUTH CLIENT SECRET</label></th>
                    <td><input name="auth_client_secret" type="url" id="siteurl" value="<?= get_option('auth_client_secret') ?>" class="regular-text code">
                        <error><?php if (!empty($errors['auth_client_secret'])) {
                                    echo $errors['auth_client_secret'];
                                } ?></error>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="refresh_token">GOOGLE REFRESH TOKEN</label></th>
                    <td><input name="refresh_token" type="url" id="home" aria-describedby="home-description" value="<?= get_option('refresh_token') ?>" class="regular-text code">
                        <error><?php if (!empty($errors['refresh_token'])) {
                                    echo $errors['refresh_token'];
                                } ?></error>
                        <!-- <p class="description" id="home-description">
                            Enter the address here if you <a href="https://wordpress.org/support/article/giving-wordpress-its-own-directory/">want your site home page to be different from your WordPress installation directory</a>.</p> -->
                    </td>
                </tr>


                <tr>
                    <th scope="row"><label for="access_token">GOOGLE ACCESS TOKEN</label></th>
                    <td><input name="access_token" type="email" id="new_admin_email" aria-describedby="new-admin-email-description" value="<?= get_option('access_token') ?>" class="regular-text ltr">
                        <error><?php if (!empty($errors['access_token'])) {
                                    echo $errors['access_token'];
                                } ?></error>
                        <!-- <p class="description" id="new-admin-email-description">This address is used for admin purposes. If you change this, an email will be sent to your new address to confirm it. <strong>The new address will not become active until confirmed.</strong></p> -->
                    </td>
                </tr>

                <!-- <tr>
                    <th scope="row"><label for="add_member_url">GOOGLE ADD MEMBER URL</label></th>
                    <td><input name="add_member_url" type="url" id="siteurl" value="<?= get_option('add_member_url') ?>" class="regular-text code">
                        <error><?php if (!empty($errors['add_member_url'])) {
                                    echo $errors['add_member_url'];
                                } ?></error>
                    </td>
                </tr> -->

            </tbody>
        </table>


        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>

</div>