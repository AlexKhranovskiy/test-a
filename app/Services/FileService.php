<?php

namespace App\Services;

use App\Traits\LoggerTrait;

class FileService
{
    use LoggerTrait;

    protected string $directory;
    protected string $fileName;

    public function setDirectory(string $directory)
    {
        $this->writeInfoLog('setDirectory', [
            'directory' => $directory,
        ]);
        $this->directory = $directory;
    }

    public function setFileName(string $fileName)
    {
        $this->writeInfoLog('setFileName', [
            'fileName' => $fileName,
        ]);
        $this->fileName = $fileName;
    }

    public function getFileDirectory()
    {
        $this->writeInfoLog('getFileDirectory', [
            '$this->directory' => $this->directory,
        ]);
        return $this->directory;
    }

    public function getFileName()
    {
        $this->writeInfoLog('getFileName', [
            '$this->fileName' => $this->fileName,
        ]);
        return $this->fileName;
    }

//    public function changeFileExtensionToJpg()
//    {
//        $this->writeInfoLog('changeFileExtensionToJpg', [
//            '$this->fileName' => $this->fileName,
//        ]);
//        $fileNameItems = explode('.', $this->fileName);
//        $fileNameItems[1] = 'jpg';
//        $this->fileName = implode('.', $fileNameItems);
//        $this->writeInfoLog('changeFileExtensionToJpg ended', [
//            '$this->fileName' => $this->fileName,
//        ]);
//    }

//    public function deleteFile()
//    {
//        $this->writeInfoLog('deleteFile',[
//            '$this->fileName' => $this->fileName,
//            '$this->directory' => $this->directory
//        ]);
//        unlink($this->directory . '/' . $this->fileName);
//        $this->fileName = '';
//    }

    public function renameFileExtension(string $extension)
    {
        $this->writeInfoLog('renameExtension', [
            '$this->fileName' => $this->fileName,
            '$extension' => $extension
        ]);
        $fileNameItems = explode('.', $this->fileName);
        $fileNameItems[1] = $extension;
        $newFileName = implode('.', $fileNameItems);
        rename($this->directory . '/' . $this->fileName, $this->directory . '/' . $newFileName);
        $this->fileName = $newFileName;
        $this->writeInfoLog('renameExtension ended', [
            '$this->fileName' => $this->fileName,
        ]);

    }

    public function hasJpgOrJpegExtension()
    {
        $lowerFileExtension = strtolower(explode('.', $this->fileName)[1]);
        $this->writeInfoLog('hasJpgOrJpegExtension', [
            'result' => $lowerFileExtension == 'jpg' || $lowerFileExtension == 'jpeg'
        ]);
        return $lowerFileExtension == 'jpg' || $lowerFileExtension == 'jpeg';
    }
}
