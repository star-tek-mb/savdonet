<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\UploadedFile;

class OptimizeImage
{
    private function create_image($filepath) {
        $type = exif_imagetype($filepath);
        switch ($type) {
            case IMAGETYPE_JPEG:
                $im = imagecreatefromjpeg($filepath);
                break;
            case IMAGETYPE_PNG:
                $im = imagecreatefrompng($filepath);
                break;
            case IMAGETYPE_BMP:
                $im = imagecreatefrombmp($filepath);
                break;
            case IMAGETYPE_WEBP:
                $im = imagecreatefromwebp($filepath);
                break;
            default:
                return null;
        }   
        return $im;
    }

    public function handle($request, Closure $next)
    {
        collect($request->allFiles())
            ->flatten()
            ->filter(function (UploadedFile $file) {
                return $file->isValid();
            })
            ->each(function (UploadedFile $file) {
                $img = $this->create_image($file->getPathName());
                if ($img) {
                    imagewebp($img, $file->getPathName());
                }
            });
        return $next($request);
    }
}