<?php

if (!function_exists('base_path')) {

    /**
     * Generate a path relative to the project root.
     * @param  string $path
     * @return string
     */
    function base_path($path = "")
    {
        return BASE_PATH . $path;
    }
}