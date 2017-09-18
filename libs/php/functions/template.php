<?php

class template
{

    private $title;

    function addHeaders($title = 'API WebAcess', $id = 'apiwebaccess')
    {
        $this->title = $title;
        include(F_DIRECTORY . '/libs/php/ressources/headers.php');

    }

    function addFooters()
    {
        include(F_DIRECTORY . '/libs/php/ressources/footers.php');

    }

    function addMenu()
    {
        include(F_DIRECTORY . '/libs/php/ressources/menu.php');
    }


}