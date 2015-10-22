<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 19/10/2015
 * Time: 13:12
 */
class Registrator
{
    private static $RegData = [];
    private static $message_response = "Something went wrong with the login.";

    /**
     * @return bool
     */
    public static function tryRegister()
    {
        $userCreated = false;
        if (isset($_POST['nameForm'], $_POST['usernameForm'], $_POST['passwordForm'], $_POST['passwordCheckForm'])){
            $name_form = $_POST['nameForm'];
            $username_form = $_POST['usernameForm'];
            $password_form = $_POST['passwordForm'];
            $password_form_check = $_POST['passwordCheckForm'];
            // login empty
            if($username_form==null or $username_form==""){
                self::$message_response = "The login cannot be empty! Go <a href='register'>back</a> and try again!";
            }
            // different passwords or no password at all
            elseif ($password_form == $password_form_check and $password_form != null and $password_form != '') {
                try {
                //if login exists $userCreated=false and self::$message_response = "Login already exists! Go back to the <a href='login'>login</a> page.";
                if (DBConnector::Connect("SELECT username FROM users WHERE username=:username",array(":username"=>$username_form))->fetch(PDO::FETCH_BOTH)!=null or
                    DBConnector::Connect("SELECT username FROM users WHERE username=:username",array(":username"=>$username_form))->fetch(PDO::FETCH_BOTH)!="")
                {
                    $userCreated=false;
                    self::$message_response = "Login already exists! Go back to the <a href='register'>login</a> page.";
                }
                //else login doesn't already exist
                    else{
                    $statement = 'INSERT INTO users (fullName, username, password) VALUES (:fullname, :username, :password)';
                    $bindinParam = array(':fullname' => $name_form, ':username' => $username_form, ':password' => $password_form);
                    DBConnector::Connect($statement, $bindinParam);
                    $userCreated = true;
                    self::$message_response = "Login created! Go to the <a href='login'>login</a> page.";}
                } catch (Exception $e) {
                    self::$message_response = "You encountered this obstacle:" . $e->getMessage() . ". Go <a href='register'>back</a> and try again!";
                }
            } else {
                self::$message_response = "There is something wrong with the passwords! Go <a href='register'>back</a> and try again!";
            }
        }
        $_SESSION["formResponse"] = self::$message_response;
        self::$RegData = ["formResponse" => $_SESSION["formResponse"],];
        return $userCreated;

    }
    /**
     *
     */
    public static function check()
    {
        if (!isset($_SESSION["registered"])) {
            $_SESSION["registered"] = false;
        }
        else  {
            $_SESSION["registered"] = self::tryRegister();
        }

    }

    public static function isRegistered()
    {
        return $_SESSION["registered"];
    }

    public static function getRegData()
    {
        $answer = [];
        if (isset($_SESSION["registered"])) {
            $answer = self::$RegData;
        }
        return $answer;
    }

}

