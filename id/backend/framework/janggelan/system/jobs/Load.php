<?php namespace system\jobs;

trait Load
{
    /**
    *
    * Fungsi untuk memanggil View.
    *
    * @param    string   $request
    * @param    array    $data
    * @return   mixed
    *
    */
    public function LOAD_VIEW($request, array $data = [])
    {
        new \system\parents\View($request, $data);
    }
}
