<?php

class logs
{
    private $callingPage;
    private $directory = '/logs/';
    private $dateTime;
    private $writableDateTime;


    function __construct($callingPage)
    {
        $this->callingPage = $callingPage;
        $this->dateTime = date('d-m-Y H:i:s');
        $this->writableDateTime = date('Y_m_d');


    }

    function accessToLogs()
    {
        return file(F_DIRECTORY . $this->directory . $this->writableDateTime . '.log');
    }

    function addLonelyError($string)
    {
        if (is_string($string)) {
            $errorLine = '[ERROR] ' . $this->dateTime . ' [CallingPage:] ' . $this->callingPage . ' [ErrorMessage:] ' . $string . PHP_EOL;
        } else {
            $errorLine = '[ERROR] ' . $this->dateTime . ' [LogingError:] Please use an array function (eg: addFastidiousError) to store these logs' . PHP_EOL;
        }
        $this->addToFile($errorLine);
        return $string;
    }

    private function addToFile($errorline)
    {
        $file = F_DIRECTORY . $this->directory . $this->writableDateTime . '.log';
        if (file_exists($file)) {
            file_put_contents($file, $errorline, FILE_APPEND);
        } else {
            file_put_contents($file, $errorline);
        }
    }

    function addFastidiousError($array)
    {
        return 'No One';
    }

    function addAction($user, $action)
    {
        $errorLine = '[ACTION] ' . $this->dateTime . ' [CallingPage:] ' . $this->callingPage . ' [Action:] ' . $action . ' [User:]' . $user . PHP_EOL;
        $this->addToFile($errorLine);
    }

    function authLog($user)
    {
        $errorLine = '[AUTH] ' . $this->dateTime . ' [CallingPage:] ' . $this->callingPage . ' [Message:] Connected [User:]' . $user . PHP_EOL;
        $this->addToFile($errorLine);
    }

    function authUnlog($user)
    {

    }

    function authLogError($userUsed, $error)
    {
        $errorLine = '[AUTH] ' . $this->dateTime . ' [CallingPage:] ' . $this->callingPage . ' [ErrorMessage:] Authentication Error: ' . $error . ' [UserUsed:]' . $userUsed . ' []' . PHP_EOL;
        $this->addToFile($errorLine);
    }
}