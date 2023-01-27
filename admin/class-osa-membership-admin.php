<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://odishasociety.org
 * @since      1.0.0
 *
 * @package    Osa_Membership
 * @subpackage Osa_Membership/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Osa_Membership
 * @subpackage Osa_Membership/admin
 * @author     OSA <vicepresident@odishasociety.org>
 */
class Osa_Membership_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Osa_Membership_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Osa_Membership_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/osa-membership-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Osa_Membership_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Osa_Membership_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/osa-membership-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Creates admin menu - Members.
	 */
	public function members_admin_menu()
	{
		add_menu_page('Members', 'Members', 'manage_options', 'members', array($this, 'render_member_menu_page'), 'dashicons-groups');

		add_submenu_page(
			'members',
			'Member View',
			null,
			'administrator',
			'member-view',
			array($this, 'render_member_view_page')
		);
	}

	/**
	 * Callback for admin menu
	 */
	public function render_member_menu_page()
	{
		$this->member_ajax_filter_search_scripts();
		include_once(plugin_dir_path(__FILE__) . 'partials/member_listing.php');
	}

	/**
	 * Callback for admin menu
	 */
	public function render_member_view_page()
	{
		if (isset($_GET['id'])) {

			global $wpdb;
			$member_id = $_GET['mid'];
			$id = $_GET['id'];
			$member_name = $_GET['name'];
			// $query = "SELECT * FROM `wp_member_user`";
			// $query .= " WHERE member_id LIKE $member_id ";
			// $memberData = $wpdb->get_results($query);
			// echo "<pre>";print_r($memberData);die;
			//queryto get memebr info from wp_member_user and wp_user
			$memerData = array();
			//$memerData['main_member_info']['fiirst']= $data;
			//$memerData['other_member_info']['spousse_first']= ;

			$queryex = "SELECT DATE_FORMAT(wp_users.user_registered, '%d-%m-%Y') as user_registered, wp_users.user_email, t1.first_name, t1.last_name, t1.member_id,
            wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no, 
			wp_member_other_info.souvenir, wp_member_other_info.city, wp_countries.country, wp_states.state,  
            t2.first_name as partner_first_name, t2.last_name as partner_last_name, wp_membership_type.membership, wp_chapters.name as chapter_name FROM `wp_users` 
            INNER JOIN wp_member_user t1 ON t1.user_id = wp_users.ID
            LEFT JOIN wp_member_user t2 ON t2.member_id = t1.member_id and t2.type='parent'
            INNER JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
            LEFT JOIN wp_member_membership  ON wp_member_membership.member_id = t1.member_id 
            INNER JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_membership.membership_type_id
			LEFT JOIN  wp_states ON wp_member_other_info.state_id = wp_states.state_type_id
			LEFT JOIN wp_chapters ON wp_states.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_countries ON wp_countries.country_type_id = wp_member_other_info.country_id
			";

			$query = "SELECT
			DATE_FORMAT(
				wp_users.user_registered,
				'%d-%m-%Y'
			) AS user_registered,
			wp_users.user_email,
			t1.first_name,
			t1.last_name,
			t1.member_id,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no,
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%d-%m-%Y'
			) AS membership_expiry_date,
			wp_membership_type.membership, wp_member_other_info.souvenir, wp_member_other_info.city, wp_countries.country, wp_states.state, wp_chapters.name as chapter_name
			FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			LEFT JOIN  wp_states ON wp_member_other_info.state_id = wp_states.state_type_id
			LEFT JOIN wp_chapters ON wp_states.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_countries ON wp_countries.country_type_id = wp_member_other_info.country_id
			
			";

			$query .= " WHERE t1.id = $id ";
	
			// $query .= " GROUP by t1.member_id";

			// echo $query;
			// die;

			$data = $wpdb->get_results($query);

			$parents = $wpdb->get_results(
				"SELECT  t1.first_name, t1.last_name, t1.parent_id, t2.user_email FROM wp_member_user t1
				LEFT JOIN wp_users t2 ON  t1.user_id = t2.ID
				where t1.member_id = $member_id 
				AND t1.type = 'parent' AND t1.id != '$id';"
			);

			$childs = $wpdb->get_results("SELECT  * FROM wp_member_user where member_id = $member_id AND parent_id !=0 AND type = 'child';");

			//$test = json_encode($parents);

			//$data = json_encode($data);

			wp_reset_query();
		}

		include_once(plugin_dir_path(__FILE__) . 'partials/member_view.php');
	}

	/**
	 * Register script and adds extra script to registered script
	 */
	public function member_ajax_filter_search_scripts()
	{
		wp_enqueue_script('member_ajax_filter_search', get_stylesheet_directory_uri() . plugin_dir_path(__FILE__) . 'js/osa-membership-admin.js', array(), '1.0', true);
		wp_add_inline_script('member_ajax_filter_search', 'const ajax_info = ' . json_encode(array(
			'ajax_url' => admin_url('admin-ajax.php')
		)), 'before');
	}

	/**
	 * Ajax callback function member listing
	 */
	public function member_ajax_action()
	{

		header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['page']) || isset($_GET['search'])) {

			$search = $_GET['search'];
			$orderby = $_GET['orderby'];
			$type = $_GET['type'];
			$filter_option = $_GET['filter_option'];
			$filter_input = $_GET['filter_input'];

			//need to remove
			// $queryx = "SELECT DATE_FORMAT(wp_users.user_registered, '%d-%m-%Y') as user_registered, wp_users.user_email, t1.first_name, t1.last_name, t1.member_id,
			// wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no,
			// t2.first_name as partner_first_name, t2.last_name as partner_last_name, wp_membership_type.membership FROM `wp_users` 
			// INNER JOIN wp_member_user t1 ON t1.user_id = wp_users.ID
			// LEFT JOIN wp_member_user t2 ON t2.member_id = t1.member_id and t2.type='parent'
			// LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			// LEFT JOIN wp_member_membership  ON wp_member_membership.member_id = t1.member_id 
			// INNER JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_membership.membership_type_id 
			// WHERE 1 ";

			$query = "SELECT
			DATE_FORMAT(
				wp_users.user_registered,
				'%d-%m-%Y'
			) AS user_registered,
			wp_users.user_email,
			t1.id,
			t1.first_name,
			t1.last_name,
			t1.member_id,
			t1.parent_id,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no,
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%d-%m-%Y'
			) AS membership_expiry_date,
			-- t2.first_name as partner_first_name, t2.last_name as partner_last_name, 
			wp_membership_type.membership 
			FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			-- LEFT JOIN wp_member_user t2 ON t2.member_id = t1.member_id and t2.type='parent'
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			-- LEFT JOIN wp_member_membership  ON wp_member_membership.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			LEFT JOIN  wp_states ON wp_member_other_info.state_id = wp_states.state_type_id
			LEFT JOIN wp_chapters ON wp_states.chapter_type_id = wp_chapters.chapter_type_id
		
			WHERE
			t1.type != 'child'";

            /**
			 * Proceed for search
			 */
			if (!empty($search)) {
				$query .= " AND ( wp_users.user_registered LIKE '%$search%' 
				           OR wp_users.user_email LIKE '%$search%' 
						   OR t1.member_id LIKE '%$search%' 
						   OR t1.first_name LIKE '%$search%' 
						   OR t1.last_name LIKE '%$search%'
						   OR wp_member_other_info.primary_phone_no LIKE '%$search%' 
						   OR wp_membership_type.membership LIKE '%$search%' )
						   ";
			} 
			/**
			 * Proceed for filters
			 */
			if (!empty($filter_option) && !empty($filter_input)){

				for ($i = 0; $i < count($filter_option); $i++) {

					if($filter_option[$i] == "country"){
						$query .= " AND wp_member_other_info.country_id = $filter_input[$i] ";
					} 
					else if($filter_option[$i] == "state"){
						$query .= " AND wp_member_other_info.state_id = $filter_input[$i] ";
					}
					else if($filter_option[$i] == "city"){
						$query .= " AND wp_member_other_info.city LIKE '%$filter_input[$i]%' ";
					}
					else if($filter_option[$i] == "chapter"){
						$query .= " AND wp_chapters.chapter_type_id = $filter_input[$i] ";
					}
					else if($filter_option[$i] == "membership"){
						$query .= " AND wp_member_other_info.membership_type = $filter_input[$i] ";
					}
				}
			}

			/**
			 * Proceed for sorting
			 */
			if (!empty($type)) {

				$query .= " ORDER BY " . $type . " " . $orderby . " ";
			} else {

				$query .= " ORDER BY t1.member_id " . $orderby . " ";
			}

			//$query .= " GROUP by t1.member_id ORDER BY wp_users.user_registered DESC";



			/**
			 * pagination 
			 */
			$paged = $_GET['page'];
			$results_per_page = 20;

			/**
			 * determine the sql LIMIT starting number for the results on the displaying page 
			 */
			$page_first_result = ($paged - 1) * $results_per_page;

			$total_rows = $wpdb->get_results($query);
			$total_rows = $wpdb->num_rows;

			/**
			 * retrieve the selected results from database   
			 */
			$query .=  " LIMIT " . $page_first_result . ',' . $results_per_page;

			// echo $query;
			// die;
			$data = $wpdb->get_results($query);

			wp_reset_query();

			echo json_encode(array('totalrows' => $total_rows, 'data' => $data));
		} else {
			// no posts found
		}
		wp_die();
	}

	public function country_ajax_action(){
        header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['country'])) {

			$query = "SELECT * from wp_countries ORDER BY country_type_id ASC";

			// echo $query;
			// die;
			$data = $wpdb->get_results($query);
            //echo $data;
			wp_reset_query();

			echo json_encode($data);
			
		} else {
			// no posts found
		}
		wp_die();
	}

	public function state_ajax_action(){
        header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['state'])) {

			$country = $_GET['country'] ;

			$query = "SELECT * from wp_states ";

			if(!empty($country)){
				$query .= " WHERE country_type_id = ".$country." ";
			}

			$query .= " ORDER BY state_type_id ASC ";

			$data = $wpdb->get_results($query);
            //echo $data;
			wp_reset_query();

			echo json_encode($data);
			
		} else {
			// no posts found
		}
		wp_die();
	}

	public function chapter_ajax_action(){
        header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['chapter'])) {

			$state = $_GET['state'] ;

			$query = "SELECT t1.* from wp_chapters t1
			          INNER JOIN wp_states t2 ON t1.chapter_type_id = t2.chapter_type_id " ;

			if(!empty($state)){
				$query .= " WHERE t2.state_type_id = ".$state." ";
			}

			$query .= " GROUP BY t1.chapter_type_id ORDER BY chapter_type_id ASC ";

			// echo $query;
			// die;
			$data = $wpdb->get_results($query);
            //echo $data;
			wp_reset_query();

			echo json_encode($data);
			
		} else {
			// no posts found
		}
		wp_die();
	}

	public function membership_ajax_action(){
        header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['membership'])) {

			$query = "SELECT * from wp_membership_type ORDER BY membership_type_id ASC";

			// echo $query;
			// die;
			$data = $wpdb->get_results($query);
            //echo $data;
			wp_reset_query();

			echo json_encode($data);
			
		} else {
			// no posts found
		}
		wp_die();
	}


}
