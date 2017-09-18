<?php
require_once(F_DIRECTORY . 'libs/php/functions/template.php');
require_once(F_DIRECTORY . 'libs/php/functions/verify.php');

class get
{

    private $template;
    private $verify;

    function __construct()
    {
        $this->template = new template();
        $this->verify = new verify();
    }

    function home()
    {
        if (!$this->verify->connected()) {

            $this->template->addHeaders('Home', 'home');
            /** Premier params pour le titre de l'onglet 2ème pour l'id de <section> */
            include(F_DIRECTORY . '/libs/php/pages/login.php');
            $this->template->addFooters();
        } else {
            header('location: http://' . $_SERVER['HTTP_HOST'] . '/dashboard');
        }
    }

    function logout()
    {
        session_destroy();
        header('location: http://' . $_SERVER['HTTP_HOST']);
    }

    function dash()
    {
        if ($this->verify->connected()) {
            $this->template->addHeaders('Dashboard', 'dash');
            $this->template->addMenu();
            include(F_DIRECTORY . '/libs/php/pages/dash.php');
            $this->template->addFooters();
        } else {
            $this->verify->redirect();
        }
    }

    function displayLogs()
    {
        if ($this->verify->connected()) {
            $this->template->addHeaders('Home', 'home');
            include(F_DIRECTORY . '/libs/php/pages/displaylogs.php');
            $this->template->addFooters();

        } else {
            $this->verify->redirect();
        }
    }

    function error404()
    {

        $this->template->addHeaders('Page Not Found !', '404');
        print_r('WelcomeTo404Function');
        $this->template->addFooters();

    }
}