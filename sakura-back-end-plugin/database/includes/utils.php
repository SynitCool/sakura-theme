<?php

function fix_name_convention($name, $format="snake_case") {
    $name = trim($name);
    $name = str_replace(" ", "_", $name);
        
    return $name;
}