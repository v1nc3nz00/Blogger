<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 14/10/2015
 * Time: 12:04
 */
class Search
{
    public static function searchInFile($searchPath, $searchWord)
    {
        $emails = array();

        if (!is_array($searchWord)) {
            $searchWord = array($searchWord);
        }

        foreach ($searchWord as $word) {
            //$emails[] = "\n searching for the word: " . $word;
            $searchReader= new ResourceReader($searchPath);
            while ($line = $searchReader->readNextLine()) {
                $line = trim($line);
                $pattern = "/" . $word. "/i";
                if ((preg_match_all($pattern, $line, $matches)) != false) {
                   foreach($matches[0] as $match)
                   {
                       $emails[] = $match;
                       // controllo per evitare duplicati
                   }
                }
            }
        }
        $emails=array_unique($emails);

        return $emails;
    }
}