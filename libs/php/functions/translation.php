<?php
require_once(F_DIRECTORY . 'libs/php/functions/RequestType/get.php');
require_once(F_DIRECTORY . 'libs/php/functions/RequestType/delete.php');
require_once(F_DIRECTORY . 'libs/php/functions/RequestType/patch.php');
require_once(F_DIRECTORY . 'libs/php/functions/RequestType/post.php');
require_once(F_DIRECTORY . 'libs/php/functions/RequestType/put.php');

require_once('verify.php');
require_once('logs.php');
require_once('errorcode.php');

class translation
{
    private $get;
    private $put;
    private $patch;
    private $delete;
    private $post;

    private $verify;
    private $logs;
    private $errorcode;


    private $PossibleMethod = array('GET', 'PATCH', 'PUT', 'POST', 'DELETE');

    function __construct()
    {
        $this->get = new get();
        $this->post = new post();
        $this->patch = new patch();
        $this->put = new put();
        $this->post = new delete();

        $this->verify = new verify();
        $this->errorcode = new errorcode();
        $this->logs = new logs('translation.php');

    }

    function translate($RequestMethod, $calledfunction)
    {
        if (in_array($RequestMethod, $this->PossibleMethod)) {
            switch ($RequestMethod) {
                case 'GET':
                    if (method_exists($this->get, $calledfunction)) {
                        $this->get->$calledfunction();
                    } else {
                        $this->logs->addLonelyError($this->errorcode->MissingFunction($calledfunction));
                    }
                    break;
                case 'PATCH':
                    if (method_exists($this->patch, $calledfunction)) {
                        $this->patch->$calledfunction();
                    } else {
                        $this->logs->addLonelyError($this->errorcode->MissingFunction($calledfunction));
                    }
                    break;
                case 'PUT':
                    if (method_exists($this->put, $calledfunction)) {
                        $this->put->$calledfunction();
                    } else {
                        $this->logs->addLonelyError($this->errorcode->MissingFunction($calledfunction));
                    }
                    break;
                case 'POST':
                    if (method_exists($this->post, $calledfunction)) {
                        $this->post->$calledfunction();
                    } else {
                        $this->logs->addLonelyError($this->errorcode->MissingFunction($calledfunction));
                    }
                    break;
                case 'DELETE':
                    if (method_exists($this->delete, $calledfunction)) {
                        $this->delete->$calledfunction();
                    } else {
                        $this->logs->addLonelyError($this->errorcode->MissingFunction($calledfunction));
                    }
                    break;
            }
        } else {
            $this->logs->addLonelyError($this->errorcode->MissingFunction($calledfunction));
        }

    }
}