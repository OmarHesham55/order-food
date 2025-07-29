<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageUploadService
{
    public static function handleImageUpload($image, $uploadPath,$oldImage = null)
    {
        $imageName = time() . '.' . $image->extension();
        $destinationPath = public_path($uploadPath);

        // Delete old image if exists
        if ($oldImage && File::exists($destinationPath . $oldImage)) {
            File::delete($destinationPath . $oldImage);
        }

        $image->move($destinationPath, $imageName);

        return $imageName;
    }
}
