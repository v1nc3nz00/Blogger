<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 16/10/2015
 * Time: 09:42
 */
class Authenticator
{
    private static $sitePrefix = '/Ex2/';
    private static $config_path = 'db/users.json';
    private static $userData = [];

    public static function check()
    {
        session_start();
        $req = str_replace(self::$sitePrefix, '', $_SERVER['REQUEST_URI']);
        if ($req == "logout") {
            session_destroy();
            header('Location: ' . self::$sitePrefix, true, 302);
            exit();
        }

        $reader = new Reader(self::$config_path);

        if (isset($_POST['inputUsername']) and $_POST['inputPassword']) {
            if ($reader->readDB($_POST['inputUsername'], $_POST['inputPassword'])) {
                $_SESSION["auth"] = true;
                $_SESSION["UserName"] = $_POST['inputUsername'];
                $_SESSION["fullName"] = $reader->readSessionName();
                //echo $reader->readSessionName();
            }
        }
        if (!isset($_SESSION["auth"])) {
            $_SESSION["auth"] = false;
        }

        if ($_SESSION["auth"] == true) {
            self::$userData = ["fullName" => $_SESSION["fullName"],];
        }

    }


    public static function isAuthenticated()
    {
        return $_SESSION["auth"];
    }

    public static function getUserData()
    {
        $answer = [];
        if (self::isAuthenticated()) {
            $answer = self::$userData;
        }
        return $answer;
    }


}