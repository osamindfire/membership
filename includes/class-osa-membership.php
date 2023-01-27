<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://odishasociety.org
 * @since      1.0.0
 *
 * @package    Osa_Membership
 * @subpackage Osa_Membership/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Osa_Membership
 * @subpackage Osa_Membership/includes
 * @author     OSA <vicepresident@odishasociety.org>
 */
class Osa_Membership {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Osa_Membership_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	protected $plugin_public;

	protected $plugin_admin;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('OSA_MEMBERSHIP_VERSION')) {
			$this->version = OSA_MEMBERSHIP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'osa-membership';

		$this->load_dependencies();
		$this->inject_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shortcodes();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Osa_Membership_Loader. Orchestrates the hooks of the plugin.
	 * - Osa_Membership_i18n. Defines internationalization functionality.
	 * - Osa_Membership_Admin. Defines all hooks for the admin area.
	 * - Osa_Membership_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-osa-membership-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-osa-membership-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-osa-membership-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-osa-membership-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/constants.php';

		$this->loader = new Osa_Membership_Loader();

	}
	/**
     * Creates all the dependent objects.
     *
     * @since    1.0.0
     *
     * @access   private
     */
    private function inject_dependencies() {

        // Plugin public object.
        $this->plugin_public = new Osa_Membership_Public( $this->get_plugin_name(), $this->get_version() );

        // Plugin admin object.
        $this->plugin_admin = new Osa_Membership_Admin( $this->get_plugin_name(), $this->get_version() );
    }

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Osa_Membership_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Osa_Membership_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Osa_Membership_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		/**
		 * Add menu option to the admin panel's menu
		 */
		$this->loader->add_action('admin_menu', $plugin_admin, 'members_admin_menu');

		/**
		 * Fires ajax action
		 */
		$this->loader->add_action('wp_ajax_member_ajax_action', $plugin_admin, 'member_ajax_action');
		$this->loader->add_action('wp_ajax_nopriv_member_ajax_action', $plugin_admin, 'member_ajax_action');
		$this->loader->add_action('wp_ajax_member_details_ajax_action', $plugin_admin, 'member_details_ajax_action');
		$this->loader->add_action('wp_ajax_nopriv_member_details_ajax_action', $plugin_admin, 'member_details_ajax_action');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts' );
		//$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );
		$this->loader->add_action( 'init', $this->plugin_public, 'initFunction' );
		$this->loader->add_action('wp_ajax_getStates',$this->plugin_public, 'getStates');
		$this->loader->add_action('wp_ajax_nopriv_getStates',$this->plugin_public, 'getStates');
		$this->loader->add_action('profile_update',$this->plugin_public, 'profile');
		$this->loader->add_action('member_info',$this->plugin_public, 'member_info');
		
		
		/* if ( SLUG_VALUE == 'cancel-payment') {
			$this->loader->add_filter('template_include',$this->plugin_public, 'cancelPayment');
		}elseif(SLUG_VALUE == 'success-payment') {
			$this->loader->add_filter('template_include',$this->plugin_public, 'successPayment');
		}elseif(SLUG_VALUE == 'payment-notify'){
			$this->loader->add_filter('template_include',$this->plugin_public, 'membershipPlan');
		} */
		

	}

	  /**
     * Register all of the shortcodes provided by the plugin.
     *
     * @since    1.0.0
     *
     * @access   private
     */
    private function define_shortcodes() {
        $this->loader->add_shortcode('member_register',$this->plugin_public,'memberRegister');
		$this->loader->add_shortcode('member_login',$this->plugin_public,'memberLogin');
		$this->loader->add_shortcode('membership_plan',$this->plugin_public,'membershipPlan');
		$this->loader->add_shortcode('payment_success',$this->plugin_public,'successPayment');
		$this->loader->add_shortcode('payment_failure',$this->plugin_public,'cancelPayment');
		$this->loader->add_shortcode('forgot_password',$this->plugin_public,'forgotPassword');
		$this->loader->add_shortcode('member_listing',$this->plugin_public,'membersListing');
		
    }
	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Osa_Membership_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
