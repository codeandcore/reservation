<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.elasticemail.com',
    'smtp_port' => 2525,
    //Our cloudways details
    // 'smtp_user' => '69D686C3C18FE59D5BE27A5DA0B2020E27FE0EBF162269445B970A28BCD2173701CC6DF625D6F8EAB1ECD8DCAA239F57',
    // 'smtp_pass' => '69D686C3C18FE59D5BE27A5DA0B2020E27FE0EBF162269445B970A28BCD2173701CC6DF625D6F8EAB1ECD8DCAA239F57',

    //Client's elastiemail key
    'smtp_user' => '87605FD168127E3DF7CD546B234B8D14758E5771F161A3748AFDC2F54A9C4C4FCE8D2C1F9EFCEB2B2144C9BD7A90E663',
    'smtp_pass' => '87605FD168127E3DF7CD546B234B8D14758E5771F161A3748AFDC2F54A9C4C4FCE8D2C1F9EFCEB2B2144C9BD7A90E663',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'charset' => 'iso-8859-1',
);
// $config = array(
//     'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
//     'smtp_host' => 'mail.2022premieranguilla.com',
//     'smtp_port' => 587,
//     'smtp_user' => 'smtp@2022premieranguilla.com',
//     'smtp_pass' => 'Br8Nft&thX~#',
//     'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
//     'charset' => 'iso-8859-1',
// );