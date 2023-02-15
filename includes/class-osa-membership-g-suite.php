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
class Osa_Membership_G_Suite
{

	/* public function __construct()
	{
		return 1;
	}
 */
	public function createGsuiteAccessToken()
	{
		$curl = curl_init();
		$url = 'https://oauth2.googleapis.com/token?';
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
				'Content-Type:  application/x-www-form-urlencoded',
				'Content-Length: 0'
			),
		));
		$response = curl_exec($curl);
		echo "<pre>";
		print_r($response);
		die;
		curl_close($curl);
		echo $response;
	}

	public function addMemberToGsuiteGroup($accessToken = '',$email='')
	{
		//$url = 'https://admin.googleapis.com/admin/directory/v1/groups/osa_testing@odishasociety.org/members?';
		$url = ADD_MEMBER_URL.'key='.APP_KEY;
		
		//$accessToken = 'ya29.a0AVvZVso4Qr0qRSy0XdIW5NJI7PQt3M7r-dxLKP5iAjZ1zfPAClBZBQWm8O1hRwETGkHW3hARVUzu_l-VzfcA86SGKNyMi1nChqaNS3XfT0tHy7LOnJtSmX4kc8t47DeY6UxvWI_UhTz7qgqs9LHAdsZ-ehAHYEeAaCgYKARoSAQASFQGbdwaIwfyrHW8hIsLXHGkb2E9yoA0167';
		$data['role'] = 'MEMBER';
		$data['email'] = $email;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_URL, 'https://admin.googleapis.com/admin/directory/v1/groups/osa_testing@odishasociety.org/members?key=AIzaSyAnVYjReID2Lx5jfpQPjB0p0smPuF5mug4');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"email\": \"naveenbhardwaj3112@gmail.com\",\n    \"role\": \"MEMBER\"\n}");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		$headers = array();
		$headers[] = 'Accept: application/json';
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer ' . $accessToken;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		$response= json_decode($result,true);
		if(!empty($response['status']) && $response['status'] == 'ACTIVE')
		{
			$response['status'] =1;
			return $response;
		}else{
			$response['status'] =0;
			return $response;
		}
	}

	public function reFreshGsuiteAccessToken()
	{
		try {
			$curl = curl_init();
			/* $url='https://oauth2.googleapis.com/token?';
		$url .= 'client_id=635897124568-pns8ads1ja5e9235k680tnfgrachd5e4.apps.googleusercontent.com';
		$url .= '&client_secret=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';
		$url .= '&refresh_token=1//0gn0vhfOsPtSyCgYIARAAGBASNwF-L9IrSNkW2xoESTPmozi5HVsF6SokSdMvFsqMgIvnIEv-a_oPjp2UzeGiNA-tFsNHeA7R__U';
		$url .= '&grant_type=refresh_token';

		$accessToken= 'ya29.a0AVvZVsrlBL3-Vu6H7asyw1lXEq1omdc6VtksgD6cDFAXe7XggvWcLi1rcvDSJa3GBVDJDyQY1JRzYbo_xK9wZdIzbylwYNjEI7nGdeUZkMy6kwlRTR8rr6ufGJTqLIHKKM9FiuVqxDeu_HoblQ4E4npD1NfNaCgYKAXwSARISFQGbdwaIGkbNu0Xm5I8qaN_1api-TQ0163'; */
			$url = AUTH_TOKEN_URL;
			$url .= 'client_id=' . AUTH_CLIENT_ID;
			$url .= '&client_secret=' . AUTH_CLIENT_SECRET;
			$url .= '&refresh_token=' . REFRESH_TOEKN;
			$url .= '&grant_type=refresh_token';

			/* $accessToken= 'ya29.a0AVvZVsrlBL3-Vu6H7asyw1lXEq1omdc6VtksgD6cDFAXe7XggvWcLi1rcvDSJa3GBVDJDyQY1JRzYbo_xK9wZdIzbylwYNjEI7nGdeUZkMy6kwlRTR8rr6ufGJTqLIHKKM9FiuVqxDeu_HoblQ4E4npD1NfNaCgYKAXwSARISFQGbdwaIGkbNu0Xm5I8qaN_1api-TQ0163'; */
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
					'Content-Type:  application/x-www-form-urlencoded',
					'Authorization: Bearer ' . ACCESS_TOKEN,
					'Content-Length: 0'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$response = json_decode($response, true);
			$result = !empty($response['access_token']) ? $response['access_token'] : 0;
			return $result;

		} catch (Exception $e) {
			echo 'Exception: ',  $e->getMessage(), "\n";
		}
	}
}
