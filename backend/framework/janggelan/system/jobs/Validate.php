<?php namespace system\jobs;

trait Validate
{
    /**
    ***************************************************************************
    * Fungsi untuk melakukan pembersihan data 'Single'. Fungsi ini digunakan untuk
    * keamanan Database. Data akan divalidasi untuk menghindari hal-hal yang tidak
    * diinginkan.
    *
    * @param    string|int    $data
    * @return   string|bool
    *
    */
    public function VALIDATE_SQL_DATA($data)
    {
        $isData     = is_string($data) OR is_int($data) ? TRUE : FALSE;
        $validData  = $isData == TRUE ? $validData = addslashes($data) : FALSE;
        $returnData = $validData != FALSE ? $validData : FALSE;

        return $returnData;
    }

    // Sedang dalam proses
    // /**
    // ***************************************************************************
    // *
    // *
    // * @param    string    $data
    // * @return   array
    // *
    // */
    // public function VALIDATE_CLAUSE_DATA($data)
    // {
    //     $isData     = is_string($data) OR is_int($data) ? TRUE : FALSE;
    //     $validData  = $isData == TRUE ? $validData = addslashes($data) : FALSE;
    //     $returnData = $validData != FALSE ? $validData : FALSE;
    //
    //     return $returnData;
    // }
}
