<?php
require_once('includes/get-option.php');
require_once("includes/database.php");



// create table
if (isset($_POST["create-table-profile"]) && isset($_POST["table-name"])) {
    $selected_database = get_option_profile_database();
    $column_types = array();
    $column_types["slug"] = "text";
    $column_types["name"] = "text";
    $column_types["description"] = "text";
    $column_types["profile_picture_url"] = "text";
    $column_types["category_1"] = "text";
    $column_types["category_2"] = "text";
    $column_types["category_3"] = "text";
    $column_types["post_pictures_url"] = "text";

    AdminIncludes\create_sarthem_table($selected_database, $_POST["table-name"], $column_types);
}