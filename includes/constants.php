<?php
define('HOME_URL',home_url());
/* PAYMENT CONSTANTS START */
define('PAYPAL_ENABLE_SANDBOX', true);
if(PAYPAL_ENABLE_SANDBOX){

        define('PAYPAL_BUSSINESS_EMAIL', 'sb-nz8gr22345592@business.example.com');
}else{
        define('PAYPAL_BUSSINESS_EMAIL', 'treasurer@odishasociety.org');
}
define('PAYPAL_RETURN_URL', home_url('success-payment'));
define('PAYPAL_CANCEL_URL', home_url('cancel-payment'));
define('PAYPAL_NOTIFY_URL', home_url('payment-notify'));
define('PAYPAL_SANDBOX_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('PAYPAL_LIVE_URL', 'https://www.paypal.com/cgi-bin/webscr');
/* PAYMENT CONSTANTS END */

$variable = explode('?', basename($GLOBALS['_SERVER']['REQUEST_URI']));
define('SLUG_VALUE',$variable[0]);
define('CONTACT_US_URL',HOME_URL.'/contact-us');

define('COPYRIGHT_TEXT','Copyrights © 1969-'.date('Y').' The Odisha Society of the Americas. <br>All Rights Reserved');

/* IMAGE CONSTANTS START */
if( home_url() == 'http://osa.dev.local' || home_url() == 'http://osa-membership-local.com' ){
        define('DIR_URL',plugins_url('osa-membership/public/img'));
}else{            
        define('DIR_URL',plugins_url('membership/public/img'));
}
/* IMAGE CONSTANTS START */

/* EMAIL AND CAPTCHA CONSTANTS START */
if( home_url() == 'http://osa.dev.local' || home_url() == 'http://osa-membership-local.com')
{
        define('GOOGLE_CAPTCHA_SITE_KEY','6LdSiSUkAAAAAB-DiZc5Vdapb2QKPlB4UoNAQSDd');
        define('GOOGLE_CAPTCHA_SECRET_KEY','6LdSiSUkAAAAADUOlpalfGvsmlFNJ4uaR83Scx_o');
        define('ADMIN_EMAIL','mfsi.naveenb@gmail.com');
        define('CC_EMAIL','naveenb@mindfiresolutions.com,naveenbhardwaj3112@gmail.com');
}else{
        define('GOOGLE_CAPTCHA_SITE_KEY','6Ld-lS4kAAAAAAqEROukn-IsDdBkGwNDumjGX2Rr');
        define('GOOGLE_CAPTCHA_SECRET_KEY','6Ld-lS4kAAAAAG8-KwWxMMWMcr5C_YLx9DUXQFnj');
        define('ADMIN_EMAIL','osaec@odishasociety.org');
        define('CC_EMAIL','osaforyou@odishasociety.org');
}
/* EMAIL AND CAPTCHA CONSTANTS END */
define('FACEBOOK','https://www.facebook.com/groups/1902803256640735');
define('TWITTER','https://twitter.com/OdishaSocietyNA');
define('LINKEDIN','https://www.linkedin.com/company/the-odisha-society-of-the-americas');

/* GSUITE CONSTANTS START */
define('AUTH_TOKEN_URL','https://oauth2.googleapis.com/token?');
define('AUTH_CLIENT_ID',get_option( 'auth_client_id' ));
define('AUTH_CLIENT_SECRET',get_option( 'auth_client_secret' ));
define('REFRESH_TOEKN',get_option( 'refresh_token' ));
define('ACCESS_TOKEN',get_option( 'access_token' ));
define('ADD_MEMBER_URL','https://admin.googleapis.com/admin/directory/v1/groups/osa_testing@odishasociety.org/members?');
define('APP_KEY',get_option( 'app_key' ));
define('DELETE_MEMBER_URL','https://admin.googleapis.com/admin/directory/v1/groups/osa_testing@odishasociety.org/members/');
/* GSUITE CONSTANTS END */
