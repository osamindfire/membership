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
		 * Add MemberShip Plans
		 */
		add_submenu_page('members', 'Membership Plans', 'Membership Plans', 'administrator', 'membershipplan-listing', array($this, 'render_membershipplan_listing_page'));

		/**
		 * Add Members setting submenu
		 */
		add_submenu_page('members', 'Settings', 'Settings', 'administrator', 'member-settings', array($this, 'render_members_setting_page'));

		/**
		 * Add Members view submenu
		 */
		if ((isset($_GET['page'])) && ($_GET['page'] === 'member-view')) {
			add_submenu_page('members', 'Member View', null, 'manage_options', 'member-view', array($this, 'render_member_view_page'));
		}

		/**
		 * Add Members edit submenu
		 */
		if ((isset($_GET['page'])) && ($_GET['page'] === 'member-edit')) {
			add_submenu_page('members', 'Member Edit', null, 'administrator', 'member-edit', array($this, 'render_member_edit_page'));
		}

		/**
		 * Add MemberShip add submenu
		 */
		if ((isset($_GET['page'])) && ($_GET['page'] === 'membershipplan-add')) {
			add_submenu_page('members', 'Membership Add', null, 'administrator', 'membershipplan-add', array($this, 'render_membershipplan_add_page'));
		}
		/**
		 * Add MemberShip edit submenu
		 */
		if ((isset($_GET['page'])) && ($_GET['page'] === 'membershipplan-edit')) {
			add_submenu_page('members', 'Membership Edit', null, 'administrator', 'membershipplan-edit', array($this, 'render_membershipplan_edit_page'));
		}
		add_submenu_page('members', 'Assign Membership', null, 'administrator', 'assign-membership', array($this, 'render_assign_membership'));
	}

	/**
	 * Callback for members submenu(settings)
	 */
	public function render_members_setting_page()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$errors = [];
				// $authTokenUrl = esc_sql($_POST['auth_token_url']);
				// if (empty($authTokenUrl)) {
				// 	$errors['auth_token_url'] = "Auth Token Url cannot be blank";
				// }

				$authClientId = esc_sql($_POST['auth_client_id']);
				if (empty($authClientId)) {
					$errors['auth_client_id'] = "Auth Client Id cannot be blank";
				}
				$authClientSecret = esc_sql($_POST['auth_client_secret']);
				if (empty($authClientSecret)) {
					$errors['auth_client_secret'] = "Auth Client Secret cannot be blank";
				}
				$refreshToken = esc_sql($_POST['refresh_token']);
				if (empty($refreshToken)) {
					$errors['refresh_token'] = "Refresh Token cannot be blank";
				}
				$accessToken = esc_sql($_POST['access_token']);
				if (empty($accessToken)) {
					$errors['access_token'] = "Access Token cannot be blank";
				}
				// $addMemberUrl = esc_sql($_POST['add_member_url']);
				// if (empty($addMemberUrl)) {
				// 	$errors['add_member_url'] = "Add Member URL cannot be blank";
				// }
				$appKey = esc_sql($_POST['app_key']);
				if (empty($appKey)) {
					$errors['app_key'] = "App Key cannot be blank";
				}

				// echo trim($authClientId);
				// echo str_replace(' ', '', $authClientId);
				// die;

				if (0 === count($errors)) {
					$options = [];
					// $options['auth_token_url'] = $authTokenUrl;
					$options['auth_client_id'] = str_replace(' ', '', $authClientId);
					$options['auth_client_secret'] = str_replace(' ', '', $authClientSecret);
					$options['refresh_token'] = str_replace(' ', '', $refreshToken);
					$options['access_token'] = str_replace(' ', '', $accessToken);
					// $options['add_member_url'] = $addMemberUrl ;
					$options['app_key'] = str_replace(' ', '', $appKey);

					foreach ($options as $key => $value) {
						update_option($key, $value);
					}

					echo '<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
					<p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss success-notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		}
		include_once(plugin_dir_path(__FILE__) . 'partials/settings.php');
	}

	/**
	 * Callback for members submenu (Membership View)
	 */
	public function render_membershipplan_listing_page()
	{
		global $wpdb;
		$membershipPlans = $wpdb->get_results("SELECT  * FROM wp_membership_type ;");
		include_once(plugin_dir_path(__FILE__) . 'partials/membership_plans/membershiplan_listing.php');
	}

	/**
	 * Callback for members  submenu( Membership Edit)
	 */
	public function render_membershipplan_edit_page()
	{
		global $wpdb;

		if (isset($_POST['membershiplan_form']) && wp_verify_nonce($_POST['membershiplan_form'], 'membershiplan')) {
			try {
				$errors = [];
				$membership = esc_sql($_POST['membership']);
				if (empty($membership)) {
					$errors['membership'] = "Membership cannot be blank";
				}

				$fee = esc_sql($_POST['fee']);
				if (empty($fee)) {
					$errors['fee'] = "Please enter fee";
				}
				$type = esc_sql($_POST['type']);
				if (empty($type)) {
					$errors['type'] = "Please enter Type";
				}
				/* $total_days = esc_sql($_POST['total_days']);
				if (empty($total_days)) {
					$errors['total_days'] = "Please enter duration";
				} */
				if (0 === count($errors)) {

					//main member update
					$mainArr = [];
					$mainArr['membership'] = $_POST['membership'];
					$mainArr['type'] = $_POST['type'];
					$mainArr['fee'] = $_POST['fee'];
					$mainArr['total_days'] = !empty(esc_sql($_POST['total_days'])) ? $_POST['total_days'] : 0;
					$mainArr['status'] = $_POST['status'];
					$result = $wpdb->update('wp_membership_type', $mainArr, array('membership_type_id' => $_GET['id']), array('%s', '%d', '%d', '%d', '%d'), array('%d'));
					$url = home_url('/wp-admin/admin.php?page=membershipplan-edit&id=' . $_GET['id'] . '&success');
					echo "<script type='text/javascript'>window.location.href='" . $url . "'</script>";
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		}
		if (isset($_GET['id'])) {

			$id = $_GET['id'];
			$query = "SELECT wp_membership_type.* FROM `wp_membership_type` ";
			$query .= " WHERE membership_type_id = $id ";
			$data = $wpdb->get_results($query);
			$membershipPlan = $data[0];
			wp_reset_query();
		}

		include_once(plugin_dir_path(__FILE__) . 'partials/membership_plans/membership_plan_edit.php');
	}

	/**
	 * Callback for members submenu (Membership Add)
	 */
	public function render_membershipplan_add_page()
	{
		global $wpdb;
		if (isset($_POST['membershiplan_form']) && wp_verify_nonce($_POST['membershiplan_form'], 'membershiplan')) {
			try {
				$errors = [];
				echo "<pre>";
				print_r($_POST);
				die;
				$membership = esc_sql($_POST['membership']);
				if (empty($membership)) {
					$errors['membership'] = "Membership cannot be blank";
				}

				$fee = esc_sql($_POST['fee']);
				if (empty($fee)) {
					$errors['fee'] = "Please enter fee";
				}
				$type = esc_sql($_POST['type']);
				if (empty($type)) {
					$errors['type'] = "Please enter Type";
				}

				//$total_days = !empty(esc_sql($_POST['total_days'])) ? $_POST['total_days'] : 0;
				/* if (isset($total_days)) {
					$errors['total_days'] = "Please enter duration";
				} */
				if (0 === count($errors)) {
					$mainArr = [];
					$mainArr['membership'] = $_POST['membership'];
					$mainArr['type'] = $_POST['type'];
					$mainArr['fee'] = $_POST['fee'];
					$mainArr['total_days'] = !empty(esc_sql($_POST['total_days'])) ? $_POST['total_days'] : 0;
					$mainArr['status'] = $_POST['status'];
					$wpdb->query($wpdb->prepare(
						"INSERT INTO wp_membership_type (membership, type, fee, total_days, status) VALUES ( %s, %d, %d, %d, %d)",
						array(
							'membership' => $_POST['membership'],
							'type' => $_POST['type'],
							'fee' => $_POST['fee'],
							'total_days' => $_POST['total_days'],
							'status' => $_POST['status']
						)
					));
					//$result = $wpdb->update('wp_membership_type', $mainArr, array('membership_type_id' => $_GET['id']), array('%s','%d','%d','%d','%d'), array('%d'));
					$url = home_url('/wp-admin/admin.php?page=membershipplan-listing&success=1');
					echo "<script type='text/javascript'>window.location.href='" . $url . "'</script>";
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		}
		include_once(plugin_dir_path(__FILE__) . 'partials/membership_plans/membership_plan_add.php');
	}
	public function render_assign_membership()
	{
		global $wpdb,$user_ID;
		$membershipPlans = $wpdb->get_results("SELECT  wp_membership_type.* FROM wp_membership_type where status= 1 ");

		if (isset($_POST['assign_membershiplan_form']) && wp_verify_nonce($_POST['assign_membershiplan_form'], 'assign_membership_plan')) {
			try {
				$errors = [];
				$membership = esc_sql($_POST['membership_type']);
				if (empty($membership)) {
					$errors['membership_type'] = "Please select Membership Plan";
				}

				$fee = esc_sql($_POST['transaction_id_and_check_no']);
				if (empty($fee)) {
					$errors['transaction_id_and_check_no'] = "Please enter Transaction Id / Check No.";
				}

				if (0 === count($errors)) {
					$userInfo = $wpdb->get_results("SELECT wp_users.user_nicename, wp_users.user_email,wp_member_user.user_id,wp_member_user.member_id,wp_member_user.first_name,wp_member_user.last_name,wp_users.user_email FROM wp_users INNER JOIN wp_member_user ON wp_users.ID=wp_member_user.user_id WHERE wp_member_user.member_id  = " . $_GET['mid'] . " limit 1");
					$starttDate = date('Y-m-d');
					$endDate = date('Y-m-d', strtotime($starttDate . ' + ' . $_POST['total_days'] . ' days'));
					$membershipType =  $_POST['membership_type'];
					$wpdb->query($wpdb->prepare(
						"INSERT INTO wp_member_membership (user_id, member_id, start_date, end_date, membership_type_id, comment , update_by,payment_info) VALUES ( %d, %d, %s, %s, %d, %s, %s,%s)",
						array(
							'user_id' => $userInfo[0]->user_id,
							'member_id' => $_GET['mid'],
							'start_date' =>  $starttDate,
							'end_date' => $endDate,
							'membership_type_id' => $membershipType,
							'comment' => $_POST['transaction_id_and_check_no'],
							'update_by' => $user_ID,
							'payment_info' => serialize($_POST),
						)
					));
					$result= $wpdb->query(
						$wpdb->prepare("UPDATE wp_member_other_info 
					SET membership_expiry_date = %s,membership_type = %d 
					WHERE member_id = %d", $endDate, $membershipType, $_GET['mid'])
					);
					$otherPartenruserInfo = $wpdb->get_results("SELECT wp_users.user_email FROM wp_users INNER JOIN wp_member_user ON wp_users.ID=wp_member_user.user_id WHERE wp_member_user.member_id  = " . $_GET['mid'] . " and type !='child' ");

					$membershipPackage = $wpdb->get_results("SELECT wp_membership_type.* FROM wp_membership_type  WHERE membership_type_id  = " . $membershipType . " limit 1");
					if($result)
					{
					$subject = "Membership Plan Assigned and Approved successfully";
					$userInfo[0]->user_membership = $membershipPackage[0];
					$this->sendMail($userInfo[0]->user_email, $subject, (array)$userInfo[0]);

					$gsuite = new Osa_Membership_G_Suite();
					foreach($otherPartenruserInfo as $othMemberValue){
					$accessToken = $gsuite->reFreshGsuiteAccessToken();
					$gsuite->addMemberToGsuiteGroup($accessToken, $othMemberValue->user_email);
					}
					}

					$url = home_url('/wp-admin/admin.php?page=member-view&mid='.$_GET['mid'].'&id='.$_GET['id'].'&message='.$subject.' ');
					echo "<script type='text/javascript'>window.location.href='" . $url . "'</script>";
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		}
		include_once(plugin_dir_path(__FILE__) . 'partials/assign_membership.php');
	}
	public function sendMail($to, $subject, $data = array(), $type = '')
	{

		ob_start();
		include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/payment_success_email.php');
		$headers = array('Content-Type: text/html; charset=UTF-8');
		try {
			$response = wp_mail($to, $subject, $emailBody, $headers);
			return $response;
		} catch (Exception $e) {
			echo 'Error while sendnig mail: ',  $e->getMessage(), "\n";
		}
		return ob_get_clean();
	}

	/**
	 * Callback for admin menu
	 */
	public function render_member_menu_page()
	{

		include_once(plugin_dir_path(__FILE__) . 'partials/member_listing.php');
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
				'%m-%d-%Y'
			) AS user_registered,
			wp_users.user_email,
			t1.first_name,
			t1.last_name,
			t1.alive,
			t1.member_id,t1.phone_no,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, 
			-- wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no,
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%m-%d-%Y'
			) AS membership_expiry_date,
			wp_membership_type.membership, wp_member_other_info.souvenir,
			 wp_member_other_info.city, wp_member_other_info.chapter_type_id as chapter_id,
			  wp_countries.country, wp_states.state, wp_chapters.name as chapter_name
			FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			LEFT JOIN  wp_states ON wp_member_other_info.state_id = wp_states.state_type_id
			-- LEFT JOIN wp_chapters ON wp_states.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_chapters ON wp_member_other_info.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_countries ON wp_countries.country_type_id = wp_member_other_info.country_id
			
			";

			$query .= " WHERE t1.id = $id ";

			// $query .= " GROUP by t1.member_id";

			// echo $query;
			// die;

			$data = $wpdb->get_results($query);

			$parents = $wpdb->get_results(
				"SELECT  t1.first_name, t1.last_name, t1.parent_id,t1.phone_no, t2.user_email FROM wp_member_user t1
				LEFT JOIN wp_users t2 ON  t1.user_id = t2.ID
				where t1.member_id = $member_id 
				AND t1.type = 'parent' AND t1.id != '$id';"
			);

			$childs = $wpdb->get_results("SELECT  * FROM wp_member_user where member_id = $member_id AND parent_id !=0 AND type = 'child';");

			$memberships = $wpdb->get_results("SELECT DATE_FORMAT(
				t1.start_date,
				'%m-%d-%Y'
			) AS start_date, DATE_FORMAT(
				t1.end_date,
				'%m-%d-%Y'
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
				'%m-%d-%Y'
			) AS user_registered,
			wp_users.user_email,
			t1.user_id,
			t1.alive,
			t1.first_name,
			t1.last_name,
			t1.member_id, t1.parent_id, 
			t1.is_deleted,t1.phone_no,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, 
			-- wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no,
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%m-%d-%Y'
			) AS membership_expiry_date,
			wp_membership_type.membership,wp_membership_type.type as membership_type, wp_member_other_info.souvenir, 
			wp_member_other_info.city, wp_member_other_info.state_id, wp_member_other_info.country_id, wp_member_other_info.chapter_type_id as chapter_id,
			wp_member_other_info.postal_code,
			wp_countries.country, wp_states.state, wp_states.chapter_type_id, wp_chapters.name as chapter_name
			FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			LEFT JOIN  wp_states ON wp_member_other_info.state_id = wp_states.state_type_id
			-- LEFT JOIN wp_chapters ON wp_states.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_chapters ON wp_member_other_info.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_countries ON wp_countries.country_type_id = wp_member_other_info.country_id
			
			";

			$query .= " WHERE t1.id = $main_id ";

			// echo $query;
			// die;

			$data = $wpdb->get_results($query);

			$parents = $wpdb->get_results(
				"SELECT t1.id, t1.user_id, t1.alive, t1.first_name, t1.last_name, t1.parent_id,t1.phone_no, t2.user_email FROM wp_member_user t1
				LEFT JOIN wp_users t2 ON  t1.user_id = t2.ID
				where t1.member_id = $member_id 
				AND t1.type = 'parent' AND t1.id != '$main_id';"
			);

			$childs = $wpdb->get_results("SELECT  * FROM wp_member_user where member_id = $member_id AND parent_id !=0 AND type = 'child';");

			$countries = $wpdb->get_results("SELECT  * FROM wp_countries ORDER BY priority ASC;");

			$states = $wpdb->get_results("SELECT  * FROM wp_states ;");

			$chapters = $wpdb->get_results("SELECT  * FROM wp_chapters ;");


			$childCount = count($childs);

			if (empty($parents)) {
				$parentCount = 0;
			} else $parentCount = 1;

			//$chapters = $wpdb->get_results("SELECT  * FROM wp_chapters ;");

			//$data = json_encode($data);

			wp_reset_query();
		}

		//post
		if (isset($_POST['submit'])) {

			try {
				$errors = $this->validateForm($childCount, $parentCount);

				/* Update user password. */
				$user_id = $_POST['user_id'];
				
				
				if(!empty($_POST['password']))
				{
					$passwordResponse = $this->isPasswordValid($_POST['password']);
					if($passwordResponse['status'] == 0){ $errors['password'] = $passwordResponse['message'];}
					$passwordResponse = $this->isPasswordValid($_POST['confirm_password']);
					if($passwordResponse['status'] == 0){ $errors['confirmPassword'] = $passwordResponse['message'];}
					if (trim($_POST['password'])!= trim($_POST['confirm_password'])) {
						$errors['confirmPassword'] = 'The passwords you entered do not match';
					}else{
						$update_pass = wp_set_password(esc_sql($_POST['password']), $user_id);
						if (is_wp_error($update_pass)) {
						$errors['password'] = 'Error in updating password';
					}
					}
				
				} 
				
				/* End update user password. */

				if (0 === count($errors)) {

					// user/member email update
					$userArr = [];
					$user_id = $_POST['user_id'];
					$userArr['user_email'] = $_POST['user_email'];
					$userArr['user_login'] = $_POST['user_email'];

					$user = $wpdb->update('wp_users', $userArr, array('ID' => $user_id), array('%s', '%s'), array('%d'));

					//main member update
					$mainArr = [];
					$mainArr['first_name'] = $_POST['first_name'];
					$mainArr['last_name'] = $_POST['last_name'];
					$mainArr['alive'] = $_POST['status'];
					$mainArr['phone_no'] = $_POST['phone_no'];

					$mainMember = $wpdb->update('wp_member_user', $mainArr, array('id' => $main_id), array('%s', '%s', '%d', '%s'), array('%d'));

					// update first name in user table
					$fisrtArr = array('user_nicename' => $_POST['first_name'], 'display_name' => $_POST['first_name']);
					$wpdb->update('wp_users', $fisrtArr, array('ID' => $user_id), array('%s', '%s'), array('%d'));

					// echo $mainMember;
					// die;

					$del = $_POST['is_deleted'];
					$wpdb->update('wp_member_user', array('is_deleted' => $del), array('member_id' => $member_id), array('%d'), array('%d'));
					$this->removeMemberfromGsuiteByEmailId($member_id);

					//partner update
					if (!empty($_POST['spouse_first_name'])) {
						$othArr = [];
						$othArr['first_name'] = $_POST['spouse_first_name'];
						$othArr['last_name'] = $_POST['spouse_last_name'];
						$othArr['alive'] = $_POST['spouse_status'];
						$othArr['phone_no'] = $_POST['spouse_phone_no'];
						$othId = $_POST['spouse_id'];

						if (!empty($othId)) {
							$othMember = $wpdb->update('wp_member_user', $othArr, array('id' => $othId), array('%s', '%s', '%d', '%s'), array('%d'));

							// spouse email update
							$spouseUserArr = [];
							$spouseUserId = $_POST['spouse_user_id'];
							$spouseUserArr['user_email'] = $_POST['spouse_email'];
							$spouseUserArr['user_login'] = $_POST['spouse_email'];
							$user = $wpdb->update('wp_users', $spouseUserArr, array('ID' => $spouseUserId), array('%s', '%s'), array('%d'));

							// update first name in user table
							$spouseFisrtArr = array('user_nicename' => $_POST['spouse_first_name'], 'display_name' => $_POST['spouse_first_name']);
							$wpdb->update('wp_users', $spouseFisrtArr, array('ID' => $spouseUserId), array('%s', '%s'), array('%d'));
						} else {
							$username = $_POST['spouse_email'];
							$password = $_POST['spouse_password'];
							$email = $_POST['spouse_email'];
							//add spouse
							if (!empty($username) && !empty($email)) {
								$userId = wp_create_user($username, $password, $email);

								if ($userId) {
									$wpdb->update('wp_users', ['display_name' => $_POST['spouse_first_name'], 'user_nicename' => $_POST['spouse_first_name']], array('ID' => $userId), array('%s', '%s'), array('%d'));
									add_user_meta($userId, 'wp_capabilities', 'a:1:{s:10:"subscriber";b:1;}', true);
									$wpdb->query($wpdb->prepare(
										"INSERT INTO wp_member_user (user_id, member_id, parent_id, first_name, last_name, phone_no, type , modified_date, alive, email_valid, is_deleted) VALUES ( %d, %d, %d, %s, %s, %s, %s, %s, %d, %d, %d)",
										array(
											'user_id' => $userId,
											'member_id' => $member_id,
											'parent_id' =>  $main_id,
											'first_name' => $_POST['spouse_first_name'],
											'last_name' => $_POST['spouse_last_name'],
											'phone_no' => !empty($_POST['spouse_phone_no']) ? $_POST['spouse_phone_no'] : '',
											'type' => 'parent',
											'modified_date' => date('Y-m-d H:i:s'),
											'alive' => 1,
											'email_valid' => 1,
											'is_deleted' =>  0
										)
									));
								}
							}
						}
					}
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
					$othInfo['city'] = $_POST['city'];
					$othInfo['souvenir'] = $_POST['souvenir'];
					$othInfo['postal_code'] = $_POST['postal_code'];
					$othInfo['state_id'] = $_POST['state_id'];
					$othInfo['country_id'] = $_POST['country_id'];
					$othInfo['chapter_type_id'] = $_POST['chapter_id'];

					//$othInfoId=$_POST['member_id'];

					$othinfos = $wpdb->update('wp_member_other_info', $othInfo, array('member_id' => $member_id), array('%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d'), array('%d'));

					//echo json_encode($othInfo);


					$url = home_url('/wp-admin/admin.php?page=member-edit&mid=' . $_GET['mid'] . '&id=' . $_GET['id'] . '&success');
					echo "<script type='text/javascript'>window.location.href='" . $url . "'</script>";
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
	public function validateForm($childCount = 0, $parentCount)
	{
		$errors = array();
		global $wpdb;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$firstName = esc_sql($_POST['first_name']);
			if (!trim($firstName ?? '')) {
				$errors['first_name'] = "Please enter a First Name";
			}
			$lastName = esc_sql($_POST['last_name']);
			if (!trim($lastName ?? '')) {
				$errors['last_name'] = "Please enter a Last Name";
			}

			// validate phone 
			$phone = esc_sql($_POST['phone_no']);
			$spousePhone = esc_sql($_POST['spouse_phone_no']);
			if ($_POST['parent_id'] == 0) {
				if (!trim($phone ?? '')) {
					$errors['phone_no'] = "Please enter a Phone";
				}
			} else {
				if (!trim($spousePhone ?? '')) {
					$errors['spouse_phone_no'] = "Please enter a Phone";
				}
			}

			if (!empty($phone)) {
				$valid = $this->validatePhoneNo($phone);
				if (!$valid) {
					$errors['phone_no'] = "Please enter valid format +1-XXX-XXX-XXXX";
				};
			}
			if (!empty($spousePhone)) {
				$sValid = $this->validatePhoneNo($spousePhone);
				if (!$sValid) {
					$errors['spouse_phone_no'] = "Please enter valid format +1-XXX-XXX-XXXX";
				};
			}

			// Check email address is present and valid  
			$user_emails = $wpdb->get_results("SELECT user_email FROM wp_users WHERE ID !=" . $_POST['user_id'] . " and user_email  = '" . $_POST['user_email'] . "' ");

			$userEmail = esc_sql($_POST['user_email']);
			if (isset($_POST['user_email']) && empty($userEmail)) {
				$errors['user_email'] = "Please enter a Partner Email";
			} elseif (isset($_POST['user_email']) && !is_email($userEmail)) {
				$errors['user_email'] = "Please enter a valid Email";
			} elseif (isset($_POST['user_email']) && !empty($user_emails)) {
				$errors['user_email'] = "This email address is already in use";
			}
			// } elseif (isset($_POST['user_email']) && (email_exists($userEmail) || username_exists($userEmail))) {
			// 	$errors['user_email'] = "This email address is already in use";
			// }

			if (!empty($_POST['spouse_first_name']) && $parentCount == 0) {
				// Validate spouse  
				$spouseFirstName = esc_sql($_POST['spouse_first_name']);
				if (!trim($spouseFirstName ?? '')) {
					$errors['spouse_first_name'] = "Please enter a Partner First Name";
				}
				$spouseLastName = esc_sql($_POST['spouse_last_name']);
				if (!trim($spouseLastName ?? '')) {
					$errors['spouse_last_name'] = "Please enter a Partner Last Name";
				}

				// Check email address is present and valid  
				$spouseEmail = esc_sql($_POST['spouse_email']);
				if (isset($_POST['spouse_email']) && empty($spouseEmail)) {
					$errors['spouse_email'] = "Please enter a Partner Email";
				} elseif (isset($_POST['spouse_email']) && !is_email($spouseEmail)) {
					$errors['spouse_email'] = "Please enter a valid Email";
				} elseif (isset($_POST['spouse_email']) && (email_exists($spouseEmail) || username_exists($spouseEmail))) {
					$errors['spouse_email'] = "This email address is already in use";
				}

				// Check password is valid  
				$spousePassword = esc_sql($_POST['spouse_password']);
				$passwordResponse = $this->isPasswordValid($spousePassword);
				if($passwordResponse['status'] == 0){ $errors['spouse_password'] = $passwordResponse['message'];}

				/* if (isset($_POST['spouse_password']) && empty($spousePassword)) {
					$errors['spouse_password'] = "Please enter a Partner Password";
				} elseif (isset($_POST['spouse_password']) && (0 === preg_match("/.{6,}/", $_POST['spouse_password']))) {
					$errors['spouse_password'] = "Password must be at least six";
				}elseif( isset($_POST['spouse_password']) && !preg_match("/^(?!(?:[a-z]+|[0-9]+)$)[a-z0-9]+$/i", $_POST['spouse_password']))
				{
					$errors['spouse_password'] = "Please enter alphanumeric characters only";
				} */

				// Check password confirmation_matches
				$cSpousePassword = esc_sql($_POST['spouse_confirm_password']);
				$passwordResponse = $this->isPasswordValid($cSpousePassword);
				if($passwordResponse['status'] == 0){ $errors['spouse_confirm_password'] = $passwordResponse['message'];}
				elseif (isset($_POST['spouse_password']) && (0 !== strcmp($_POST['spouse_password'], $_POST['spouse_confirm_password']))) {
					$errors['spouse_confirm_password'] = "Spouse Passwords do not match";
				}

				/* if (isset($_POST['spouse_password']) && empty($cSpousePassword)) {
					$errors['spouse_confirm_password'] = "Please enter a Partner Password";
				}elseif( isset($_POST['spouse_confirm_password']) && !preg_match("/^(?!(?:[a-z]+|[0-9]+)$)[a-z0-9]+$/i", $_POST['spouse_confirm_password']))
				{
					$errors['spouse_confirm_password'] = "Please enter alphanumeric characters only";
				} elseif (isset($_POST['spouse_password']) && (0 !== strcmp($_POST['spouse_password'], $_POST['spouse_confirm_password']))) {
					$errors['spouse_confirm_password'] = "Spouse Passwords do not match";
				} */
			} else if ($parentCount == 1) {
				// Validate spouse  
				$spouseFirstName = esc_sql($_POST['spouse_first_name']);
				if (!trim($spouseFirstName ?? '')) {
					$errors['spouse_first_name'] = "Please enter a partner First Name";
				}
				$spouseLastName = esc_sql($_POST['spouse_last_name']);
				if (!trim($spouseLastName ?? '')) {
					$errors['spouse_last_name'] = "Please enter a partner Last Name";
				}

				$spouse_emails = $wpdb->get_results("SELECT user_email FROM wp_users WHERE ID !=" . $_POST['spouse_user_id'] . " and user_email  = '" . $_POST['spouse_email'] . "' ");

				// Check email address is present and valid  
				$spouseEmail = esc_sql($_POST['spouse_email']);
				if (isset($_POST['spouse_email']) && empty($spouseEmail)) {
					$errors['spouse_email'] = "Please enter a Partner Email";
				} elseif (isset($_POST['spouse_email']) && !is_email($spouseEmail)) {
					$errors['spouse_email'] = "Please enter a valid Email";
				} elseif (isset($_POST['spouse_email']) && !empty($spouse_emails)) {
					$errors['spouse_email'] = "This email address is already in use";
				}
			}

			if ($childCount !== 0) {
				for ($i = 0; $i < $childCount; $i++) {
					if (!empty($_POST['child_id_' . $i])) {
						// Validate child  
						$childFirstName = esc_sql($_POST['child_first_' . $i]);
						if (!trim($childFirstName ?? '')) {
							$errors['child_first_' . $i] = "Please enter a child First Name";
						}
						$childLastName = esc_sql($_POST['child_last_' . $i]);
						if (!trim($childLastName ?? '')) {
							$errors['child_last_' . $i] = "Please enter a child Last Name";
						}
					}
				}
			}

			$addressLine1 = esc_sql($_POST['address_line_1']);
			if (!trim($addressLine1 ?? '')) {
				$errors['address_line_1'] = "Please enter address";
			}

			$city = esc_sql($_POST['city']);
			if (!trim($city ?? '')) {
				$errors['city'] = "Please enter city";
			}

			$postalCode = esc_sql($_POST['postal_code']);
			if (!trim($postalCode ?? '')) {
				$errors['postal_code'] = "Please enter Postal Code";
			}

			$country = esc_sql($_POST['country_id']);
			if (!trim($country ?? '')) {
				$errors['country'] = "Please select Country";
			}

			$state = esc_sql($_POST['state_id']);
			if (!trim($state ?? '')) {
				$errors['state'] = "Please select State";
			}
		}

		return $errors;
	}
	function isPasswordValid($password){

		$status = 0;
		if(!empty($password))
		{
		$whiteListed = "\$\@\#\^\|\!\~\=\+\-\_\.";
		$message = "Password is invalid";
		$containsLetter  = preg_match('/[a-zA-Z]/', $password);
		$containsDigit   = preg_match('/\d/', $password);
		$containsSpecial = preg_match('/['.$whiteListed.']/', $password);
		$containsAnyOther = preg_match('/[^A-Za-z-\d'.$whiteListed.']/', $password);
		if (strlen($password) < 6 ) $message = "Password should be at least 6 characters long";
		//else if (strlen($password) > 20 ) $message = "Password should be at maximum 20 characters long";
		else if(!$containsLetter) $message = "Password should contain at least one letter.";
		else if(!$containsDigit) $message = "Password should contain at least one number.";
		else if(!$containsSpecial) $message = "Password should contain at least one of these ".stripslashes( $whiteListed )." ";
		else if($containsAnyOther) $message = "Password should contain only the mentioned characters";
		else {
			$status = 1;
			$message = "Password is valid";
		}
		}else{
			$message = 'Please enter a Password';
		}
		return array(
			"status" => $status,
			"message" => $message
		);
}

	private function validatePhoneNo($phone)
	{
		$toArr = str_split($phone);
		$valid = 1;
		if ($phone[0] != '+' || $phone[1] != '1' || $phone[2] != '-' || $phone[6] != '-' || $phone[10] != '-' || count($toArr) != 15) {
			$valid = 0;
		}
		return $valid;
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
			$rowLimit = $_GET['row_limit'];

			$query = "SELECT
			DATE_FORMAT(
				wp_users.user_registered,
				'%m-%d-%Y'
			) AS user_registered,
			wp_users.user_email,
			t1.id, t1.user_id,
			t1.first_name,
			t1.last_name,
			t1.member_id,
			t1.parent_id,
			t1.is_deleted, t1.phone_no,wp_member_other_info.membership_type,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, 
			-- wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no, 
			wp_member_other_info.city, wp_member_other_info.postal_code, wp_states.state, wp_chapters.name as chapter_name, wp_countries.country, 
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%m-%d-%Y'
			) AS membership_expiry_date,
			-- t2.first_name as partner_first_name, t2.last_name as partner_last_name, 
			wp_membership_type.membership,wp_membership_type.membership_type_id  
			FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			-- LEFT JOIN wp_member_user t2 ON t2.member_id = t1.member_id and t2.type='parent'
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			-- LEFT JOIN wp_member_membership  ON wp_member_membership.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			LEFT JOIN  wp_states ON wp_member_other_info.state_id = wp_states.state_type_id
			-- LEFT JOIN wp_chapters ON wp_states.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_chapters ON wp_member_other_info.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_countries ON wp_countries.country_type_id = wp_member_other_info.country_id

		
			WHERE
			t1.type != 'child'";

			/**
			 * Proceed for search
			 */
			if (!empty($search)) {
				$search_keywords = explode(" ", $search);

				foreach ($search_keywords as $search) {

					$query .= " AND ( ";
					if (DateTime::createFromFormat('d-m-Y', $search) !== false) {
						// $date = date('Y-m-d', strtotime($search));
						$date= DateTime::createFromFormat('m-d-Y', $search)->format('Y-m-d');
						$query .= " wp_users.user_registered LIKE '%$date%' ";
					}

					if (DateTime::createFromFormat('d-m-Y', $search) !== false) {
						// $date = date('Y-m-d', strtotime($search));
						$date= DateTime::createFromFormat('m-d-Y', $search)->format('Y-m-d');
						$query .= "OR wp_member_other_info.membership_expiry_date LIKE '%$date%' OR";
					}

					$query .= " wp_users.user_email LIKE '%$search%' 
						   OR t1.member_id LIKE '%$search%' 
						   OR t1.first_name LIKE '%$search%' 
						   OR t1.last_name LIKE '%$search%'
						   OR t1.phone_no LIKE '%$search%' 
						   OR wp_membership_type.membership LIKE '%$search%' )
						   ";
				}
			}
			/**
			 * Proceed for filters
			 */
			if (!empty($filter_option) && !empty($filter_input)) {

				for ($i = 0; $i < count($filter_option); $i++) {

					if ($filter_option[$i] == "email") {
						$query .= " AND wp_users.user_email LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "first_name") {
						$query .= " AND t1.first_name LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "last_name") {
						$query .= " AND t1.last_name LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "country") {
						$query .= " AND wp_member_other_info.country_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "state") {
						$query .= " AND wp_member_other_info.state_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "city") {
						$query .= " AND wp_member_other_info.city LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "chapter") {
						$query .= " AND wp_member_other_info.chapter_type_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "membership") {
						$query .= " AND wp_member_other_info.membership_type = $filter_input[$i] ";
					} else if ($filter_option[$i] == "member_status") {
						$query .= " AND t1.is_deleted = $filter_input[$i] ";
					} else if ($filter_option[$i] == "is_member") {
						$query .= " AND t1.alive = $filter_input[$i] ";
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
			$results_per_page = $rowLimit;

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

			// $state = $_GET['state'];

			$query = "SELECT t1.* from wp_chapters t1
			          INNER JOIN wp_states t2 ON t1.chapter_type_id = t2.chapter_type_id ";

			// if (!empty($state)) {
			// 	$query .= " WHERE t2.state_type_id = " . $state . " ";
			// }

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

	/**
	 * Ajax callback function for csv download
	 */
	public function csv_download_action()
	{
		header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['page']) || isset($_GET['search']) || isset($_GET['action']) == 'download_csv_file') {

			$search = $_GET['search'];
			$filter_option = $_GET['filter_option'];
			$filter_input = $_GET['filter_input'];
			$checkedID = $_GET['checked'];

			$query = "SELECT
			DATE_FORMAT(
				wp_users.user_registered,
				'%m-%d-%Y'
			) AS user_registered,
			wp_users.user_email,
			t1.first_name, t1.last_name, t1.member_id, t1.is_deleted, t1.phone_no,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, 
			wp_member_other_info.city, wp_member_other_info.postal_code, wp_member_other_info.souvenir,
			wp_states.state, wp_chapters.name as chapter_name, wp_countries.country, 
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%m-%d-%Y'
			) AS membership_expiry_date, wp_membership_type.membership 
			FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			LEFT JOIN  wp_states ON wp_member_other_info.state_id = wp_states.state_type_id
			LEFT JOIN wp_chapters ON wp_member_other_info.chapter_type_id = wp_chapters.chapter_type_id
			LEFT JOIN wp_countries ON wp_countries.country_type_id = wp_member_other_info.country_id

		
			WHERE
			t1.type != 'child'/* 
			AND t1.is_deleted = 0  */";

			/**
			 * Proceed for search
			 */
			if (!empty($search)) {
				$search_keywords = explode(" ", $search);

				foreach ($search_keywords as $search) {

					$query .= " AND ( ";
					if (DateTime::createFromFormat('d-m-Y', $search) !== false) {
						// $date = date('Y-m-d', strtotime($search));
						$date= DateTime::createFromFormat('m-d-Y', $search)->format('Y-m-d');
						$query .= " wp_users.user_registered LIKE '%$date%' ";
					}

					if (DateTime::createFromFormat('d-m-Y', $search) !== false) {
						// $date = date('Y-m-d', strtotime($search));
						$date= DateTime::createFromFormat('m-d-Y', $search)->format('Y-m-d');
						$query .= "OR wp_member_other_info.membership_expiry_date LIKE '%$date%' OR";
					}

					$query .= " wp_users.user_email LIKE '%$search%' 
						   OR t1.member_id LIKE '%$search%' 
						   OR t1.first_name LIKE '%$search%' 
						   OR t1.last_name LIKE '%$search%'
						   OR t1.phone_no LIKE '%$search%' 
						   OR wp_membership_type.membership LIKE '%$search%' )
						   ";
				}
			}
			/**
			 * Proceed for filters
			 */
			if (!empty($filter_option) && !empty($filter_input)) {

				for ($i = 0; $i < count($filter_option); $i++) {

					if ($filter_option[$i] == "email") {
						$query .= " AND wp_users.user_email LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "first_name") {
						$query .= " AND t1.first_name LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "last_name") {
						$query .= " AND t1.last_name LIKE '%$filter_input[$i]%' ";
					} else if($filter_option[$i] == "country") {
						$query .= " AND wp_member_other_info.country_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "state") {
						$query .= " AND wp_member_other_info.state_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "city") {
						$query .= " AND wp_member_other_info.city LIKE '%$filter_input[$i]%' ";
					} else if ($filter_option[$i] == "chapter") {
						$query .= " AND wp_member_other_info.chapter_type_id = $filter_input[$i] ";
					} else if ($filter_option[$i] == "membership") {
						$query .= " AND wp_member_other_info.membership_type = $filter_input[$i] ";
					}  else if ($filter_option[$i] == "is_member") {
						$query .= " AND t1.alive = $filter_input[$i] ";
					}   else if ($filter_option[$i] == "member_status") {
						$query .= " AND t1.is_deleted = $filter_input[$i] ";
					}
				}
			}

			// for selected rows
			if(!empty($checkedID)){
				$checkedID = array_unique($checkedID);
				$membersIdToString = implode(",", $checkedID);
				$query .= " AND t1.member_id IN(" . $membersIdToString . ") ";
			}

			$query .= " ORDER BY wp_users.user_registered ASC";

			// echo $query;
			// die;
			$data = $wpdb->get_results($query);

			wp_reset_query();

			echo json_encode($data);
		} else {
			// no posts found
		}
		wp_die();
	}

	/**
	 * Ajax callback to deactivate member
	 */
	public function member_deactivate()
	{

		global $wpdb;
		if (isset($_GET['action'])) {

			$isDeleted = $_GET['isDeleted'];
			$memberId = $_GET['memberID'];

			$memID = array_unique($memberId);
			$membersIdToString = implode(",", $memID);
			$updateQuery = " UPDATE wp_member_user SET is_deleted = $isDeleted WHERE member_id IN(" . $membersIdToString . ") ";
			$wpdb->get_results($updateQuery);
			wp_reset_query();

			$this->removeMemberfromGsuiteByEmailId($membersIdToString);
			echo 'deleted mem';
		} else {
			// no posts found
		}
		wp_die();
	}

	/**
	 * Ajax callback to delete member
	 */
	public function member_delete()
	{
		global $wpdb;
		if (isset($_GET['action'])) {

			$memberId = $_GET['memberId'];

			$memID = array_unique($memberId);
			$membersIdToString = implode(",", $memID);
			$this->removeMemberfromGsuiteByEmailId($membersIdToString);
			$deleteQuery = " DELETE wp_member_user.*,wp_member_other_info.*,wp_member_membership.*,wp_users.* 
			FROM wp_member_user 
			LEFT JOIN wp_member_other_info ON wp_member_other_info.member_id = wp_member_user.member_id 
			LEFT JOIN wp_member_membership ON wp_member_membership.member_id = wp_member_user.member_id 
			LEFT JOIN wp_users ON wp_users.id = wp_member_user.user_id 
			LEFT JOIN wp_usermeta ON wp_usermeta.user_id = wp_users.id
			WHERE wp_member_user.member_id IN(" . $membersIdToString . ") ";
			$wpdb->get_results($deleteQuery);
			wp_reset_query();
			echo 'deleted member';
		} else {
			// no posts found
		}
		wp_die();
	}

	private function removeMemberfromGsuiteByEmailId($membersIdToString)
	{
		global $wpdb;
		$getEmail = $wpdb->get_results("SELECT user_email FROM wp_member_user LEFT JOIN wp_users ON wp_users.ID = wp_member_user.user_id WHERE wp_member_user.member_id IN(" . $membersIdToString . ")");

		foreach ($getEmail as $emailValue) {
			$gsuite = new Osa_Membership_G_Suite();
			$accessToken = $gsuite->reFreshGsuiteAccessToken();
			$response = $gsuite->deleteMemberFromGsuiteGroup($accessToken, $emailValue->user_email);
		}
		return 1;
	}

	public function get_membership_plan_ajax_action()
	{

		header("Content-Type: application/json");
		global $wpdb;

		if (isset($_GET['id'])) {
			$query = "SELECT * from wp_membership_type where status= 1 and membership_type_id= " . $_GET['id'] . " ";
			$data = $wpdb->get_results($query);
			wp_reset_query();
			echo json_encode($data);
		} else {
			// no posts found
		}
		wp_die();
	}
}
