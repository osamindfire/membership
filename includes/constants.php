<?php

define('PAYPAL_ENABLE_SANDBOX', true);
define('PAYPAL_BUSSINESS_EMAIL', 'sb-bmszd23949600@business.example.com');
define('PAYPAL_RETURN_URL', home_url('payment-success'));
define('PAYPAL_CANCEL_URL', home_url('payment-cancel'));
define('PAYPAL_NOTIFY_URL', home_url('payment-notify'));
define('PAYPAL_SANDBOX_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('PAYPAL_LIVE_URL', 'https://www.paypal.com/cgi-bin/webscr');
define('SLUG_VALUE',str_replace("/","",$GLOBALS['_SERVER']['REDIRECT_URL']));
/* const paypalConfig = [
    'bussiness_email' => 'sb-bmszd23949600@business.example.com',
    'return_url' => home_url('payment-success'),
    'cancel_url' => home_url('payment-cancel'),
    'notify_url' => home_url('payment-process')
]; */
