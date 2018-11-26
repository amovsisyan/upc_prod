<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/25/18
 * Time: 10:22 AM
 */

namespace App\Helpers;


use Illuminate\Http\UploadedFile;

class FileHelper
{
    /**
     * @param $file
     * @return string
     */
    public static function getDimensions(UploadedFile $file): string
    {
        // sure not the best way
        $dmsPosition = 3;
        $dmsData = explode('"', getimagesize($file)[$dmsPosition]);

        $widthPosition = 1;
        $heightPosition = 3;
        return ($dmsData[$widthPosition] ?? 0) . 'x' . ($dmsData[$heightPosition] ?? 0);
    }


    /**
     * @param string $extension
     * @return string
     */
    public static function makeFileName(string $extension, string $forDisk): string
    {
        if ($forDisk === 'productAttachments') {
            return md5(microtime()).'.'.$extension;
        }

        return strtoupper($forDisk) . md5(microtime()).'.'.$extension;
    }
}