<?php

class errorcode
{


    function __construct()
    {

        $this->logs = new logs('errorCode');

    }

    function isNotConnected()
    {
        return '###"""@@@API /User Not Connected / ERR_CODE 407';
    }

    function IsNotNumeric()
    {
        return '###"""@@@API /Value Format Not Correct / ERR_CODE 406';
    }

    function DisplayError()
    {
        return '###"""@@@CLASS_ERROR /Impossible to get data, please try later or refresh/ ERR_CODE 405';
    }

    function lookingError()
    {
        return '###"""@@@CLASS_ERROR /The Ajax Lookup failed, PLEASE Contact your beautiful administrator and tell him he has to correct this thing/ ERR_CODE 404';
    }

    function nomatch($request)
    {
        return '###"""@@@CLASS_ERROR /NO MATCH FOUND FOR THE REQUEST: ' . $request . '/ ERR_CODE 401';
    }

    function missingargument()
    {

        return '###"""@@@CLASS_ERROR /MISSING ARGUMENT/ ERR_CODE 400';
    }

    function MissingFunction($function)
    {
        return '###"""@@@CLASS_ERROR /FUNCTION DOES NOT EXIST: ' . $function . '/ ERR_CODE 402';
    }

    function NoTranslation()
    {
        return '###"""@@@TRANSLATION /TRANSLATION DOES NOT EXIST FOR THIS PAGE/ ERR_CODE 403';


    }

}