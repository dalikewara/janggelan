<?php namespace framework\kernel\jobs\traits\support;

/*
* The built in 'Cache' class.
*/
trait Cache
{
    /**
    * Handle for delete all route caches.
    *
    * @return   mixed
    */
    public function CLEAN_ROUTE_CACHES()
    {
        // Getting request cache directory.
        $dir = __DIR__ . '/../../../../storage/cache/uri';

        // Checking for the directory.
        if(file_exists($dir) AND is_dir($dir))
        {
            // Directory listing.
            $files = array_diff(scandir($dir), array('..', '.'));

            // Delete all files in the directory.
            foreach($files as $file)
            {
                unlink($dir . '/' . $file);
            }
        }
    }
}
