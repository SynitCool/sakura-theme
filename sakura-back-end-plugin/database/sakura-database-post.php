<?php
require_once("includes/posts.php");
require_once("includes/database.php");

// Handle list post number
if (isset($_POST["add-new-table"])) {
    $table_name = $_POST["table-name"];

    $columns = list_post_number("column-new-table");
    $types = list_post_number("type-new-table");

    $merge_column_types = merge_by_key($columns, $types);

    create_sarthem_table($_COOKIE["selected_database"], $table_name, $merge_column_types);
}

if (isset($_POST["add-new-row"])) {
    $values = list_post_number("column", $fix_name=False);

    add_all_row($_COOKIE["selected_database"], $_COOKIE["selected_table"], $values);
}

// Handle button and text post
if (isset($_POST["add-database"]) && isset($_POST["database-name"])){
    create_sarthem_database($_POST["database-name"]);
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

if (isset($_POST["new-table-length"]) && isset($_POST["update-new-table-length"])) {
    setcookie("new_table_length", $_POST["new-table-length"], time() + (86400 * 30), "/");
    header("Refresh:0");
}