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
		$url = ADD_MEMBER_URL.'key='.APP_KEY;
		$data['role'] = 'MEMBER';
		$data['email'] = $email;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
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
			$url = AUTH_TOKEN_URL;
			$url .= 'client_id=' . AUTH_CLIENT_ID;
			$url .= '&client_secret=' . AUTH_CLIENT_SECRET;
			$url .= '&refresh_token=' . REFRESH_TOEKN;
			$url .= '&grant_type=refresh_token';
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

	public function deleteMemberFromGsuiteGroup($accessToken = '',$email='')
	{
	
			$curl = curl_init();
			$url = DELETE_MEMBER_URL.$email.'?key='.APP_KEY;
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			$headers = array();
			$headers[] = 'Authorization: Bearer '. $accessToken;
			$headers[] = 'Accept: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);

			return empty($result) ? 1 : 0;
	}
}
