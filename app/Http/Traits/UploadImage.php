<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\Visibility;

trait UploadImage
{
    /**
     * Upload a file.
     *
     * This method uploads a file to the specified folder and returns the file path.
     *
     * @param  Request  $file The HTTP file object.
     * @param  string  $folder The folder to upload the file to.
     * @param  string  $fileColumnName The name of the file input field in the file.
     * @return string The file path.
     *
     * @throws Exception If the file name contains multiple file extensions.
     */
    function UploadImage($file)
    {
        $originalName = $file->getClientOriginalName();

        // Check for double extensions in the file name
        if (preg_match('/\.[^.]+\./', $originalName)) {
            throw new Exception(trans('general.notAllowedAction'), 403);
        }


        $storagePath = Storage::disk('public')->put('images', $file, [
            'visibility' => Visibility::PUBLIC
        ]);
        return $storagePath;


     }
    }

    /**
     * Check if a file exists and upload it.
     *
     * This method checks if a file exists in the file and uploads it to the specified folder.
     * If the file doesn't exist, it returns null.
     *
     * @param  Request  $file The HTTP file object.
     * @param  string  $folder The folder to upload the file to.
     * @param  string  $fileColumnName The name of the file input field in the file.
     * @return string|null The file path if the file exists, otherwise null.
     */
//     public function fileExists(Request $file, string $folder, string $fileColumnName)
//     {
//         if (empty($file->file($fileColumnName))) {
//             return null;
//         }
//         return $this->uploadFile($file, $folder, $fileColumnName);
//     }
// }
