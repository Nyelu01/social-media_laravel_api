<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    function storeBase64File($base64String, $storagePath)
    {
        try {
            // Extract the base64 part (remove data:image/jpeg;base64,)
            $base64Data = substr($base64String, strpos($base64String, ',') + 1);

            // Decode the base64 string to binary dataBase
            $binaryData = base64_decode($base64Data);

            // Get the file extension from the base64 string
            $fileExtension = explode('/', mime_content_type('data:' . $base64String))[1];

            // Generate a unique file name with the original extension
            $fileName = uniqid('file_') . '.' . $fileExtension;

            // Create the full path within the storage directory
            $filePath = $storagePath . '/' . $fileName;

            // Store the file in Laravel's storage
            Storage::disk('public')->put($filePath, $binaryData);

            // Return the path with the generated image name
            return $filePath;

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => "something went wrong in FileTrait.storeBase64File"
            ], 500);
        }
    }

    public function checkIfFileExist($storagePath)
    {
        if (!isset($storagePath) || $storagePath == null) {
            return false;
        }
        Storage::disk('public')->exists($storagePath);
    }

    public function deleteFileFromStorage($storagePath)
    {
        if ($this->checkIfFileExist($storagePath)) {
            Storage::disk('public')->delete($storagePath);
            return true;
        }
        return false;
    }
}
