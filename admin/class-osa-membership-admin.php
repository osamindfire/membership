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

		wp_enqueue_script("member-edit", plugin_dir_url(__FILE__) . 'js/member-edit.js', array('jquery'), $this->version, false);

		wp_enqueue_script("csv-download", plugin_dir_url(__FILE__) . 'js/csv-download.js', array('jquery'), $this->version, false);

		wp_enqueue_script("deactivate", plugin_dir_url(__FILE__) . 'js/member-delete.js', array('jquery'), $this->version, false);


	}

	/**
	 * Creates admin menu - Members.
	 */
	public function members_admin_menu()
	{
		/**
		 * Add Members menu 
		 */
		add_menu_page('Members', 'Members', 'manage_options', 'members', array($this, 'render_member_menu_page'), 'dashicons-groups');

		/**
		 * Add Members view submenu
		 */
		add_submenu_page(
			'members',
			'Member View',
			null,
			'administrator',
			'member-view',
			array($this, 'render_member_view_page')
		);

		/**
		 * Add Members edit submenu
		 */
		add_submenu_page(
			'members',
			'Member Edit',
			null,
			'administrator',
			'member-edit',
			array($this, 'render_member_edit_page')
		);
	}

	/**
	 * Callback for admin menu
	 */
	public function render_member_menu_page()
	{

		include_once(plugin_dir_path(__FILE__) . 'partials/member_listing.php');

	}

	public function member_deactivate()
	{

		global $wpdb;
		if (isset($_GET['action'])) {
 
			$isDeleted = $_GET['isDeleted'] ;
			$memberId = $_GET['memberID'];

			$memID = array_unique($memberId) ;
			
			
			print_r($memID);

			// $wpdb->update('wp_member_user', $Arr, array('id' => $memID), array('%d'), array('%d'));

			$updateQuery = " UPDATE wp_member_user
			SET is_deleted = $isDeleted
			WHERE member_id IN( null " ;

            foreach($memID as $id){
				$updateQuery .= " , $id"; 
			}

			$updateQuery .= " );"; 

            $wpdb->get_results($updateQuery);


			// $deactivate = $wpdb->update('wp_member_user', $Arr, array('id' => $memberId), array('%d'), array('%d'));

			// if(is_wp_error($deactivate)){

			// 	echo 'error';
			// }else{

			wp_reset_query();

			echo 'deleted mem';
			// }
		} else {
			// no posts found
		}
		wp_die();
	}

	/**
	 * Callback for members  submenu(View)
	 */
	public function render_member_view_page()
	{
		if (isset($_GET['id'])) {

			global $wpdb;
			$member_id = $_GET['mid'];
			$id = $_GET['id'];

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

			$memberships = $wpdb->get_results("SELECT DATE_FORMAT(
				t1.start_date,
				'%d-%m-%Y'
			) AS start_date, DATE_FORMAT(
				t1.end_date,
				'%d-%m-%Y'
			) AS end_date, t2.membership, t2.fee FROM wp_member_membership t1
			INNER JOIN wp_membership_type t2 ON t1.membership_type_id = t2.membership_type_id
			 where t1.member_id = $member_id ;");



			//$test = json_encode($parents);

			//$data = json_encode($data);

			wp_reset_query();
		}

		include_once(plugin_dir_path(__FILE__) . 'partials/member_view.php');
	}

	/**
	 * Callback for members  submenu(Edit)
	 */
	public function render_member_edit_page()
	{
		global $wpdb;
		$member_id = $_GET['mid'];
		$main_id = $_GET['id'];

		if (isset($_GET['id'])) {
			$query = "SELECT
			DATE_FORMAT(
				wp_users.user_registered,
				'%d-%m-%Y'
			) AS user_registered,
			wp_users.user_email,
			t1.first_name,
			t1.last_name,
			t1.member_id,
			t1.is_deleted,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no,
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%d-%m-%Y'
			) AS membership_expiry_date,
			wp_membership_type.membership, wp_member_other_info.souvenir, 
			wp_member_other_info.city, wp_member_other_info.state_id, wp_member_other_info.country_id, wp_member_other_info.postal_code,
			wp_countries.country, wp_states.state, wp_states.chapter_type_id, wp_chapters.name as chapter_name
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

			$query .= " WHERE t1.id = $main_id ";

			// echo $query;
			// die;

			$data = $wpdb->get_results($query);

			$parents = $wpdb->get_results(
				"SELECT t1.id , t1.first_name, t1.last_name, t1.parent_id, t2.user_email FROM wp_member_user t1
				LEFT JOIN wp_users t2 ON  t1.user_id = t2.ID
				where t1.member_id = $member_id 
				AND t1.type = 'parent' AND t1.id != '$main_id';"
			);

			$childs = $wpdb->get_results("SELECT  * FROM wp_member_user where member_id = $member_id AND parent_id !=0 AND type = 'child';");

			$countries = $wpdb->get_results("SELECT  * FROM wp_countries ORDER BY priority ASC;");

			$states = $wpdb->get_results("SELECT  * FROM wp_states ;");

			$childCount = count($childs);

			//$chapters = $wpdb->get_results("SELECT  * FROM wp_chapters ;");

			//$data = json_encode($data);

			wp_reset_query();
		}

		//post
		if (isset($_POST['submit'])) {

			try {
				$errors = $this->validateForm($childCount);
				if (0 === count($errors)) {

					//main member update
					$mainArr = [];
					$mainArr['first_name'] = $_POST['first_name'];
					$mainArr['last_name'] = $_POST['last_name'];
					// $mainArr['is_deleted'] = $_POST['is_deleted'];

					$mainMember = $wpdb->update('wp_member_user', $mainArr, array('id' => $main_id), array('%s', '%s'), array('%d'));
					
					$del = $_POST['is_deleted'];
					$wpdb->update('wp_member_user', array('is_deleted' => $del ), array('member_id' => $member_id), array('%d'), array('%d'));


					//partner update
					$othArr = [];
					$othArr['first_name'] = $_POST['spouse_first_name'];
					$othArr['last_name'] = $_POST['spouse_last_name'];
					$othId = $_POST['spouse_id'];
					$othMember = $wpdb->update('wp_member_user', $othArr, array('id' => $othId), array('%s', '%s'), array('%d'));

					//child update
					if ($childCount !== 0) {
						for ($i = 0; $i < $childCount; $i++) {
							$childArr = [];
							$childArr['first_name'] = $_POST['child_first_' . $i . ''];
							$childArr['last_name'] = $_POST['child_last_' . $i . ''];
							$childId = $_POST['child_id_' . $i . ''];
							$wpdb->update('wp_member_user', $childArr, array('id' => $childId), array('%s', '%s'), array('%d'));
						}
					}

					// echo $_POST['is_deleted'];
					// die;

					//other information update
					$othInfo = [];
					$othInfo['address_line_1'] = $_POST['address_line_1'];
					$othInfo['address_line_2'] = $_POST['address_line_2'];
					$othInfo['primary_phone_no'] = $_POST['primary_phone_no'];
					$othInfo['secondary_phone_no'] = $_POST['secondary_phone_no'];
					$othInfo['city'] = $_POST['city'];
					$othInfo['souvenir'] = $_POST['souvenir'];
					$othInfo['postal_code'] = $_POST['postal_code'];
					$othInfo['state_id'] = $_POST['state_id'];
					$othInfo['country_id'] = $_POST['country_id'];

					//$othInfoId=$_POST['member_id'];

					$othinfos = $wpdb->update('wp_member_other_info', $othInfo, array('member_id' => $member_id), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d'), array('%d'));

					//echo json_encode($othInfo);


					$url = home_url('/wp-admin/admin.php?page=member-edit&mid=' . $_GET['mid'] . '&id=' . $_GET['id'] . '&success');
					//echo $url;
					// $redirectTo = home_url() . '/wp-admin/admin.php?page=member-edit&mid=16950&id=8661';
					echo "<script type='text/javascript'>window.location.href='" . $url . "'</script>";





					// echo '<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
					// 		<p><strong>Details updated.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		}

		include_once(plugin_dir_path(__FILE__) . 'partials/member_edit.php');
	}

	/**
	 *  Member edit form validations
	 */
	public function validateForm($childCount = 0)
	{
		$errors = array();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$firstName = esc_sql($_POST['first_name']);
			if (empty($firstName)) {
				$errors['first_name'] = "Please enter a First Name";
			}
			$lastName = esc_sql($_POST['last_name']);
			if (empty($lastName)) {
				$errors['last_name'] = "Please enter a Last Name";
			}

			$phone = esc_sql($_POST['primary_phone_no']);
			if (empty($phone)) {
				$errors['primary_phone_no'] = "Please enter a Phone";
			}

			if (!empty($_POST['spouse_email'])) {
				// Validate spouse  
				$spouseFirstName = esc_sql($_POST['spouse_first_name']);
				if (empty($spouseFirstName)) {
					$errors['spouse_first_name'] = "Please enter a spouse First Name";
				}
				$spouseLastName = esc_sql($_POST['spouse_last_name']);
				if (empty($spouseLastName)) {
					$errors['spouse_last_name'] = "Please enter a spouse Last Name";
				}
			}

			if ($childCount !== 0) {
				for ($i = 0; $i < $childCount; $i++) {
					if (!empty($_POST['child_id_' . $i])) {
						// Validate child  
						$childFirstName = esc_sql($_POST['child_first_' . $i]);
						if (empty($childFirstName)) {
							$errors['child_first_' . $i] = "Please enter a child First Name";
						}
						$childLastName = esc_sql($_POST['child_last_' . $i]);
						if (empty($childLastName)) {
							$errors['child_last_' . $i] = "Please enter a child Last Name";
						}
					}
				}
			}


			$addressLine1 = esc_sql($_POST['address_line_1']);
			if (empty($addressLine1)) {
				$errors['address_line_1'] = "Please enter address";
			}

			$city = esc_sql($_POST['city']);
			if (empty($city)) {
				$errors['city'] = "Please enter city";
			}

			$postalCode = esc_sql($_POST['postal_code']);
			if (empty($postalCode)) {
				$errors['postal_code'] = "Please enter Postal Code";
			}

			$country = esc_sql($_POST['country_id']);
			if (empty($country)) {
				$errors['country'] = "Please select Country";
			}

			$state = esc_sql($_POST['state_id']);
			if (empty($state)) {
				$errors['state'] = "Please select State";
			}
		}
		return $errors;
	}

	/**
	 * Ajax callback function member listing
	 */
	public function member_ajax_action()
	{

		header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['page']) || isset($_GET['search']) || isset($_GET['action']) == 'download_csv_file') {

			$search = $_GET['search'];
			$orderby = $_GET['orderby'];
			$type = $_GET['type'];
			$filter_option = $_GET['filter_option'];
			$filter_input = $_GET['filter_input'];

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
			t1.is_deleted,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no, 
			wp_member_other_info.city, wp_member_other_info.postal_code, wp_states.state, wp_chapters.name as chapter_name, wp_countries.country, 
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
			LEFT JOIN wp_countries ON wp_countries.country_type_id = wp_member_other_info.country_id

		
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
			if (!empty($filter_option) && !empty($filter_input)) {

				for ($i = 0; $i < count($filter_option); $i++) {

					if ($filter_option[$i] == "country") {
						$query .= " AND wp_member_other_info.country_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "state") {
						$query .= " AND wp_member_other_info.state_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "city") {
						$query .= " AND wp_member_other_info.city LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "chapter") {
						$query .= " AND wp_chapters.chapter_type_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "membership") {
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

	public function country_ajax_action()
	{
		header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['country'])) {

			$query = "SELECT * from wp_countries ORDER BY priority ASC";

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

	public function state_ajax_action()
	{
		header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['state'])) {

			$country = $_GET['country'];

			$query = "SELECT * from wp_states ";

			if (!empty($country)) {
				$query .= " WHERE country_type_id = " . $country . " ";
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

	public function chapter_ajax_action()
	{
		header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['chapter'])) {

			$state = $_GET['state'];

			$query = "SELECT t1.* from wp_chapters t1
			          INNER JOIN wp_states t2 ON t1.chapter_type_id = t2.chapter_type_id ";

			if (!empty($state)) {
				$query .= " WHERE t2.state_type_id = " . $state . " ";
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

	public function membership_ajax_action()
	{
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
