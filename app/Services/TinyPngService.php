<?php

namespace App\Services;

class TinyPngService
{
    public function fitPhoto(string $fileName)
    {
        \Tinify\setKey("lpFY4p5k4bzqgtDV8H3pBTg1h748SyzY");
        $source = \Tinify\fromFile($fileName);
        $resized = $source->resize(array(
            "method" => "fit",
            "width" => 70,
            "height" => 70
        ));
        $resized->toFile($fileName);
    }
}
