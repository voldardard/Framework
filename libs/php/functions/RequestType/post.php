<?php
require_once(F_DIRECTORY . 'libs/php/functions/template.php');
require_once(F_DIRECTORY . 'libs/php/functions/verify.php');

class post
{

    private $template;
    private $verify;

    function __construct()
    {
        $this->template = new template();
        $this->verify = new verify();
    }

    function login()
    {
        if ((isset($_POST['username'])) AND (isset($_POST['password']))) {
            /** Action on databse to connect and edit Session() */
        }

    }

}