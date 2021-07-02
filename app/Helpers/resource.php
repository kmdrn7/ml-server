<?php

if (!function_exists('backend')) {
    function backend($path) {
        return url('assets/backend/'.$path);
    }
}

if (!function_exists('frontend')) {
    function frontend($path) {
        return url('assets/frontend/'.$path);
    }
}