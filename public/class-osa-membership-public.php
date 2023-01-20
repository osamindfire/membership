<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://odishasociety.org
 * @since      1.0.0
 *
 * @package    Osa_Membership
 * @subpackage Osa_Membership/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Osa_Membership
 * @subpackage Osa_Membership/public
 * @author     OSA <vicepresident@odishasociety.org>
 */
class Osa_Membership_Public
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
	 * Array of php variables localized to JS.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array $localized_data Array of php variables localized to JS.
	 */
	private static $localized_data = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/osa-membership-public.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . time(), plugin_dir_url(__FILE__) . 'css/form.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/osa-membership-public.js', array('jquery'), $this->version, false);
		// Localize the constants to be used from JS.
		wp_localize_script($this->plugin_name,'ajax_url',[admin_url('admin-ajax.php')]);
	}

	public function initFunction()
	{
		if (!isset($_SESSION)) {
			session_start();
		}
		
		add_rewrite_endpoint('payment-cancel', EP_ALL);
		add_rewrite_endpoint('payment-success', EP_ALL);
		add_rewrite_endpoint('payment-notify', EP_ALL);
		flush_rewrite_rules();
	}

	/* 
	Function name: membershipPlan
	Description : For displaying membership plan once the user is registered 
	*/
	public function membershipPlan()
	{
		if (!empty($_SESSION['user_id'])) {
		global $wpdb, $user_ID;
		$membershipPlans = $wpdb->get_results("SELECT * FROM wp_membership_type where status=1 ");

			if ($_POST) {
				global $wpdb;
				//$userInfo = $wpdb->get_results("SELECT wp_member_user.member_id FROM wp_users INNER JOIN wp_member_user ON wp_users.ID=wp_member_user.user_id WHERE wp_users.ID  = " . $_SESSION['user_id'] . " limit 1");
				$membershipTypeInfo = $wpdb->get_results("SELECT wp_membership_type.* FROM wp_membership_type WHERE membership_type_id  = " . $_POST['membershhip_type_id'] . " limit 1");
				// PayPal settings. Change these to your account details and the relevant URLs
				// for your site.
				$paypalUrl = PAYPAL_ENABLE_SANDBOX ? PAYPAL_SANDBOX_URL : PAYPAL_LIVE_URL;

				// Product being purchased.
				$itemName = $membershipTypeInfo[0]->membership;
				$itemAmount = $membershipTypeInfo[0]->fee;
				$itemNo = $membershipTypeInfo[0]->membership_type_id;
				// Check if paypal request or response
				if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

					// Grab the post data so that we can set up the query string for PayPal.
					// Ideally we'd use a whitelist here to check nothing is being injected into
					// our post data.
					$data = [];
					foreach ($_POST as $key => $value) {
						$data[$key] = stripslashes($value);
					}
					// Set the PayPal account.
					$data['business'] = PAYPAL_BUSSINESS_EMAIL;

					// Set the PayPal return addresses.
					$data['return'] = stripslashes(PAYPAL_RETURN_URL);
					$data['cancel_return'] = stripslashes(PAYPAL_CANCEL_URL);
					$data['notify_url'] = stripslashes(PAYPAL_NOTIFY_URL);

					// Set the details about the product being purchased, including the amount
					// and currency so that these aren't overridden by the form data.
					$data['item_name'] = $itemName;
					$data['item_number'] = $_SESSION['membership_type_id'] = $itemNo;
					$data['amount'] = $itemAmount;

					// Add any custom fields for the query string.
					$data['custom'] = $_SESSION['user_id'];
					// Build the query string from the data.
					$queryString = http_build_query($data);
					$finalUrl = $paypalUrl . '?' . $queryString;
					echo "<script type='text/javascript'>window.location.href='" . $finalUrl . "'</script>";
					exit();
					// Redirect to paypal IPN
					//header('location:' . $paypalUrl . '?' . $queryString);
					//exit();

				}
			}

			ob_start();
			include_once(plugin_dir_path(__FILE__) . 'partials/membership_plan.php');
			return ob_get_clean();
		} else {
			$redirectTo = home_url() . '/login';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
			
		}
	}

	public function cancelPayment()
	{
		//ob_start();
		include_once(plugin_dir_path(__FILE__) . 'partials/payment/payment_cancel.php');
		//ob_end_flush();
		//return ob_get_clean();
	}
	public function successPayment()
	{
		$paymentInfoSaved = 0;
		global $wpdb;

			if ($_REQUEST['PayerID'] || $_POST['payer_id'] || $_POST['txn_id']) {
				$paymentInfoSaved = 1;
				$userInfo = $wpdb->get_results("SELECT wp_member_user.member_id,wp_member_user.first_name,wp_member_user.last_name,wp_users.user_email FROM wp_users INNER JOIN wp_member_user ON wp_users.ID=wp_member_user.user_id WHERE wp_users.ID  = " . $_SESSION['user_id'] . " limit 1");
				$membershipPackage = $wpdb->get_results("SELECT wp_membership_type.total_days FROM wp_membership_type WHERE membership_type_id  = " . $_SESSION['membership_type_id'] . " ");

				$starttDate = date('Y-m-d');
				$endDate = date('Y-m-d', strtotime($starttDate . ' + ' . $membershipPackage[0]->total_days . ' days'));

				$wpdb->query($wpdb->prepare(
					"INSERT INTO wp_member_membership (user_id, member_id, start_date, end_date, membership_type_id, comment , update_by,payment_info) VALUES ( %d, %d, %s, %s, %d, %s, %s,%s)",
					array(
						'user_id' => $_SESSION['user_id'],
						'member_id' => $userInfo[0]->member_id,
						'start_date' =>  $starttDate,
						'end_date' => $endDate,
						'membership_type_id' => $_SESSION['membership_type_id'],
						'comment' => '',
						'update_by' => $_SESSION['user_id'],
						'payment_info' => serialize($_REQUEST),
					)
				));
				$wpdb->query(
					$wpdb->prepare("UPDATE wp_member_other_info 
					SET membership_expiry_date = %s 
					WHERE member_id = %d", $endDate, $userInfo[0]->member_id)
				);
				$subject="Member registered successfully";
				$memberDetails = ['member_name' => $userInfo[0]->first_name . ' ' . $userInfo[0]->last_name];

				$this->sendMail($userInfo[0]->email,$subject,$memberDetails);
				unset($_SESSION['user_id']);
				unset($_SESSION['membership_type_id']);
			}
		$fileName = ($paymentInfoSaved == 1) ? 'payment_success.php' : 'payment_cancel.php';
		include_once(plugin_dir_path(__FILE__) . 'partials/payment/' . $fileName);
	}

	private function verifyTransaction($data)
	{
		$req = 'cmd=_notify-validate';
		foreach ($data as $key => $value) {
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
			$req .= "&$key=$value";
		}

		$ch = curl_init(PAYPAL_SANDBOX_URL);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSLVERSION, 6);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		$res = curl_exec($ch);

		if (!$res) {
			$errno = curl_errno($ch);
			$errstr = curl_error($ch);
			curl_close($ch);
			throw new Exception("cURL error: [$errno] $errstr");
		}

		$info = curl_getinfo($ch);

		// Check the http response
		$httpCode = $info['http_code'];
		if ($httpCode != 200) {
			throw new Exception("PayPal responded with http code $httpCode");
		}
		curl_close($ch);

		return $res === 'VERIFIED';
	}
	private function checkTxnid($txnid)
	{
		global $db;

		$txnid = $db->real_escape_string($txnid);
		$results = $db->query('SELECT * FROM `payments` WHERE txnid = \'' . $txnid . '\'');

		return !$results->num_rows;
	}

	/* 
	Function name: memberLogin
	Description : For displaying login page and authenticate the user and logged it into the system 
	*/
	public function memberLogin()
	{
		global $wpdb, $user_ID;
		if ($_POST) {
			//We shall SQL escape all inputs  
			$username = esc_sql($_REQUEST['username']);
			$password = esc_sql($_REQUEST['password']);
			$remember = isset($_REQUEST['rememberme']) ? true : false;

			$login_data = array();
			$login_data['user_login'] = $username;
			$login_data['user_password'] = $password;
			$login_data['remember'] = $remember;

			$user_verify = wp_signon($login_data, false);

			if (is_wp_error($user_verify)) {
				$errors = $user_verify->errors;
			} else {
				wp_set_current_user($user_verify->ID);
				wp_set_auth_cookie($user_verify->ID);
				$loggedUser = wp_get_current_user();
				if ($loggedUser->data->user_status == 1) {
					do_action('wp_login', $user_verify->user_login, $user_verify);
					//wp_redirect( site_url() );
					//exit;
					echo "<script type='text/javascript'>window.location.href='" . home_url() . "'</script>";
					exit();
				} else {

					$redirectTo = home_url() . '/membership-plan';
					echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
					exit();
				}
			}
		} else {

			// No login details entered - you should probably add some more user feedback here, but this does the bare minimum  
			//echo "Invalid login details"; 
		}
		ob_start();
		include_once(plugin_dir_path(__FILE__) . 'partials/authentication/login.php');
		return ob_get_clean();
	}

	/* 
	Function name: memberRegister
	Description : For displaying register page and register the user and create member into the system with all family members 
	*/
	public function memberRegister()
	{
		global $wpdb, $user_ID;
		$countries = $wpdb->get_results("SELECT * FROM wp_countries ");

		if (isset($_POST['register_form']) && wp_verify_nonce($_POST['register_form'], 'register')) {
			try {
				$errors = $this->validateForm(); //echo "<pre>";print_r($errors);die;
				if (0 === count($errors)) {
					if ($this->createUser()) {
						$redirectTo = home_url() . '/membership-plan?register_success=1';
						echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
						exit();
					}
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		}
		ob_start();
		include_once(plugin_dir_path(__FILE__) . 'partials/authentication/register.php');
		return ob_get_clean();
	}

	/* 
	Function name: validateForm
	Description : Validate register input feilds
	*/
	private function validateForm()
	{
		$errors = array();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$firstName = esc_sql($_REQUEST['first_name']);
			if (empty($firstName)) {
				$errors['firstName'] = "Please enter a First Name";
			}
			$lastName = esc_sql($_REQUEST['last_name']);
			if (empty($lastName)) {
				$errors['lastName'] = "Please enter a Last Name";
			}

			// Check email address is present and valid  
			$email = esc_sql($_REQUEST['email']);
			if (empty($email)) {
				$errors['email'] = "Please enter a Email";
			} elseif (!is_email($email)) {
				$errors['email'] = "Please enter a valid Email";
			} elseif (email_exists($email)) {
				$errors['email'] = "This email address is already in use";
			}

			$mobileNo = esc_sql($_REQUEST['primary_mobile_no']);
			if (empty($mobileNo)) {
				$errors['primaryMobileNo'] = "Please enter a Mobile";
			}

			// Check password is valid 
			$password = esc_sql($_REQUEST['password']);
			if (empty($password)) {
				$errors['password'] = "Please enter a Password";
			} elseif (0 === preg_match("/.{6,}/", $_POST['password'])) {
				$errors['password'] = "Password must be at least six characters";
			}

			$cPassword = esc_sql($_REQUEST['confirm_password']);
			if (empty($cPassword)) {
				$errors['confirmPassword'] = "Please Confirm Password";
			} elseif (0 !== strcmp($_POST['password'], $_POST['confirm_password'])) // Check password confirmation_matches 
			{
				$errors['confirmPassword'] = "Passwords do not match";
			}

			if (!empty($_REQUEST['spouse_first_name'])) {
				// Validate spouse  
				$spouseFirstName = esc_sql($_REQUEST['spouse_first_name']);
				if (empty($spouseFirstName)) {
					$errors['spouseFirstName'] = "Please enter a spouse First Name";
				}
				$spouseLastName = esc_sql($_REQUEST['spouse_last_name']);
				if (empty($spouseLastName)) {
					$errors['spouseLastName'] = "Please enter a spouse Last Name";
				}

				// Check email address is present and valid  
				$spouseEmail = esc_sql($_REQUEST['spouse_email']);
				if (empty($spouseEmail)) {
					$errors['spouseEmail'] = "Please enter a Spouse Email";
				} elseif (!is_email($spouseEmail)) {
					$errors['spouseEmail'] = "Please enter a valid Email";
				} elseif (email_exists($spouseEmail)) {
					$errors['spouseEmail'] = "This email address is already in use";
				}

				// Check password is valid  
				$spousePassword = esc_sql($_REQUEST['spouse_password']);
				if (empty($spousePassword)) {
					$errors['spousePassword'] = "Please enter a Spouse Password";
				} elseif (0 === preg_match("/.{6,}/", $_POST['spouse_password'])) {
					$errors['spousePassword'] = "Password must be at least six characters";
				}

				// Check password confirmation_matches
				$cSpousePassword = esc_sql($_REQUEST['spouse_password']);
				if (empty($cSpousePassword)) {
					$errors['confirmSpousePassword'] = "Please enter a Spouse Password";
				}
				if (0 !== strcmp($_POST['spouse_password'], $_POST['spouse_confirm_password'])) {
					$errors['confirmSpousePassword'] = "Spouse Passwords do not match";
				}
			}

			$addressLine1 = esc_sql($_REQUEST['address_line_1']);
			if (empty($addressLine1)) {
				$errors['addressLine1'] = "Please enter address";
			}

			$city = esc_sql($_REQUEST['city']);
			if (empty($city)) {
				$errors['city'] = "Please enter city";
			}
			$postalCode = esc_sql($_REQUEST['postal_code']);
			if (empty($postalCode)) {
				$errors['postalCode'] = "Please enter Postal Code";
			}
			$country = esc_sql($_REQUEST['country']);
			if (empty($country)) {
				$errors['country'] = "Please select Country";
			}
			// Check terms of service is agreed to  
			if (!isset($_POST['agree'])) {
				$errors['agree'] = "You must agree to Terms of Service";
			}
		}
		return $errors;
	}

	/* 
	Function name: createUser
	Description : function called when member is register on webapplication
	*/
	private function createUser()
	{
		global $wpdb;
		$success = 0;
		$username = $_POST['first_name'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$userId = wp_create_user($username, $password, $email);
		$_SESSION['user_id'] = $userId;
		if ($userId) {
			add_user_meta($userId, 'wp_capabilities', 'a:1:{s:10:"subscriber";b:1;}', true);
			$newMemberId = $this->getNewmemberId();
			$wpdb->query($wpdb->prepare(
				"INSERT INTO wp_member_user (user_id, member_id, parent_id, first_name, last_name, type , modified_date, alive, email_valid, is_deleted) VALUES ( %d, %d, %d, %s, %s, %s, %s, %d, %d, %d)",
				array(
					'user_id' => $userId,
					'member_id' => $newMemberId,
					'parent_id' =>  0,
					'first_name' => $_POST['first_name'],
					'last_name' => $_POST['last_name'],
					'type' => 'parent',
					'modified_date' => date('Y-m-d H:i:s'),
					'alive' => 1,
					'email_valid' => 1,
					'is_deleted' =>  0
				)
			));
			$wpdb->insert_id;
			//add other members of user
			$this->addSubMember($newMemberId, $userId, $wpdb->insert_id);
			$wpdb->insert('wp_member_other_info', array(
				'user_id' => $userId,
				'member_id' => $newMemberId,
				'address_line_1' => $_POST['address_line_1'],
				'address_line_2' => isset($_POST['address_line_2']) ? $_POST['address_line_2'] : '',
				'city' => $_POST['city'],
				'state_id' => $_POST['state'],
				'country_id' => $_POST['country'],
				'is_valid_address' => 1,
				'primary_phone_no' => $_POST['primary_mobile_no'],
				'secondary_phone_no' => '',
				'postal_code' => $_POST['postal_code'],
				'souvenir' => 'CD',
			));
			$success = 1;
		}
		return $success;
	}
	/* 
	Function name: getNewmemberId
	Description : Generates new member ID
	*/
	private function getNewmemberId()
	{
		global $wpdb;
		$memberData = $wpdb->get_results("SELECT member_id FROM wp_member_user order by member_id DESC limit 1");
		return $memberData[0]->member_id + 1;
	}

	/* 
	Function name: addSubMember
	Description : Creates other members of family
	*/
	private function addSubMember($memberId, $mainParentUserId, $mainMemberPK)
	{
		global $wpdb;
		$username = $_POST['spouse_first_name'];
		$password = $_POST['spouse_password'];
		$email = $_POST['spouse_email'];
		//add spouse
		if (!empty($username) && !empty($email)) {
			$userId = wp_create_user($username, $password, $email);

			if ($userId) {
				add_user_meta($userId, 'wp_capabilities', 'a:1:{s:10:"subscriber";b:1;}', true);
				$wpdb->query($wpdb->prepare(
					"INSERT INTO wp_member_user (user_id, member_id, parent_id, first_name, last_name, type , modified_date, alive, email_valid, is_deleted) VALUES ( %d, %d, %d, %s, %s, %s, %s, %d, %d, %d)",
					array(
						'user_id' => $userId,
						'member_id' => $memberId,
						'parent_id' =>  $mainMemberPK,
						'first_name' => $_POST['spouse_first_name'],
						'last_name' => $_POST['spouse_last_name'],
						'type' => 'parent',
						'modified_date' => date('Y-m-d H:i:s'),
						'alive' => 1,
						'email_valid' => 1,
						'is_deleted' =>  0
					)
				));
			}
		}
		//add child
		if (!empty($_POST['child_first_name'])) {

			if ($mainParentUserId) {
				$wpdb->query($wpdb->prepare(
					"INSERT INTO wp_member_user (user_id, member_id, parent_id, first_name, last_name, type , modified_date, alive, email_valid, is_deleted) VALUES ( %d, %d, %d, %s, %s, %s, %s, %d, %d, %d)",
					array(
						'user_id' => $mainParentUserId,
						'member_id' => $memberId,
						'parent_id' =>  $mainMemberPK,
						'first_name' => $_POST['child_first_name'],
						'last_name' => isset($_POST['child_last_name']) ? $_POST['child_last_name'] : '',
						'type' => 'child',
						'modified_date' => date('Y-m-d H:i:s'),
						'alive' => 1,
						'email_valid' => 1,
						'is_deleted' =>  0
					)
				));
			}
		}
		return 1;
	}

	/* 
	Function name: getStates
	Description : get all states of country
	*/
	public function getStates()
	{
		$countryId = $_POST['country_id'];
		$stateId = isset($_POST['state_id']) ? $_POST['state_id'] : '';

		global $wpdb;
		$states = $wpdb->get_results("SELECT * FROM wp_states WHERE country_type_id = '" . $countryId . "' order by state ASC");

		$html =  "<option value=''>Select State</option>";
		foreach ($states as $state) {
			if ($stateId == $state->state_type_id) {
				$html .=  "<option class='option_feild' value='" . $state->state_type_id . "' selected >" . $state->state . "</option>";
			} else {
				$html .=  "<option class='option_feild' value='" . $state->state_type_id . "' >" . $state->state . "</option>";
			}
		}

		ob_clean();
		echo $html;
		die();
	}

	public function sendMail($to,$subject,$data=array())
	{
		
		ob_start();
		$memberName = $data['member_name'];
		include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/registration_email.php');
		$headers = array('Content-Type: text/html; charset=UTF-8');
		try {
			$response = wp_mail($to, $subject, $emailBody, $headers);
			return $response;
		}catch (Exception $e) {
			echo 'Error while sendnig mail: ',  $e->getMessage(), "\n";
		}
		return ob_get_clean();
		
	}	
}
