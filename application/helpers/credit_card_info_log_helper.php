<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('log_creditcard_info_request_activity')) {
    function log_creditcard_info_request_activity($adminEmail,$receiverEmail) {
        $CI =& get_instance();
        $CI->load->helper('file');

        // Define the log path and file name
        $log_path = APPPATH . 'logs/';
        $log_file = $log_path . 'creditcard_info_request_log_' . date('Y_m') . '.log';

        // Get the current timestamp and user IP address
        $timestamp = date('Y-m-d H:i:s');
        $ip_address = $CI->input->ip_address();

        // Create the log message
        $log_message = "[$timestamp] - Requester Email: ".$adminEmail." - Receiver Email:".$receiverEmail." - IP: $ip_address" . PHP_EOL;

        // Write to the log file (append mode)
        if (!write_file($log_file, $log_message, 'a+')) {
            log_message('error', 'Unable to write user activity log.');
        }
    }
}
