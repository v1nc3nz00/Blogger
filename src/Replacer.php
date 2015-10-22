<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 16/10/2015
 * Time: 12:52
 */
class Replacer
{
    /**
     * @param array $data
     * @param string $text
     */
    public static function replace($data, $text){
        //var_dump($data);
        preg_match_all('#(?<replacekey>\{\{(?<datakey>\w+)\}\})#i', $text, $matches);
        //var_dump($matches);

        $substitutions = [];
        foreach($matches['replacekey'] as $index => $replaceKey) {
            $dataKey = $matches['datakey'][$index];
            if(isset($data[$dataKey])) {
                $substitutions[$replaceKey] = $data[$dataKey];
            } else {
                $data[$dataKey]="";
            }
        }

        if(count($substitutions)) {
            //var_dump($substitutions);
            $text = str_replace(array_keys($substitutions), array_values($substitutions), $text);
        }

        return $text;

    }
}