<?php

if (isset($_POST["add-database"]) && isset($_POST["database-name"])){
    create_database($_POST["database-name"]);
}

if (isset($_POST["delete-database"]) && isset($_POST["database-name"])){
    delete_database($_POST["database-name"]);
}

if (isset($_POST["show-table"]) && isset($_POST["database-name"])) {
    setcookie("selected_database", $_POST["database-name"], time() + (86400 * 30), "/");
    setcookie("selected_table", "no-selected", time() + (86400 * 30), "/");
    header("Refresh:0");
}

if (isset($_POST["show-column-and-row"]) && isset($_POST["table-name"])) {
    setcookie("selected_table", $_POST["table-name"], time() + (86400 * 30), "/");
    header("Refresh:0");
}