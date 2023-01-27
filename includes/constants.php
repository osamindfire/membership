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
define('ADMIN_EMAIL','mfsi.naveenb@gmail.com');
define('COPYRIGHT_TEXT','Copyrights © 1969-'.date('Y').' The Odisha Society of the Americas. <br>All Rights Reserved');
define('DIR_URL',plugins_url('osa-membership/public/img'));
if( home_url() == 'http://osa.dev.local')
{
        define('GOOGLE_CAPTCHA_SITE_KEY','6LdSiSUkAAAAAB-DiZc5Vdapb2QKPlB4UoNAQSDd');
        define('GOOGLE_CAPTCHA_SECRET_KEY','6LdSiSUkAAAAADUOlpalfGvsmlFNJ4uaR83Scx_o');
}else{
        define('GOOGLE_CAPTCHA_SITE_KEY','6Ld-lS4kAAAAAAqEROukn-IsDdBkGwNDumjGX2Rr');
        define('GOOGLE_CAPTCHA_SECRET_KEY','6Ld-lS4kAAAAAG8-KwWxMMWMcr5C_YLx9DUXQFnj');
}


//define('DIR_URL','https://newsite.odishasociety.org/wp-content/uploads/2023/01');

