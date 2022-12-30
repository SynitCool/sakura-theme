<?php

function update_sort_sequences_cookie($value) {
    $value = json_encode($value);

    setcookie("sort_sequences", $value, time() + (86400 * 30), "/");
    header("Refresh:0");
}

function fix_offset_cookie_edit_mode() {
    $valid_values = array("on", "off");
    $cookie_value = $_COOKIE["edit_mode"];

    if (!in_array($cookie_value, $valid_values)) {
        setcookie("edit_mode", "off", time() + (86400 * 30), "/");
        header("Refresh:0");
    }
}

function fix_offset_cookie_new_table_length() {
    $valid_values = range(1, 10);
    $cookie_value = $_COOKIE["new_table_length"];
    
    $convert_to_int = intval($cookie_value);

    if (!in_array($convert_to_int, $valid_values)) {
        setcookie("new_table_length", "1", time() + (86400 * 30), "/");
        header("Refresh:0");
    }
}