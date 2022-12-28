<?php

require_once("utils.php");

function list_post_number($ind, $fix_name = True) {
    $posts = array();

    foreach ($_POST as $key => $value) {
        if (str_contains( $key, $ind )) {
            $number = array_slice(str_split($key), -1, 1)[0];
            if ($fix_name == True) {
                $posts[$number] = fix_name_convention($value);
            }
            $posts[$number] = $value;
        }
    }

    return $posts;
}

function merge_by_key($columns, $types) {
    $merged = array();

    for ($i = 0; $i < count($columns); ++$i) {
        $current_column = $columns[$i];
        $current_types = $types[$i];
        
        
        $merged[$current_column] = $current_types;
    }

    return $merged;
}