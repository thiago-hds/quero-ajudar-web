<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ImageUploader
{
    public function upload(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('File does not exist');
        }

        try {
            $path = cloudinary()
                    ->upload($filePath)
                    ->getSecurePath();

            return $path;
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            throw new \Exception("Could not upload image: {$ex->getMessage()}");
        }
    }
}
