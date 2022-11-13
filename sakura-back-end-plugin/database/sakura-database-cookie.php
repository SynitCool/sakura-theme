<?php

require_once("includes/database.php");
require_once("includes/cookies.php");


// check cookie is set

if (!isset($_COOKIE["selected_database"])) {
    setcookie("selected_database", "no-selected", time() + (86400 * 30), "/");
    header("Refresh:0");
}

if (!isset($_COOKIE["selected_table"])) {
    setcookie("selected_table", "no-selected", time() + (86400 * 30), "/");
    header("Refresh:0");
}

if (!isset($_COOKIE["edit_mode"])) {
    setcookie("edit_mode", "off", time() + (86400 * 30), "/");
    header("Refresh:0");
}

if (!isset($_COOKIE["new_table_length"])) {
    setcookie("new_table_length", "1", time() + (86400 * 30), "/");
    header("Refresh:0");
}

// offset cookie
if (isset($_COOKIE["edit_mode"])) { 
    fix_offset_cookie_edit_mode();
}

if (isset($_COOKIE["new_table_length"])) {
    fix_offset_cookie_new_table_length();
}

if (($_COOKIE["selected_database"] == "no-selected") && ($_COOKIE["selected_table"] != "no-selected")) {
    setcookie("selected_database", "no-selected", time() + (86400 * 30), "/");
    setcookie("selected_table", "no-selected", time() + (86400 * 30), "/");
    header("Refresh:0");
}
    

// check cookie temp
if (isset($_COOKIE["temp_database"])) {
    delete_database($_COOKIE["temp_database"]);
    unset($_COOKIE['temp_database']); 
    setcookie('temp_database', null, -1, '/');
}

if (isset($_COOKIE["temp_table"])) {
    delete_table($_COOKIE["selected_database"], $_COOKIE["temp_table"]);
    unset($_COOKIE['temp_table']); 
    setcookie('temp_table', null, -1, '/');
}

if (isset($_COOKIE["temp_row"])) {
    delete_row($_COOKIE["selected_database"], $_COOKIE["selected_table"], $_COOKIE["temp_row"]);
    unset($_COOKIE["temp_row"]);
    setcookie("temp_row", null, -1, "/");
}


