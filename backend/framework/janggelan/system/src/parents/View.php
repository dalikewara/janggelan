<?php namespace framework\parents;

/*
 * This class is used to calls requested View. Maybe you know
 * how to do it better, contact at <dalikewara@windowslive.com>, or
 * fork on GitHub/Bitbucket at github.com/dalikewara/janggelan | bitbucket.org/dalikewara/janggelan
*/
class View
{
    function __construct($ePATHe, array $eDATAe)
    {
        // Extract the data if it comes with values.
        if(!is_null($eDATAe))
        {
            extract($eDATAe);
        }

        // Calls the view.
        require_once($ePATHe);
    }
}
