<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('image_to_base64_by_path')) {
    /**
     * Convert an image path to a Base64 string
     *
     * @param string $path
     * @return string|null
     */
    function image_to_base64_by_path(string $path): ?string
    {
        if (!file_exists($path)) {
            return null;
        }

        $mime = mime_content_type($path);
        $data = base64_encode(file_get_contents($path));

        return "data:$mime;base64,$data";
    }
}
