<?php

function current_state() {
    $database_cookie = $_COOKIE["selected_database"];
    $table_cookie = $_COOKIE["selected_table"];

    if ($database_cookie == "no-selected") {
        return "database";
    }

    if (($database_cookie != "no-selected") && ($table_cookie == "no-selected")) {
        return "table";
    }

    if (($database_cookie != "no-selected") && ($table_cookie = "no-selected")) {
        return "column-row";
    }

    return false;
}