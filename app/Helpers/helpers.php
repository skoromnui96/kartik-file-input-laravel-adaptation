<?php

if (!function_exists('gallery_images')) {
    function gallery_images(string $path = '')
    {
        return asset('uploads/gallery/' . $path);
    }
}
