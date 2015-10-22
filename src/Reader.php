<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 14/10/2015
 * Time: 09:29
 */
class Reader
{
    protected $path;
    private $handle;

    /**
     * @return mixed
     */


    public function __construct($path)
    {
        if (!is_file($path)) {
            $path = filter_var($path, FILTER_VALIDATE_URL);
//            if( !is_link($path)) {
//                throw new Exception('Path not valid.' . $path);
//            }

        }
        $this->path = $path;
    }

    /**
     *
     */
    public function read()
    {
        return file_get_contents($this->path);

    }

    public function readJson()
    {
        return json_decode($this->read(), true);
    }


    public function readNextLine()
    {
        if (!$this->handle) {
            $this->handle = fopen($this->path, 'r');
        }
        if (!$line = fgets($this->handle)) {
            fclose($this->handle);
        }
        return $line;
    }

    public function readDB($tempUsername, $tempPassword){
        return DBLogin::tryLogin($tempUsername, $tempPassword);
    }
    public function readSessionName()
    {
        return DBLogin::getFullName();
    }
}