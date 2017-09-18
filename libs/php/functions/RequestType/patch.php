<?php
require_once(F_DIRECTORY . 'libs/php/functions/template.php');
require_once(F_DIRECTORY . 'libs/php/functions/verify.php');

class patch
{

    private $template;
    private $verify;

    function __construct()
    {
        $this->template = new template();
        $this->verify = new verify();
    }

}