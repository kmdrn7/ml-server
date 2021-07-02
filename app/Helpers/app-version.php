<?php

if (!function_exists('app_version')) {
    function app_version() {
        return config('app.debug') ? rand(0, 999) : config('app.version');
    }
}