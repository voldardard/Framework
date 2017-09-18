<?php
//ini_set('display_errors','on');
//error_reporting(E_ALL);

session_start();
require_once('configuration.php');//db access
require_once('libs/php/functions/routing.php'); //routing url


$routing = new routing();

/** Entrée du site */
$routing->get('', 'home');
$routing->get('redirect/::url::', 'home');


/** Manage error*/
$routing->get('404', 'error404');
$routing->get('displaylogs', 'displayLogs');
$routing->get('logout', 'logout');
$routing->get('dashboard', 'dash');


/** pages */


/** POST */
$routing->post('login', 'login');

/** Récupérer la liste de tous les chemins */

//print_r('<pre>');
//print_r($routing->getListPath());
//print_r('</pre>');

$routing->run();