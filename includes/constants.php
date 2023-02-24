<?php
define('HOME_URL',home_url());
define('PAYPAL_ENABLE_SANDBOX', true);
define('PAYPAL_BUSSINESS_EMAIL', 'sb-nz8gr22345592@business.example.com');
define('PAYPAL_RETURN_URL', home_url('success-payment'));
define('PAYPAL_CANCEL_URL', home_url('cancel-payment'));
define('PAYPAL_NOTIFY_URL', home_url('payment-notify'));
define('PAYPAL_SANDBOX_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('PAYPAL_LIVE_URL', 'https://www.paypal.com/cgi-bin/webscr');
$variable = explode('?', basename($GLOBALS['_SERVER']['REQUEST_URI']));
define('SLUG_VALUE',$variable[0]);
define('CONTACT_US_URL',HOME_URL.'/contact-us');
//define('ADMIN_EMAIL','mfsi.naveenb@gmail.com');
define('ADMIN_EMAIL','vicepresident@odishasociety.org');
define('COPYRIGHT_TEXT','Copyrights © 1969-'.date('Y').' The Odisha Society of the Americas. <br>All Rights Reserved');
if( home_url() == 'http://osa.dev.local' || home_url() == 'http://osa-membership-local.com' ){
        define('DIR_URL',plugins_url('osa-membership/public/img'));
}else{            
        define('DIR_URL',plugins_url('membership/public/img'));
}
if( home_url() == 'http://osa.dev.local')
{
        define('GOOGLE_CAPTCHA_SITE_KEY','6LdSiSUkAAAAAB-DiZc5Vdapb2QKPlB4UoNAQSDd');
        define('GOOGLE_CAPTCHA_SECRET_KEY','6LdSiSUkAAAAADUOlpalfGvsmlFNJ4uaR83Scx_o');
}else{
        define('GOOGLE_CAPTCHA_SITE_KEY','6Ld-lS4kAAAAAAqEROukn-IsDdBkGwNDumjGX2Rr');
        define('GOOGLE_CAPTCHA_SECRET_KEY','6Ld-lS4kAAAAAG8-KwWxMMWMcr5C_YLx9DUXQFnj');
}
define('FACEBOOK','https://www.facebook.com/groups/1902803256640735');
define('TWITTER','https://twitter.com/OdishaSocietyNA');
define('LINKEDIN','https://www.linkedin.com/company/the-odisha-society-of-the-americas');

define('AUTH_TOKEN_URL','https://oauth2.googleapis.com/token?');
define('AUTH_CLIENT_ID',get_option( 'auth_client_id' ));
define('AUTH_CLIENT_SECRET',get_option( 'auth_client_secret' ));
define('REFRESH_TOEKN',get_option( 'refresh_token' ));
define('ACCESS_TOKEN',get_option( 'access_token' ));
define('ADD_MEMBER_URL','https://admin.googleapis.com/admin/directory/v1/groups/osa_testing@odishasociety.org/members?');
define('APP_KEY',get_option( 'app_key' ));
