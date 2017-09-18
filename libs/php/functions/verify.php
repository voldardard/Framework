<?php
ini_set('display_errors', 'on');
require_once('errorcode.php');

class verify
{
    private $errorcode;
    private $key = A_ENCODE;
    private $data;


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////******* Clean *******//////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function jsontoarray($value)
    {
        $value = json_decode($value);
        $return = json_decode(json_encode($value), TRUE);
        return $return;
    }

    function cleandomain($domain)
    {
        $domain = trim($domain);
        if (!empty($domain)) {
            $domain = trim($domain);
            $domain = strtolower($domain);

            if (stripos($domain, '@') !== FALSE) {
                $domainexploded = explode("@", $domain);
                $domain = $domainexploded[1];
            }

            if (substr(strtolower($domain), 0, 8) == "https://") $domain = substr($domain, 8);
            if (substr(strtolower($domain), 0, 7) == "http://") $domain = substr($domain, 7);
            if (substr(strtolower($domain), 0, 6) == "ftp://") $domain = substr($domain, 6);
            if (substr(strtolower($domain), 0, 7) == "sftp://") $domain = substr($domain, 7);
            if (substr($domain, -1) == "/") $domain = substr($domain, 0, -1);
            if (substr($domain, -1) == ".") $domain = substr($domain, 0, -1);
            $domaintest = explode("/", $domain);
            if (!empty($domaintest[1])) $domain = $domaintest[0];
            if (!strstr($domain, ".")) {
                $domain = $domain . ".com";
            }
        }
        return $domain;
    }

    function chaine_aleatoire($lang)
    {
        $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $chaine .= "abcdefghijklmnopqrstuvwxxz";
        $chaine .= "123456789";

        $nb_lettres = strlen($chaine) - 1;
        $generation = '';
        for ($i = 0; $i < $lang; $i++) {
            $pos = mt_rand(0, $nb_lettres);
            $car = $chaine[$pos];
            $generation .= $car;
        }
        return $generation;
    }

    function validatetype($type, $value)
    {
        $check = false;
        switch ($type) {
            case 'bool':
                $check = is_bool($value);
                break;
            case 'double':
                $check = is_double($value);
                break;
            case 'int':
                $check = is_int($value);
                break;
            case 'string':
                $check = is_string($value);
                break;
            case 'stringnospecial':
                $check = is_string($value);
                if ($check == true) {
                    $check = $this->nospecial($value);
                }
                break;
            case 'domain':
                $check = $this->is_valid_domain_name($value);
                break;
            default:
                $check = false;
                break;

        }
        return $check;
    }

    function nospecial($string)
    {
        $pattern = "#^[a-z0-9]+$#i";
        if (preg_match($pattern, $string)) {
            return true;
        } else {
            return false;
        }
    }

    function is_valid_domain_name($domain_name)
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)); //length of each label
    }

    function checkIfNoError($string)
    {
        if (is_string($string)) {
            if (preg_match('/^###"""@@@/', $string)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    function code($string)
    {
        $this->data = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $kc = substr($this->key, ($i % strlen($this->key)) - 1, 1);
            $this->data .= chr(ord($string{$i}) + ord($kc));
        }
        $this->data = base64_encode($this->data);
        return $this->data;
    }

    function decode($string)
    {
        $this->data = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $kc = substr($this->key, ($i % strlen($this->key)) - 1, 1);
            $this->data .= chr(ord($string{$i}) - ord($kc));
        }
        return $this->data;
    }

    function redirect()
    {
        $url = $this->urlexplode();
        $newUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        foreach ($url as $value) {
            $newUrl .= $value . '/';
        }
        $newUrl = substr($newUrl, 0, -1);
        header('location: http://' . $_SERVER['HTTP_HOST'] . '/redirect/' . $newUrl);
    }

    function urlexplode()
    {
        $queryString = explode('=', $_SERVER['QUERY_STRING']);
        if (empty($queryString[1])) {
            $path = '';
        } else {
            $path = $queryString[1];
        }
        return explode('/', $path);
    }

    function connected()
    {
        if ((isset($_SESSION['token'])) AND (isset($_SESSION['tokenTime']))) {

            /** Check tokens on db or api */


            $returnlist = 'Connection Successful';
            $pos = strpos($returnlist, 'Connection Successful');

            if ($pos === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

}
