<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 19/10/2015
 * Time: 08:29
 */
class DBLogin
{

    private static $nameUser;
    /**
     * @param $tempUsername
     * @param $tempPassword
     * @return bool
     */
    public static function tryLogin($tempUsername, $tempPassword)
    {
        $connected = false;
        try {
            //echo "trying to login( $tempUsername) with pwd: $tempPassword";

            $statement='SELECT username, fullName FROM users WHERE username = :namedb AND password = :passworddb;';
            $bindinParam=array(':namedb'=>$tempUsername, ':passworddb'=>$tempPassword);
            $sth=DBConnector::Connect($statement, $bindinParam);
            $result = $sth->fetch(PDO::FETCH_BOTH);
                if ($result!=null and $result!='') {
                    //echo 'connected';
                    self::$nameUser=$result["fullName"];
                    $connected = true;
                }

        } catch (Exception $e) {
            echo 'Exception catched: ' . $e->getMessage();
        }
        return $connected;
    }


    /**
     * @return string
     */

    //name to be displayed on the top right of the webpage
    public static function getFullName()
    {
        return self::$nameUser;
    }
}