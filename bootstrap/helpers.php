<?php
if (!function_exists('cloudlink')) {
    function cloudlink($path) {
        return config('app.url').'/'.$path;
    }
}

if (!function_exists('get_timestamp')) {
    function get_timestamp($timestamp = null, $tz = null, $format = 'Y-m-d H:i:s') {
        if (!$tz) $tz = 'Asia/Almaty';
        date_default_timezone_set($tz);
        return date($format, $timestamp);
    }
}

if (!function_exists('generate_chars')) {
    function generate_chars(int $length = 8) {
        $chars = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $strLen = strlen($chars);
        $str = '';
        for ($i=0; $i < $length; $i++) {
            $str .= substr($chars, rand(1, $strLen) - 1, 1);
        }
        return $str;
    }
}
