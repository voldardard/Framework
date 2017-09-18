<?php
require_once('errorcode.php');
require_once('verify.php');
require_once('logs.php');
require_once('translation.php');

class routing
{
    private $listPaths = array('GET' => array(), 'PUT' => array(), 'PATCH' => array(), 'POST' => array(), 'DELETE' => array());
    private $path;
    private $requestMethod;

    /*CLASS*/
    private $errorcode;
    private $verify;
    private $logs;
    private $translate;


    function __construct()
    {
        $queryString = explode('=', $_SERVER['QUERY_STRING']);
        if (empty($queryString[1])) {
            $this->path = '';
        } else {
            $this->path = $queryString[1];
        }
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        /*instantiate class*/
        $this->errorcode = new errorcode();
        $this->translate = new translation();
        $this->verify = new verify();
        $this->logs = new logs('routing.php');

    }

    function get($path, $function)
    {
        $this->listPaths['GET'][] = array('path' => $path, 'function' => $function);
    }

    function put($path, $function)
    {
        $this->listPaths['PUT'][] = array('path' => $path, 'function' => $function);
    }

    function post($path, $function)
    {
        $this->listPaths['POST'][] = array('path' => $path, 'function' => $function);
    }

    function delete($path, $function)
    {
        $this->listPaths['DELETE'][] = array('path' => $path, 'function' => $function);
    }

    function patch($path, $function)
    {
        $this->listPaths['PATCH'][] = array('path' => $path, 'function' => $function);
    }

    function getListPath()
    {
        return $this->listPaths;
    }

    function run()
    {
        $function = $this->getRightListPath();


        if ($this->verify->checkIfNoError($function)) {
            $this->translate->translate($this->requestMethod, $function);
        } else {
            print($function);
            $this->logs->addLonelyError($function);
        }
    }

    private function getRightListPath()
    {
        if (isset($this->requestMethod)) {
            $getListPath = $this->listPaths[$this->requestMethod];

            $valuePath = explode('/', $this->path);
            $count = count($valuePath);


            foreach ($getListPath as $keyLP => $valueLP) {
                $i = 0;
                $pathFalse = 0;
                while ($i < $count) {
                    $getLP = explode('/', $getListPath[$keyLP]['path']);
                    if (preg_match('/::$/', $getLP[count($getLP) - 1])) {
                        if ($i < count($getLP)) {
                            if (!preg_match('/^::/', $getLP[$i])) {

                                if ($getLP[$i] != $valuePath[$i]) {
                                    $pathFalse = 1;
                                }
                            }
                        }
                    } elseif ($count == count($getLP)) {
                        if (!preg_match('/^::/', $getLP[$i])) {
                            if ($getLP[$i] != $valuePath[$i]) {
                                $pathFalse = 1;
                            }
                        }
                    } else {
                        $pathFalse = 1;
                    }

                    $i++;
                }
                if ($pathFalse == false) {
                    return $getListPath[$keyLP]['function'];
                }//pathfalse
            }//foreach
            return $this->errorcode->nomatch($this->path . $this->requestMethod);
        } else {
            return $this->errorcode->missingargument();
        }
    }
}