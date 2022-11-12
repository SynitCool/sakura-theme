<?php
require_once("includes/posts.php");
require_once("includes/database.php");

// Handle list post number
if (isset($_POST["add-new-table"])) {
    $table_name = $_POST["table-name"];

    $columns = list_post_number("column-new-table");
    $types = list_post_number("type-new-table");

    $merge_column_types = merge_by_key($columns, $types);

    create_table($_COOKIE["selected_database"], $table_name, $merge_column_types);
}

// Handle button and text post
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

if (isset($_POST["new_table_length"]) && isset($_POST["update_new_table_length"])) {
    setcookie("new_table_length", $_POST["new_table_length"], time() + (86400 * 30), "/");
    header("Refresh:0");
}