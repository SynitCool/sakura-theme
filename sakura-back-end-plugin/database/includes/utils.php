<?php

function fix_name_convention($name, $format="snake_case") {
    $name = trim($name);
    $name = preg_replace("/(?![_])\p{P}/u", "", $name);
    $name = str_replace(" ", "_", $name);
        
    return $name;
}