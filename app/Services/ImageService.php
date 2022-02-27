<?php
namespace App\Services;

/**
 *
 */
class ImageService
{
    const POST_STORAGE_PATH = '';

    public static function saveImages($files, $path, $is_array = false) {
        // var_dump($files);
        $data = [];
        if ($files) {
            if ($is_array) {
                for ($i=0; $i < count($files); $i++) {
                    $data[] = $files[$i]->store($path);
                }
            } else {
                $data = $files->store($path);
            }
        }
        return $data;
    }
}
