<?php

namespace App\Services;

class FileService
{
    protected string $directory;
    protected string $fileName;

    public function setFileParams(string $directory, string $fileName)
    {
        $this->directory = $directory;
        $this->fileName = $fileName;
        return $this;
    }

    public function deleteFile()
    {
        unlink($this->directory . '/' . $this->fileName);
        return $this;
    }

    public function hasJpgOrJpegExtension()
    {
        $lowerFileExtension = strtolower(explode('.', $this->fileName)[1]);
        return $lowerFileExtension == 'jpg' || $lowerFileExtension == 'jpeg';
    }
}
