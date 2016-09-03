<?php namespace system\jobs;

trait Get
{
    /**
    ***************************************************************************
    * Fungsi untuk mendapatkan data nama koneksi database bawaan
    *
    * @return   string
    *
    */
    public function GET_CONNECTION()
    {
        $artist = new \system\dragon_fire\artists\Job;

        return $artist->getConnection();
    }
}
