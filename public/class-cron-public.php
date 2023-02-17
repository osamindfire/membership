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
class Osa_Cron_Public
{
    public function membership_expire_cron(){

        global $wpdb;
  
        if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'membership-expired-cron'", 'ARRAY_A' ) ) {
            
            $current_user = wp_get_current_user();
            
            // create post object
            $page = array(
            'post_title'  => __( 'Membership Expired Cron' ),
            'post_status' => 'publish',
            'post_content'   => '[cron-shortcode]',
            'post_author' => $current_user->ID,
            'post_type'   => 'page',
            );
            
            // insert the post into the database
            wp_insert_post( $page );
        }

    }

    public function membership_expired_cron_callback(  ) {
        // ob_start();
        do_action('cron_job');      
        // return ob_get_clean();   
    }

    public function cron_job_callback(){

        $dayCurrent  =  date("Y-m-d");
		$dayAfterFive  = date('Y-m-d', strtotime(' + 5 days'));

		// echo $dayCurrent ;
		// echo $dayAfterFive ;

		global $wpdb;

		$query = $wpdb->prepare("SELECT  t2.id, t2.membership_expiry_date, wp_users.user_email,  wp_users.display_name 
		FROM wp_users
		INNER JOIN wp_member_user t1 ON wp_users.ID = t1.user_id
		INNER JOIN wp_member_other_info t2 ON t1.member_id = t2.member_id
		WHERE t2.membership_expiry_date IN ('$dayCurrent' , '$dayAfterFive')
		AND t1.parent_id = 0 
        AND t1.is_deleted = 0
        AND t2.expiry_email_sent IN (0,1)  
        ORDER BY t2.member_id ASC ;") ;

		// echo $query;
		// die;
		$data = $wpdb->get_results($query);
        
        // echo '<pre>';
        // print_r($data);
		// die;

        if(!empty($data)){
        foreach($data as $info){
            if( strtotime($info->membership_expiry_date) == strtotime($dayCurrent) ){
                $to = 'pooja.patle@mindfiresolutions.com';
                // $to = $info->user_email;  
                $user_info = [];
                $user_info['user_display'] = $info->display_name;
                $res = $this->sendMail($to , 'Membership Expired', $user_info , 'expiring today');
                if($res == 1){
                    $wpdb->update('wp_member_other_info', array('expiry_email_sent' => 2 ), array('id' => $info->id), array('%d'), array('%d'));
                }
                echo $res;
            }
            else{
                $to = 'naveenb@mindfiresolutions.com';
                // $to = $info->user_email;
                $user_info = [];
                $user_info['user_display'] = $info->display_name; 
                $res = $this->sendMail($to , 'Membership Expiring soon', $user_info , 'will be expire on '.$dayAfterFive.'');
                if($res == 1){
                    $wpdb->update('wp_member_other_info', array('expiry_email_sent' => 1 ), array('id' => $info->id), array('%d'), array('%d'));
                }
                echo $res;
            }
        }
        }
    
	}

	public function sendMail($to, $subject, $data = array(), $type = '')
	{
		include(plugin_dir_path(__FILE__) . 'partials/email_templates/cron_email.php');
       
		$headers = array('Content-Type: text/html; charset=UTF-8');
		try {
			$response = 0;
            $response=  wp_mail($to, $subject, $emailBody, $headers);
			return $response;
		} catch (Exception $e) {
			echo 'Error while sendnig mail: ',  $e->getMessage(), "\n" ;
		}

    }
}