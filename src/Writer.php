<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 14/10/2015
 * Time: 09:29
 */
class Writer
{
    /**
     * @param $path
     * @param $txtToWrite
     */
    public static function write($path, $txtToWrite)
    {
        //$myfile = fopen($path, "w") or die("Unable to open file!");;
        file_put_contents($path, $txtToWrite,FILE_APPEND);
        //fclose($path);
    }
}