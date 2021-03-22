<?php
if (!function_exists('cloudlink')) {
    function cloudlink($path) {
        return config('app.url').'/'.$path;
    }
}
