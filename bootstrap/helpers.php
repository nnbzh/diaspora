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
