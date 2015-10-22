<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 19/10/2015
 * Time: 14:45
 */
class DBConnector
{

    private static $servername = "localhost";
    private static $username = "vincent";
    private static $password = "vincent";
    private static $dbname = "example2";
    private static $this_statement = "SELECT * FROM users WHERE TRUE;";
    private static $db;

    public static function Connect($statement, $bindParameters)
    {
        $sth = '';
        if ($statement != null or $statement != '') {
            self::$this_statement = $statement;
        } else {
            echo 'Something is wrong with the statement inserted.';
        }
        try {
            //echo "trying to login( $tempUsername) with pwd: $tempPassword";

            self::$db = new PDO('mysql:host=' . self::$servername . ';dbname=' . self::$dbname
                . ';charset=utf8', self::$username, self::$password);
            $sth = self::$db->prepare(self::$this_statement);
            if ($bindParameters != null or $bindParameters != "") {
                foreach ($bindParameters as $key => $value) {
                    $sth->bindParam($key, $value);
                }
            }
            $sth->execute();

        } catch (Exception $e) {
            echo 'Exception catched: ' . $e->getMessage();
        }
        return $sth;
    }
}