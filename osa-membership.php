<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://odishasociety.org
 * @since             1.0.0
 * @package           Osa_Membership
 *
 * @wordpress-plugin
 * Plugin Name:       OSA Membership
 * Plugin URI:        https://odishasociety.org
 * Description:       The Odisha Society of the Americas (OSA) is a non-political, non-profit, and voluntary association recognized as a 501(c)(3) public non-profit in the United States. OSA was established in 1969 by a few visionary Oriyas who thought of establishing Oriya identity in the adopted land.
 * Version:           1.0.0
 * Author:            OSA
 * Author URI:        https://odishasociety.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       osa-membership
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'OSA_MEMBERSHIP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-osa-membership-activator.php
 */
function activate_osa_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-osa-membership-activator.php';
	Osa_Membership_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-osa-membership-deactivator.php
 */
function deactivate_osa_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-osa-membership-deactivator.php';
	Osa_Membership_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_osa_membership' );
register_deactivation_hook( __FILE__, 'deactivate_osa_membership' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-osa-membership.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_osa_membership() {

	$plugin = new Osa_Membership();
	$plugin->run();

}
run_osa_membership();
