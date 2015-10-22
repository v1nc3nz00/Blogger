<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 21/10/2015
 * Time: 08:41
 */
class ContactInfo
{
    private static $infoData = [];
public static function getInfo(){
    if (isset($_SESSION["fullName"])){
        self::$infoData=["contactName"=>$_SESSION["fullName"]];
    }
    else {
        self::$infoData=["contactName"=>'Anonymous'];
    }
    return self::$infoData;
}
}