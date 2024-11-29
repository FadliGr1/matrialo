<?php

if (!function_exists('getSettingRoute')) {
    function getSettingRoute() {
        $role = auth()->user()->role;
        return route($role . '.setting');
    }
}