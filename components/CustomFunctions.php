<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 2/26/15
 * Time: 12:26
 */
class CustomFunctions {

    public static function ImplodeInsert($table, $key_value_array) {

        $query_keys = '`' . implode('`, `', array_keys($key_value_array[0])) . '`';
        $array_values = array_values($key_value_array);
        if (is_array($array_values)) {
            $i = 0;
            $arrayValues = '';
            foreach ($array_values as $values) {
                if ($i > 0) {
                    $arrayValues .= ',';
                }
                $arrayValues .= '(';
                $arrayValues .= '"' . implode('", "', array_values($values)) . '"';
                $arrayValues .= ')';
                $i++;
            }
        } else {
            $query_values = '"' . implode('", "', $array_values) . '"';
            $arrayValues = '(' . $array_values . ')';
        }

        $query_string = ' INSERT Ignore INTO ' . $table . ' (' . $query_keys . ') VALUES ' . $arrayValues;

        return $query_string;
    }

    public static function generateUpdate($table, $key_value_array, $byAttr = array()) {

        if (!empty($key_value_array) && is_array($key_value_array)) {
            $set_fields = '';
            foreach ($key_value_array as $name => $value) {
                if (!empty($set_fields)) {
                    $set_fields .= ', ';
                }
                $set_fields .= ' `' . $name . '`="' . $value . '"';
            }

            $query_string = 'UPDATE `' . $table . '` SET ' . $set_fields;
            if (!empty($byAttr) && is_array($byAttr)) {

                $query_string .= ' WHERE ';

                $i = 0;
                foreach ($byAttr as $attrName => $attrValue) {
                    if ($i > 0) {
                        $query_string .= ' && ';
                    }
                    $query_string .= '`' . $attrName . '`="' . $attrValue . '"';
                    $i++;
                }
            }

            return $query_string;
        }

        return false;
    }    
}