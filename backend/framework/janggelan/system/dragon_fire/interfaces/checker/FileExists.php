<?php namespace system\dragon_fire\interfaces\checker;

interface FileExists
{
    /**
    ***************************************************************************
    * Mengecek apakah file ada atau tidak
    *
    * @param    string   $filePath
    * @param    string   $fileName
    * @return   mixed
    *
    */
    public function fileExists($filePath, $fileName);
}
