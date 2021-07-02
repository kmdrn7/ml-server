<?php

if (!function_exists('admin')) {
    function admin($url) {
        return url(config('app.admin_url').'/'.$url);
    }
}

if (!function_exists('uploads')) {
    function uploads($url) {
        return url('uploads/'.$url);
    }
}