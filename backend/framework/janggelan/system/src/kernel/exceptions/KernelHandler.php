<?php namespace framework\kernel\exceptions;

class KernelHandler extends \Exception
{
    public function err()
    {
        if(ini_get('display_errors') == TRUE)
        {
            die($this->getMessage());
        }
    }
}
