<?php

if (! function_exists('request_bool')) {
    function request_bool(string $key, bool $default = false): bool
    {
        $value = request()->input($key);

        if ($value === null) {
            return $default;
        }

        if (is_string($value)) {
            $value = trim($value, "\"'");
        }

        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        ) ?? $default;
    }
}