<?php

namespace App\Services;

use App\Traits\LoggerTrait;

class TinyPngService
{
    use LoggerTrait;
    public function __construct()
    {
        \Tinify\setKey(env('TINY_PNG_SERVICE_API_KEY', 'lpFY4p5k4bzqgtDV8H3pBTg1h748SyzY'));
    }

    public function setFileParameters()
    {

    }

    public function fitPhotoByThumbAlgorithmConvertToJpg(string $fileDirectory, string $sourceFileName, int $width = 70, int $height = 70)
    {
        $this->writeInfoLog('Called fitPhotoByThumbAlgorithmConvertToJpg', [
            'fileDirectory' => $fileDirectory,
            'sourceFileName' => $sourceFileName
        ]);
        $fileNameItems = explode('.', $sourceFileName);
        $fileName = $fileNameItems[0];
        $fileExtension = $fileNameItems[1];

        $this->writeInfoLog('Taken file params', [
            'fileName' => $fileName,
            'fileExtension' => $fileExtension
        ]);

        $lowerFileExtension = strtolower($fileExtension);

        $this->writeInfoLog('strtolower of file extension', [
            'lowerFileExtension' => $lowerFileExtension
        ]);

        if ($lowerFileExtension != 'jpg' && $lowerFileExtension != 'jpeg') {

            $this->writeInfoLog('lowerFileExtension != jpg and != jpeg', [
                'lowerFileExtension' => $lowerFileExtension
            ]);

            $this->writeInfoLog('File params now', [
                'fileDirectory' => $fileDirectory,
                'sourceFileName' => $sourceFileName,
            ]);

            $source = \Tinify\fromFile($fileDirectory . '/' .$sourceFileName);
            $converted = $source->convert(array("type" => ["image/jpeg"]));
            $extension = $converted->result()->extension();
            $converted->toFile($fileDirectory . '/' . $fileName . '.' . $extension);

            $this->writeInfoLog('Converted', [
                'saved with' => [
                    'fileDirectory' => $fileDirectory,
                    'fileName' => $fileName,
                    'extension' => $extension,
                ]
            ]);

            unlink($sourceFileName);

            $this->writeInfoLog('Removed file', [
                'sourceFileName' => $sourceFileName,
            ]);

            $sourceFileName = $fileName . '.' . $extension;

            $this->writeInfoLog('sourceFileName now', [
                'sourceFileName' => $sourceFileName,
            ]);
        }

        $this->writeInfoLog('File params now', [
            'fileDirectory' => $fileDirectory,
            'sourceFileName' => $sourceFileName,
        ]);

        $source = \Tinify\fromFile($fileDirectory . '/' .$sourceFileName);
        $resized = $source->resize(array(
            "method" => "thumb",
            "width" => $width,
            "height" => $height
        ));
        $resized->toFile($fileDirectory . '/' .$sourceFileName);

        $this->writeInfoLog('Resized and saved with', [
            'fileDirectory' => $fileDirectory,
            'sourceFileName' => $sourceFileName,
        ]);

        $this->writeInfoLog('Returned sourceFileName', [
            'sourceFileName' => $sourceFileName,
        ]);

        return $sourceFileName;
    }
}
