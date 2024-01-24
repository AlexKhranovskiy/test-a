<?php

namespace App\Services;

use App\Traits\LoggerTrait;

class TinyPngService
{
    use LoggerTrait;

    /** Resizes and handles image file using thumb algorithm.
     * @param string $fileDirectory
     * @param string $fileName
     * @param int $width
     * @param int $height
     * @return void
     */
    public function fitPhotoByThumbAlgorithm(
        string $fileDirectory, string $fileName, int $width = 70, int $height = 70
    ): void
    {
        $this->writeInfoLog('fitPhotoByThumbAlgorithm', [
            '$fileDirectory' => $fileDirectory,
            '$fileName' => $fileName,
        ]);
        \Tinify\setKey(env('TINY_PNG_SERVICE_API_KEY', 'lpFY4p5k4bzqgtDV8H3pBTg1h748SyzY'));
        $source = \Tinify\fromFile($fileDirectory . '/' . $fileName);
        $resized = $source->resize(array(
            "method" => "thumb",
            "width" => $width,
            "height" => $height
        ));
        $resized->toFile($fileDirectory . '/' . $fileName);
        $this->writeInfoLog('fitPhotoByThumbAlgorithm ended', [
            '$fileDirectory' => $fileDirectory,
            '$fileName' => $fileName,
        ]);
    }

    /** Converts format of image file to jpeg.
     * @param string $fileDirectory
     * @param string $fileName
     * @return string
     */
    public function convertToJpeg(string $fileDirectory, string $fileName): string
    {
        \Tinify\setKey(env('TINY_PNG_SERVICE_API_KEY', 'lpFY4p5k4bzqgtDV8H3pBTg1h748SyzY'));
        $source = \Tinify\fromFile($fileDirectory . '/' . $fileName);
        $converted = $source->convert(array("type" => ["image/jpeg"]));
        $extension = $converted->result()->extension();
        $converted->toFile($fileDirectory . '/' . $fileName);

        return $extension;
    }
}
