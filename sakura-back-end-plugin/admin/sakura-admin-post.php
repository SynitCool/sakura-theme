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

// profile feature
if (isset($_POST["slug-profile"]) && isset($_POST["search"])) {
    setcookie("search-slug-profile", $_POST["slug-profile"], time() + (86400 * 30), "/");
    header("Refresh:0");
}

if (isset($_POST["save-table"])) {
    $profile_database = get_option_profile_database();
    $profile_table = get_option_profile_table();
    $no_value = array("no-selected", false);

    if (!in_array($profile_database, $no_value) || !in_array($profile_table, $no_value)) {
        $new_row = array();
        $new_row["slug"] = $_POST["slug"];
        $new_row["name"] = $_POST["name"];
        $new_row["description"] = $_POST["description"];
        $new_row["category_1"] = $_POST["category_1"];
        $new_row["category_2"] = $_POST["category_2"];
        $new_row["category_3"] = $_POST["category_3"];
    
        $sort_search = array("slug", $_POST["slug"]);
    
        AdminIncludes\update_row_table_by_search($profile_database, $profile_table, $sort_search, $new_row);
    }
}

if (isset($_POST["add-table"])) {
    $profile_database = get_option_profile_database();
    $profile_table = get_option_profile_table();
    $no_value = array("no-selected", false);

    if (!in_array($profile_database, $no_value) || !in_array($profile_table, $no_value)) {
        $slug = $_POST["slug"];

        $slug_exist = AdminIncludes\check_value_column_exist_table($profile_database, $profile_table, "slug", $slug);

        if (!$slug_exist) {
            $name = $_POST["name"];
            $description = $_POST["description"];
            $default_profile_picture = "no-profile-picture";
            $category_1 = $_POST["category_1"];
            $category_2 = $_POST["category_2"];
            $category_3 = $_POST["category_3"];
            $default_post_pictures = "no-post-pictures";

            $row_values = array(
                $slug,
                $name,
                $description,
                $default_profile_picture,
                $category_1,
                $category_2,
                $category_3,
                $default_post_pictures
            );

            AdminIncludes\add_all_row($profile_database, $profile_table, $row_values);
        } else {
            setcookie("error", "profile expected to be unique", time() + (60), "/");
        }
    }
}