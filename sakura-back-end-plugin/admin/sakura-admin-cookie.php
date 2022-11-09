<?php

// check cookie is set

if (!isset($_COOKIE["selected_database"])) {
    setcookie("selected_database", "no-selected", time() + (86400 * 30), "/");
    header("Refresh:0");
}

if (!isset($_COOKIE["selected_table"])) {
    setcookie("selected_table", "no-selected", time() + (86400 * 30), "/");
    header("Refresh:0");
}