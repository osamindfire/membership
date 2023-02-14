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
		wp_enqueue_style($this->plugin_name . time() . time(), 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
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
		wp_enqueue_script($this->plugin_name . time(), 'https://www.google.com/recaptcha/api.js', array('jquery'), $this->version, false);
		// Localize the constants to be used from JS.
		wp_localize_script($this->plugin_name, 'ajax_url', [admin_url('admin-ajax.php')]);
	}

	public function initFunction()
	{
		//ob_start();
		error_reporting(0);
		if (!isset($_SESSION)) {
			session_start();
		}
		if (stristr($_SERVER['REQUEST_URI'], 'logout') && !current_user_can('administrator')) {
			wp_logout();
			unset($_SESSION['user_id']);
			wp_redirect('login');
			exit;
		}
		if (isset($_SESSION['user_id'])) {
			wp_set_current_user($_SESSION['user_id']);
		}
		add_rewrite_endpoint('profile', EP_PERMALINK | EP_PAGES);
		add_rewrite_endpoint('member-info', EP_PERMALINK | EP_PAGES);
		add_rewrite_endpoint('change-password', EP_PERMALINK | EP_PAGES);
		add_rewrite_endpoint('transaction', EP_PERMALINK | EP_PAGES);


		flush_rewrite_rules();
	}

	private function getTotalParent($userId)
	{
		global $wpdb;
		$userInfo = $wpdb->get_results("SELECT wp_member_user.member_id FROM wp_users INNER JOIN wp_member_user ON wp_users.ID=wp_member_user.user_id WHERE wp_users.ID  = " . $userId . " AND type='parent' limit 1 ");
		$totalMembers = $wpdb->get_results("SELECT count(wp_member_user.member_id) as total_parent FROM wp_member_user WHERE wp_member_user.member_id  = " . $userInfo[0]->member_id . " AND type='parent' limit 1 ");

		return $totalMembers[0]->total_parent;
	}
	/* 
	Function name: membershipPlan
	Description : For displaying membership plan once the user is registered 
	*/
	public function membershipPlan()
	{
		if (!empty($_SESSION['user_id'])) {
			global $wpdb, $user_ID;
			/* $type = '';
			if ($this->getTotalParent($_SESSION['user_id']) > 1) {
				$type = ' and type > 1';
			}
			$membershipPlans = $wpdb->get_results("SELECT * FROM wp_membership_type where status=1 $type "); */
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
		ob_start();
		global $wpdb;
		$user = get_user_by('ID', $_SESSION['user_id']);
		$userInfo = $user->data;
		$membershipTypeInfo = $wpdb->get_results("SELECT wp_membership_type.* FROM wp_membership_type WHERE membership_type_id  = " . $_SESSION['membership_type_id'] . " limit 1");
		$userInfo->user_membership = $membershipTypeInfo[0];
		$this->sendMail($userInfo->user_email, 'Payment Failure', (array)$userInfo, 'payment_cancel_member');
		include_once(plugin_dir_path(__FILE__) . 'partials/payment/payment_cancel.php');
		return ob_get_clean();
	}
	public function successPayment()
	{

		global $wpdb;
		if (!empty($_SESSION['user_id'])) {
			$paymentInfoSaved = 0;
			if (isset($_REQUEST['PayerID']) || isset($_POST['payer_id']) || isset($_POST['txn_id'])) {

				$userInfo = $wpdb->get_results("SELECT wp_users.*,wp_member_user.member_id,wp_member_user.first_name,wp_member_user.last_name,wp_users.user_email FROM wp_users INNER JOIN wp_member_user ON wp_users.ID=wp_member_user.user_id WHERE wp_users.ID  = " . $_SESSION['user_id'] . " limit 1");
				$membershipPackage = $wpdb->get_results("SELECT wp_membership_type.* FROM wp_membership_type WHERE membership_type_id  = " . $_SESSION['membership_type_id'] . " ");

				$starttDate = date('Y-m-d');
				$endDate = date('Y-m-d', strtotime($starttDate . ' + ' . $membershipPackage[0]->total_days . ' days'));
				$membershipType =  $membershipPackage[0]->membership_type_id;
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
					SET membership_expiry_date = %s,membership_type = %d 
					WHERE member_id = %d", $endDate, $membershipType, $userInfo[0]->member_id)
				);
				$subject = "Payment successfully";
				$adminPaymentSubject = "New Member Payment successfully";
				$userInfo[0]->user_membership = $membershipPackage[0];
				$this->sendMail($userInfo[0]->user_email, $subject, (array)$userInfo[0], 'payment_success_member');
				$this->sendMail(ADMIN_EMAIL, $adminPaymentSubject, (array)$userInfo[0], 'payment_success_admin');
				
				$membersInfo = $wpdb->get_results("SELECT wp_users.user_email,wp_member_user.id FROM wp_users INNER JOIN wp_member_user ON wp_users.ID=wp_member_user.user_id WHERE wp_member_user.member_id  = ".$userInfo[0]->member_id." and wp_member_user.type != 'child' ");
						
				$gsuite = new Osa_Membership_G_Suite();
				$accessToken=$gsuite->reFreshGsuiteAccessToken();
				foreach($membersInfo as $membersInfoValue)
				{
					if(!empty($membersInfoValue->user_email))
					{
						$response = $gsuite->addMemberToGsuiteGroup($accessToken,$membersInfoValue->user_email);
						
						$addedToGsuite = $response['status'];
						$gsuiteResponse = serialize($response);
						$wpdb->update('wp_member_user', ['added_to_gsuite'=>$addedToGsuite,'gsuite_response'=>$gsuiteResponse], array('id' => $membersInfoValue->id), array('%d', '%s'), array('%d'));

					}
				}
				unset($_SESSION['user_id']);
				unset($_SESSION['membership_type_id']);
				$paymentInfoSaved = 1;
			}
			$fileName = ($paymentInfoSaved == 1) ? 'payment_success.php' : 'payment_cancel.php';
			ob_start();
			include_once(plugin_dir_path(__FILE__) . 'partials/payment/' . $fileName);
			return ob_get_clean();
		} else {
			$redirectTo = home_url() . '/login';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
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
		if (!is_user_logged_in()) {
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
					$errors['incorrect_password'][0] = 'The password you entered for the email address ' . $username . ' is incorrect.';
				} else {
					wp_set_current_user($user_verify->ID);
					$_SESSION['user_id'] = $user_verify->ID;
					wp_set_auth_cookie($user_verify->ID);
					$loggedUser = wp_get_current_user();
					$memberData = $wpdb->get_results("SELECT
				wp_member_other_info.membership_type,
				wp_member_other_info.membership_expiry_date
				FROM
				`wp_users`
				INNER JOIN wp_member_user t1 ON
				t1.user_id = wp_users.ID
				LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
				WHERE t1.user_id=" . $loggedUser->data->ID . " limit 1");
					$currentDate = date('Y-m-d');
					if (strtotime($memberData[0]->membership_expiry_date) >= strtotime($currentDate)) {
						do_action('wp_login', $user_verify->user_login, $user_verify);
						$redirectTo = home_url() . '/member-dashboard';
						echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
						exit();
					} elseif (empty($memberData[0]->membership_expiry_date)) {

						$redirectTo = home_url() . '/membership-plan?no_membership_plan=1';
						echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
						exit();
					}
				}
			} else {
				$membershipExpireDate = $this->getMembershipExpireDate();
				if (is_user_logged_in() && strtotime($membershipExpireDate) >= strtotime(date('Y-m-d'))) {
					$redirectTo = home_url() . '/member-dashboard';
					echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
					exit();
				}
			}
			ob_start();
			include_once(plugin_dir_path(__FILE__) . 'partials/authentication/login.php');
			return ob_get_clean();
		} else {
			$redirectTo = home_url() . '/member-dashboard';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
	}

	/* 
	Function name: memberRegister
	Description : For displaying register page and register the user and create member into the system with all family members 
	*/
	public function memberRegister()
	{
		if (!is_user_logged_in()) {
			global $wpdb, $user_ID;
			$countries = $wpdb->get_results("SELECT * FROM wp_countries order by priority ASC");

			if (isset($_POST['register_form']) && wp_verify_nonce($_POST['register_form'], 'register')) {
				try {
					$errors = $this->validateForm();
					if (0 === count($errors)) {
						if ($this->createUser()) {
							$userData = get_user_by('ID', $_SESSION['user_id']);
							$userInfo = $userData->data;
							$memberSubject = "Member Registered successfully";
							$adminSubject = "New Member Registered";
							$memberDetails = (array)$userInfo;
							$this->sendMail($memberDetails['user_email'], $memberSubject, $memberDetails, 'member_register'); //send mail to user
							$this->sendMail(ADMIN_EMAIL, $adminSubject, $memberDetails, 'admin_member_register'); //send mail to site admin
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
		} else {
			$redirectTo = home_url() . '/member-dashboard';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
	}

	public function forgotPassword()
	{
		if (isset($_POST['forgot_password_form']) && wp_verify_nonce($_POST['forgot_password_form'], 'forgot_password')) {
			try {
				$recaptcha = $_POST['g-recaptcha-response'];
				$secret_key = GOOGLE_CAPTCHA_SECRET_KEY;
				$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha;

				// Making request to verify captcha
				$response = file_get_contents($url);

				// Response return by google is in
				// JSON format, so we have to parse
				// that json
				$response = json_decode($response, true);
				$errors = array();
				$email = esc_sql($_POST['email']);
				if (empty($email)) {
					$errors['email'] = "Please enter a Email";
				} elseif (!is_email($email)) {
					$errors['email'] = "Please enter a valid Email";
				} elseif (!email_exists($email)) {
					$errors['email'] = "This email address is not exist";
				} elseif (!empty($response['error-codes'])) {
					$errors['googlecaptcha'] = 'CAPTCHA is invalid';
				}
				if (empty($errors)) {
					// lets generate our new password
					$user_activation_key = wp_generate_password(20, false);
					$user = get_user_by('email', $email);
					$userInfo = $user->data;
					global $wpdb;
					$update_user = $wpdb->update('wp_users', ['user_activation_key' => $user_activation_key], array('ID' => $user->ID), array('%s'), array('%d'));
					$userInfo->user_activation_key = $user_activation_key;
					if ($this->sendMail($userInfo->user_email, 'Reset Password', (array)$userInfo, 'forgot_password')) {
						$redirectTo = home_url() . '/login?forgot_password=1';
						echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
						exit();
					}
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		}
		ob_start();
		include_once(plugin_dir_path(__FILE__) . 'partials/authentication/forgot_password.php');
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

			$recaptcha = $_POST['g-recaptcha-response'];
			$secret_key = GOOGLE_CAPTCHA_SECRET_KEY;
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha;

			// Making request to verify captcha
			$response = file_get_contents($url);

			// Response return by google is in
			// JSON format, so we have to parse
			// that json
			$response = json_decode($response, true);
			if (!empty($response['error-codes'])) {
				$errors['googlecaptcha'] = 'CAPTCHA is invalid';
			}

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
		$username = $_POST['email'];
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
				'membership_type' => NULL,
				'membership_expiry_date' => NULL
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
		$username = $_POST['spouse_email'];
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

	public function sendMail($to, $subject, $data = array(), $type = '')
	{

		ob_start();
		switch ($type) {
			case "member_register":
				include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/registration_email.php');
				break;
			case "admin_member_register":
				include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/admin_registration_email.php');
				break;
			case "forgot_password":
				include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/reset_password.php');
				break;
			case "payment_success_member":
				include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/payment_success_emal.php');
				break;
			case "payment_success_admin":
				include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/payment_success_admin_email.php');
				break;
			case "payment_cancel_member":
				include_once(plugin_dir_path(__FILE__) . 'partials/email_templates/payment_fail_email.php');
				break;
			default:
		}
		$headers = array('Content-Type: text/html; charset=UTF-8');
		try {
			$response = wp_mail($to, $subject, $emailBody, $headers);
			return $response;
		} catch (Exception $e) {
			echo 'Error while sendnig mail: ',  $e->getMessage(), "\n";
		}
		return ob_get_clean();
	}
	private function getMembershipExpireDate()
	{
		global $current_user;
		global $wpdb;
		$logged_user = wp_get_current_user();
		$membershipExpiryDate = '0000-00=00';
		if (!empty($logged_user->data->ID)) {
			$membershipExpiryDate = $wpdb->get_var("select membership_expiry_date FROM
			`wp_users`
			INNER JOIN wp_member_user ON
			wp_member_user.user_id = wp_users.ID
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = wp_member_user.member_id 
			WHERE
			wp_member_user.type != 'child' and wp_member_other_info.membership_type IS NOT NULL and wp_users.ID=" . $logged_user->data->ID . " ");
		}
		return $membershipExpiryDate;
	}
	public function membersListing()
	{
		global $wpdb;
		global $wp;
		global $current_user;
		$countries = $wpdb->get_results("SELECT * FROM wp_countries order By priority ASC");
		$logged_user = wp_get_current_user();
		$membershipExpiryDate = $this->getMembershipExpireDate();
		if (is_user_logged_in() && strtotime($membershipExpiryDate) >= strtotime(date('Y-m-d'))) {
			$pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
			$limit = 20; // number of rows in page
			$offset = ($pagenum - 1) * $limit;
			$where = "";
			$where .= "t1.type != 'child' and wp_member_other_info.membership_type IS NOT NULL and t1.is_deleted =0 ";
			if (!empty($_GET['global_search'])) {
				$globalSearch = $_GET['global_search'];
				$where .= " AND ";
				$where .= " ( t1.first_name like '%$globalSearch%'";
				$where .= " OR t1.last_name like '%$globalSearch%'";
				$where .= " OR t1.member_id like '%$globalSearch%'";
				if (DateTime::createFromFormat('d-m-Y', $globalSearch) !== false) {
					$date = date('Y-m-d', strtotime($globalSearch));
					$where .= " OR user_registered like '%$date%'";
				}
				$where .= " OR wp_member_other_info.address_line_1 like '%$globalSearch%'";
				$where .= " OR wp_member_other_info.address_line_2 like '%$globalSearch%'";
				$where .= " OR wp_member_other_info.primary_phone_no like '%$globalSearch%'";
				$where .= " OR wp_member_other_info.secondary_phone_no like '%$globalSearch%'";
				$where .= " OR wp_membership_type.membership like '%$globalSearch%'";
				$where .= " OR wp_users.user_email like '%$globalSearch%'";
				$where .= " ) ";
			}
			if (!empty($_GET['country'])) {
				$country_id = $_GET['country'];
				$where .= " AND wp_member_other_info.country_id = $country_id ";
			}
			if (!empty($_GET['state'])) {
				$state_id = $_GET['state'];
				$where .= " AND wp_member_other_info.state_id = $state_id ";
			}
			if (!empty($_GET['city'])) {
				$city_name = $_GET['city'];
				$where .= " AND wp_member_other_info.city like '%$city_name%' ";
			}

			$total = $wpdb->get_var("select count(*) FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			WHERE $where");

			$num_of_pages = ceil($total / $limit);
			$rows = $wpdb->get_results("SELECT
			DATE_FORMAT(
				wp_users.user_registered,
				'%d-%m-%Y'
			) AS user_registered,
			wp_users.ID as user_id,
			wp_users.user_email,
			t1.first_name,
			t1.last_name,
			t1.member_id,
			t1.parent_id,
			wp_member_other_info.address_line_1, wp_member_other_info.address_line_2, wp_member_other_info.primary_phone_no, wp_member_other_info.secondary_phone_no,
			DATE_FORMAT(
				wp_member_other_info.membership_expiry_date,
				'%d-%m-%Y'
			) AS membership_expiry_date,
			wp_membership_type.membership 
			FROM
			`wp_users`
			INNER JOIN wp_member_user t1 ON
			t1.user_id = wp_users.ID
			LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
			LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
			WHERE $where order by t1.member_id DESC limit  $offset, $limit");

			$rowcount = $wpdb->num_rows;
			ob_start();
			include_once(plugin_dir_path(__FILE__) . 'partials/member_listing.php');
			return ob_get_clean();
		} else {
			$redirectTo = home_url() . '/membership-plan?membership_expired=1';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
	}

	public function profile()
	{
		global $wpdb, $user_ID;
		$countries = $wpdb->get_results("SELECT * FROM wp_countries order by priority ASC");
		global $current_user;
		$logged_user = wp_get_current_user();
		$membershipExpiryDate = $this->getMembershipExpireDate();
		$totalParent = $this->getTotalParent($user_ID);
		if (is_user_logged_in() && strtotime($membershipExpiryDate) >= strtotime(date('Y-m-d'))) {
			if ($_POST) {
				$errors = $this->validateProfileForm();
				if (empty($errors)) {
					//main member update
					$mainArr = [];
					$mainArr['first_name'] = $_POST['first_name'];
					$mainArr['last_name'] = $_POST['last_name'];
					$mainId = $_POST['main_id'];
					$mainMember = $wpdb->update('wp_member_user', $mainArr, array('id' => $mainId), array('%s', '%s'), array('%d'));
					//partner update
					if (!empty($_POST['spouse_first_name'])) {
						$othArr = [];
						$othArr['first_name'] = $_POST['spouse_first_name'];
						$othArr['last_name'] = $_POST['spouse_last_name'];
						$othId = $_POST['other_id'];
						$othMember = $wpdb->update('wp_member_user', $othArr, array('id' => $othId), array('%s', '%s'), array('%d'));
					}
					//other information update
					$othInfo = [];
					$othInfo['address_line_1'] = $_POST['address_line_1'];
					$othInfo['address_line_2'] = $_POST['address_line_2'];
					$othInfo['primary_phone_no'] = $_POST['primary_phone_no'];
					$othInfo['secondary_phone_no'] = $_POST['secondary_phone_no'];
					$othInfo['city'] = $_POST['city'];
					$othInfo['postal_code'] = $_POST['postal_code'];
					$othInfo['state_id'] = $_POST['state'];
					$othInfo['country_id'] = $_POST['country'];
					$othInfo['souvenir'] = $_POST['souvenir'];
					$othInfoId = $_POST['member_id'];

					$othinfos = $wpdb->update('wp_member_other_info', $othInfo, array('member_id' => $othInfoId), array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s'), array('%d'));

					//child update
					foreach ($_POST['child_id'] as $childKey => $childValues) {
						if (!empty($_POST['child_id'][$childKey])) {
							if (!empty($_POST['child_first_name'][$childKey]) || $_POST['child_last_name'][$childKey]) {

								$wpdb->update('wp_member_user', ['first_name' => $_POST['child_first_name'][$childKey], 'last_name' => $_POST['child_last_name'][$childKey]], array('id' => $childValues), array('%s', '%s'), array('%d'));
							} else {
								$wpdb->delete('wp_member_user', array('id' => $childValues));
							}
						} elseif (!empty($_POST['child_first_name'][$childKey])) {
							$wpdb->query($wpdb->prepare(
								"INSERT INTO wp_member_user (user_id, member_id, parent_id, first_name, last_name, type , modified_date, alive, email_valid, is_deleted) VALUES ( %d, %d, %d, %s, %s, %s, %s, %d, %d, %d)",
								array(
									'user_id' => $logged_user->data->ID,
									'member_id' => $othInfoId,
									'parent_id' =>  $mainId,
									'first_name' => $_POST['child_first_name'][$childKey],
									'last_name' => $_POST['child_last_name'][$childKey],
									'type' => 'child',
									'modified_date' => date('Y-m-d H:i:s'),
									'alive' => 1,
									'email_valid' => 1,
									'is_deleted' =>  0
								)
							));
						}
					}
					$redirectTo = home_url() . '/member-dashboard/profile?success=1';
					echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
					exit();
				}
			}
			$userInfo = $wpdb->get_results("SELECT
		wp_users.*,
		wp_member_other_info.*,
		t1.*,
		wp_membership_type.membership
		FROM
		`wp_users`
		INNER JOIN wp_member_user t1 ON
		t1.user_id = wp_users.ID
		LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
		LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_other_info.membership_type 
		WHERE wp_users.ID  = " . $logged_user->data->ID . " limit 1");

			$othMemberInfo = $wpdb->get_results("SELECT
		wp_member_user.*,
		wp_users.user_email
		FROM wp_member_user 
		INNER JOIN wp_users ON
		wp_users.ID = wp_member_user.user_id 
		WHERE wp_member_user.id !=" . $userInfo[0]->id . " and wp_member_user.member_id  = " . $userInfo[0]->member_id . " ");
			$userInfo['oth_member_info'] = $othMemberInfo;
			include_once(plugin_dir_path(__FILE__) . 'partials/member_profile.php');
		} else {
			$redirectTo = home_url() . '/membership-plan?membership_expired=1';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
	}
	private function validateProfileForm()
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

			$mobileNo = esc_sql($_REQUEST['primary_phone_no']);
			if (empty($mobileNo)) {
				$errors['primaryMobileNo'] = "Please enter a Mobile";
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
		}
		return $errors;
	}


	public function member_info()
	{
		$membershipExpiryDate = $this->getMembershipExpireDate();
		if (is_user_logged_in() && strtotime($membershipExpiryDate) >= strtotime(date('Y-m-d'))) {
			global $wpdb;
			global $current_user;
			//$logged_user = wp_get_current_user();
			$memberInfo = $wpdb->get_results("SELECT
		wp_users.*,
		wp_member_other_info.*,
		wp_countries.country,
		wp_states.state,
		wp_chapters.name as chapter_name,
		t1.*
		FROM
		`wp_users`
		INNER JOIN wp_member_user t1 ON
		t1.user_id = wp_users.ID
		LEFT JOIN wp_member_other_info  ON wp_member_other_info.member_id = t1.member_id 
		LEFT JOIN wp_countries  ON wp_countries.country_type_id = wp_member_other_info.country_id 
		LEFT JOIN wp_states  ON wp_states.state_type_id = wp_member_other_info.state_id 
		LEFT JOIN wp_chapters  ON wp_chapters.chapter_type_id = wp_states.chapter_type_id 
		WHERE wp_users.ID  = " . $_GET['id'] . " limit 1");
			$othMemberInfo = $wpdb->get_results("SELECT
		wp_member_user.*,
		wp_users.user_email
		FROM wp_member_user 
		INNER JOIN wp_users ON
		wp_users.ID = wp_member_user.user_id 
		WHERE wp_member_user.id !=" . $memberInfo[0]->id . " and wp_member_user.member_id  = " . $memberInfo[0]->member_id . " ");
			$memberInfo['oth_member_info'] = $othMemberInfo;
			include_once(plugin_dir_path(__FILE__) . 'partials/member_info.php');
		} else {
			$redirectTo = home_url() . '/membership-plan?membership_expired=1';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
	}

	public function remove_admin_bar()
	{
		if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		}
	}

	public function update_password()
	{
		$membershipExpiryDate = $this->getMembershipExpireDate();
		if (is_user_logged_in() && strtotime($membershipExpiryDate) >= strtotime(date('Y-m-d'))) {
			if (isset($_POST['update_password_form']) && wp_verify_nonce($_POST['update_password_form'], 'update_password')) {
				try {
					global $current_user;
					$logged_user = wp_get_current_user();
					$errors = array();
					// Check password is valid 
					$checkOldPassword = wp_check_password($_REQUEST['old_password'], $logged_user->data->user_pass, $logged_user->data->ID);
					if (empty($checkOldPassword)) {
						$errors['old_password'] = "You have entered an incorrect Password";
					} else {
						$newPassword = esc_sql($_REQUEST['new_password']);
						if (empty($newPassword)) {
							$errors['new_password'] = "Please enter a New Password";
						} elseif (0 === preg_match("/.{6,}/", $_POST['new_password'])) {
							$errors['new_password'] = "Password must be at least six characters";
						}

						$cPassword = esc_sql($_REQUEST['confirm_password']);
						if (empty($cPassword)) {
							$errors['confirm_password'] = "Please Confirm Password";
						} elseif (0 !== strcmp($_POST['new_password'], $_POST['confirm_password'])) // Check password confirmation_matches 
						{
							$errors['confirm_password'] = "Passwords do not match";
						}
						if ($_REQUEST['old_password'] == $newPassword) {
							$errors['confirm_password'] = "Your new password cannot be the same as your current password";
						}
					}

					if (empty($errors)) {
						// lets generate our new password
						wp_set_password($newPassword, $logged_user->data->ID);
						wp_logout();
						unset($_SESSION['user_id']);
						$redirectTo = home_url() . '/login?password_updated=1';
						echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
						exit();
					}
				} catch (Exception $e) {
					echo 'Error writing to database: ',  $e->getMessage(), "\n";
				}
			}
			include_once(plugin_dir_path(__FILE__) . 'partials/authentication/update_password.php');
		} else {
			$redirectTo = home_url() . '/membership-plan?membership_expired=1';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
	}

	public function member_transaction()
	{
		$membershipExpiryDate = $this->getMembershipExpireDate();
		if (is_user_logged_in() && strtotime($membershipExpiryDate) >= strtotime(date('Y-m-d'))) {
			global $wpdb;
			global $current_user;
			$logged_user = wp_get_current_user();
			$membershipInfo = $wpdb->get_results("SELECT
		wp_member_membership.start_date,wp_member_membership.end_date,wp_membership_type.*
		FROM wp_member_user
		LEFT JOIN wp_member_membership  ON wp_member_membership.member_id = wp_member_user.member_id  
		LEFT JOIN wp_membership_type  ON wp_membership_type.membership_type_id = wp_member_membership.membership_type_id  
		WHERE wp_member_user.user_id  = " . $logged_user->data->ID . " group by wp_member_membership.start_date order by wp_member_membership.start_date DESC");

			include_once(plugin_dir_path(__FILE__) . 'partials/member_transaction.php');
		} else {
			$redirectTo = home_url() . '/membership-plan?membership_expired=1';
			echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
			exit();
		}
	}
	public function state_action()
	{
		header("Content-Type: application/json");
		global $wpdb;
		$country = $_GET['country'];
		$query = "SELECT * from wp_states ";

		if (!empty($country)) {
			$query .= " WHERE country_type_id = " . $country . " ";
		}

		$query .= " ORDER BY state_type_id ASC ";
		$data = $wpdb->get_results($query);
		wp_reset_query();
		echo json_encode($data);

		wp_die();
	}

	public function chapter_action()
	{
		header("Content-Type: application/json");
		global $wpdb;
		$state = !empty($_GET['state']) ? $_GET['state'] : 0;
		$country = !empty($_GET['country']) ? $_GET['country'] : 0;

		$query = "SELECT t1.* from wp_chapters t1 INNER JOIN wp_states t2 ON t1.chapter_type_id = t2.chapter_type_id ";

		if (!empty($state)) {
			$query .= " WHERE t2.state_type_id = " . $state . " ";
		} elseif (!empty($country)) {
			$query = "SELECT t1.* from wp_chapters t1 INNER JOIN wp_states t2 ON t1.chapter_type_id = t2.chapter_type_id where t2.country_type_id = $country ";
		}

		$query .= " GROUP BY t1.chapter_type_id ORDER BY chapter_type_id ASC ";
		$data = $wpdb->get_results($query);
		wp_reset_query();

		echo json_encode($data);
		wp_die();
	}

	public function resetPassword()
	{
		global $wpdb;
		if (isset($_POST['reset_password_form']) && wp_verify_nonce($_POST['reset_password_form'], 'reset_password')) {

			try {
				$errors = array();

				$userKey = $wpdb->get_results("SELECT user_activation_key,ID FROM wp_users WHERE user_activation_key  = '" . $_POST['reset_key'] . "' ");

				if (empty($userKey[0]->user_activation_key)) {
					$redirectTo = home_url() . '/forgot-password?invalid_link=1';
					echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
					exit();
				} else {
					$recaptcha = $_POST['g-recaptcha-response'];
					$secret_key = GOOGLE_CAPTCHA_SECRET_KEY;
					$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha;

					$response = file_get_contents($url);
					$response = json_decode($response, true);
					if (!empty($response['error-codes'])) {
						$errors['googlecaptcha'] = 'CAPTCHA is invalid';
					} else {

						$newPassword = esc_sql($_POST['new_password']);
						if (empty($newPassword)) {
							$errors['new_password'] = "Please enter a New Password";
						} elseif (0 === preg_match("/.{6,}/", $_POST['new_password'])) {
							$errors['new_password'] = "Password must be at least six characters";
						}

						$cPassword = esc_sql($_POST['confirm_password']);
						if (empty($cPassword)) {
							$errors['confirm_password'] = "Please Confirm Password";
						} elseif (0 !== strcmp($_POST['new_password'], $_POST['confirm_password'])) // Check password confirmation_matches 
						{
							$errors['confirm_password'] = "Passwords do not match";
						}
						if ($_POST['old_password'] == $newPassword) {
							$errors['confirm_password'] = "Your new password cannot be the same as your current password";
						}
					}
				}
				if (empty($errors)) {

					wp_set_password($newPassword, $userKey[0]->ID);
					$blank = '';
					$wpdb->query(
						$wpdb->prepare("UPDATE wp_users
						SET user_activation_key = %s 
						WHERE ID = %d", $blank, $userKey[0]->ID)
					);
					$redirectTo = home_url() . '/login?password_updated=1';
					echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
					exit();
				}
			} catch (Exception $e) {
				echo 'Error writing to database: ',  $e->getMessage(), "\n";
			}
		} else {
			$userKey = $wpdb->get_results("SELECT user_activation_key,ID FROM wp_users WHERE user_activation_key  = '" . $_GET['key'] . "' ");

			if (empty($userKey[0]->user_activation_key)) {
				$redirectTo = home_url() . '/forgot-password?invalid_link=1';
				echo "<script type='text/javascript'>window.location.href='" . $redirectTo . "'</script>";
				exit();
			}
		}
		ob_start();
		include_once(plugin_dir_path(__FILE__) . 'partials/authentication/reset_password.php');
		return ob_get_clean();
	}


	public function createGsuiteAccessToken()
	{
		$curl = curl_init();
		$url='https://oauth2.googleapis.com/token?';
		$url .= 'code=4/0AWtgzh6GPG_2A5abvx7v3Ma4WJyYVNe0sjMawUuTlkbR-GsiwrqJqwDFzTlcxGw9W8bPxQ';
		$url .= '&client_id=635897124568-pns8ads1ja5e9235k680tnfgrachd5e4.apps.googleusercontent.com';
		$url .= '&client_secret=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';
		$url .= '&redirect_uri=http://newsite.odishasociety.org';
		$url .= '&grant_type=authorization_code';

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				'Content-Type:  application/x-www-form-urlencoded'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}

	public function addMemberToGsuiteGroup()
	{
		$curl = curl_init();

		$url='https://admin.googleapis.com/admin/directory/v1/groups/osa_testing@odishasociety.org/members?key=';
		$url .= 'key=[AIzaSyAnVYjReID2Lx5jfpQPjB0p0smPuF5mug4] HTTP/1.1';

		$accessToken= 'ya29.a0AVvZVsrlBL3-Vu6H7asyw1lXEq1omdc6VtksgD6cDFAXe7XggvWcLi1rcvDSJa3GBVDJDyQY1JRzYbo_xK9wZdIzbylwYNjEI7nGdeUZkMy6kwlRTR8rr6ufGJTqLIHKKM9FiuVqxDeu_HoblQ4E4npD1NfNaCgYKAXwSARISFQGbdwaIGkbNu0Xm5I8qaN_1api-TQ0163';

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
			"email": "naveenb@mindfiresolutions.com",
			"role": "MEMBER"
			}
			',
			CURLOPT_HTTPHEADER => array(
				'Accept:  application/json',
				'Content-Type:  application/json',
				'Authorization: Bearer '.$accessToken
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}

	public function reFreshGsuiteAccessToken()
	{
		$curl = curl_init();
		$url='https://oauth2.googleapis.com/token?';
		$url .= 'client_id=635897124568-pns8ads1ja5e9235k680tnfgrachd5e4.apps.googleusercontent.com';
		$url .= '&client_secret=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';
		$url .= '&refresh_token=1//0gn0vhfOsPtSyCgYIARAAGBASNwF-L9IrSNkW2xoESTPmozi5HVsF6SokSdMvFsqMgIvnIEv-a_oPjp2UzeGiNA-tFsNHeA7R__U';
		$url .= '&grant_type=refresh_token';

		$accessToken= 'ya29.a0AVvZVsrlBL3-Vu6H7asyw1lXEq1omdc6VtksgD6cDFAXe7XggvWcLi1rcvDSJa3GBVDJDyQY1JRzYbo_xK9wZdIzbylwYNjEI7nGdeUZkMy6kwlRTR8rr6ufGJTqLIHKKM9FiuVqxDeu_HoblQ4E4npD1NfNaCgYKAXwSARISFQGbdwaIGkbNu0Xm5I8qaN_1api-TQ0163';

		curl_setopt_array($curl, array(
			//CURLOPT_URL => 'https://oauth2.googleapis.com/token?client_id=635897124568-pns8ads1ja5e9235k680tnfgrachd5e4.apps.googleusercontent.com&client_secret=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&refresh_token=1//0gn0vhfOsPtSyCgYIARAAGBASNwF-L9IrSNkW2xoESTPmozi5HVsF6SokSdMvFsqMgIvnIEv-a_oPjp2UzeGiNA-tFsNHeA7R__U&grant_type=refresh_token',
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				'Content-Type:  application/x-www-form-urlencoded',
				'Authorization: Bearer '.$accessToken
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}
}
