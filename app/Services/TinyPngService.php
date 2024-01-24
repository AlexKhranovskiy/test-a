<?php

namespace App\Services;

use App\Traits\LoggerTrait;

class TinyPngService
{
    use LoggerTrait;

    public function fitPhotoByThumbAlgorithm(
        string $fileDirectory, string $fileName, int $width = 70, int $height = 70
    )
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

    public function convertToJpeg(string $fileDirectory, string $fileName)
    {
        $this->writeInfoLog('convertToJpeg', [
            '$fileDirectory' => $fileDirectory,
            '$fileName' => $fileName,
        ]);

        \Tinify\setKey(env('TINY_PNG_SERVICE_API_KEY', 'lpFY4p5k4bzqgtDV8H3pBTg1h748SyzY'));
        $source = \Tinify\fromFile($fileDirectory . '/' . $fileName);
        $converted = $source->convert(array("type" => ["image/jpeg"]));
        $extension = $converted->result()->extension();
        $converted->toFile($fileDirectory . '/' . $fileName);

        $this->writeInfoLog('convertToJpeg ended', [
            '$fileDirectory' => $fileDirectory,
            '$fileName' => $fileName,
        ]);
        return $extension;
    }

//    public function fitPhotoByThumbAlgorithmConvertToJpg(string $fileDirectory, string $sourceFileName, int $width = 70, int $height = 70)
//    {
//        \Tinify\setKey(env('TINY_PNG_SERVICE_API_KEY', 'lpFY4p5k4bzqgtDV8H3pBTg1h748SyzY'));
//        $this->writeInfoLog('Called fitPhotoByThumbAlgorithmConvertToJpg', [
//            'fileDirectory' => $fileDirectory,
//            'sourceFileName' => $sourceFileName
//        ]);
//        $fileNameItems = explode('.', $sourceFileName);
//        $fileName = $fileNameItems[0];
//        $fileExtension = $fileNameItems[1];
//
//        $this->writeInfoLog('Taken file params', [
//            'fileName' => $fileName,
//            'fileExtension' => $fileExtension
//        ]);
//
//        $lowerFileExtension = strtolower($fileExtension);
//
//        $this->writeInfoLog('strtolower of file extension', [
//            'lowerFileExtension' => $lowerFileExtension
//        ]);
//
//        if ($lowerFileExtension != 'jpg' && $lowerFileExtension != 'jpeg') {
//
//            $this->writeInfoLog('lowerFileExtension != jpg and != jpeg', [
//                'lowerFileExtension' => $lowerFileExtension
//            ]);
//
//            $this->writeInfoLog('File params now', [
//                'fileDirectory' => $fileDirectory,
//                'sourceFileName' => $sourceFileName,
//            ]);
//
//            $source = \Tinify\fromFile($fileDirectory . '/' .$sourceFileName);
//            $converted = $source->convert(array("type" => ["image/jpeg"]));
//            $extension = $converted->result()->extension();
//            $converted->toFile($fileDirectory . '/' . $fileName . '.' . $extension);
//
//            $this->writeInfoLog('Converted', [
//                'saved with' => [
//                    'fileDirectory' => $fileDirectory,
//                    'fileName' => $fileName,
//                    'extension' => $extension,
//                ]
//            ]);
//
//            unlink($sourceFileName);
//
//            $this->writeInfoLog('Removed file', [
//                'sourceFileName' => $sourceFileName,
//            ]);
//
//            $sourceFileName = $fileName . '.' . $extension;
//
//            $this->writeInfoLog('sourceFileName now', [
//                'sourceFileName' => $sourceFileName,
//            ]);
//        }
//
//        $this->writeInfoLog('File params now', [
//            'fileDirectory' => $fileDirectory,
//            'sourceFileName' => $sourceFileName,
//        ]);
//
//        $source = \Tinify\fromFile($fileDirectory . '/' .$sourceFileName);
//        $resized = $source->resize(array(
//            "method" => "thumb",
//            "width" => $width,
//            "height" => $height
//        ));
//        $resized->toFile($fileDirectory . '/' .$sourceFileName);
//
//        $this->writeInfoLog('Resized and saved with', [
//            'fileDirectory' => $fileDirectory,
//            'sourceFileName' => $sourceFileName,
//        ]);
//
//        $this->writeInfoLog('Returned sourceFileName', [
//            'sourceFileName' => $sourceFileName,
//        ]);
//
//        return $sourceFileName;
//    }
}
