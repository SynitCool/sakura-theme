<?php

namespace AdminIncludes;

function get_databases($system = false) {
    global $wpdb;

    $query = $wpdb->get_results("SHOW DATABASES");
    
    $databases = array();
    foreach ($query as $db_class) {
        array_push($databases, $db_class->Database);
    }

    if ($system == false) {
        $databases = get_sarthem_databases($databases);
    }

    return $databases;
}

function get_sarthem_databases($database_names) {
    $sarthem_databases = array();
    for ($i = 0; $i < count($database_names); ++$i) {
        if (str_contains( $database_names[$i], "sarthem" )) {
            array_push($sarthem_databases, $database_names[$i]);
        }
    }

    return $sarthem_databases;
}

function get_tables($database_name, $system = false) {
    global $wpdb;

    $query = $wpdb->get_results("SHOW tables FROM $database_name");
    
    $tables = array();
    foreach ($query as $table_class) {
        $table_array = get_object_vars($table_class);;

        array_push($tables, $table_array["Tables_in_$database_name"]);
    }

    if ($system == false) {
        $tables = get_sarthem_tables($tables);
    }

    return $tables;
}

function get_sarthem_tables($table_names) {
    $sarthem_tables = array();
    for ($i = 0; $i < count($table_names); ++$i) {
        if (str_contains( $table_names[$i], "sarthem" )) {
            array_push($sarthem_tables, $table_names[$i]);
        }
    }

    return $sarthem_tables;
}

function get_column_table($database_name, $table_name) {
    global $wpdb;

    $query = $wpdb->get_results("SHOW COLUMNS FROM $database_name.$table_name");

    $columns = array();
    foreach ($query as $table_column) {
        array_push($columns, $table_column->Field);
    }

    return $columns;
}

function validate_table_columns_feature($database_name, $table_name, $feature) {
    $columns = get_column_table($database_name, $table_name);

    $feature_columns = array();
    $feature_columns["profile"] = array(
        "slug", 
        "name", 
        "description", 
        "profile_picture_url", 
        "category_1", 
        "category_2",
        "category_3",
        "post_pictures_url");

    
    if ($feature == "profile") {
        if ($columns == $feature_columns[$feature]) return true;

        return false;
    }
}

function check_table_feature($database_name, $table_names, $feature) {
    $valid_tables = array();
    foreach ($table_names as $name) {
        $validation = validate_table_columns_feature($database_name, $name, $feature);
        if ($validation) {
            array_push($valid_tables, $name);
        }
    }

    return $valid_tables;
}

function check_table_exist_database($database_name, $table_name) {
    $tables = get_tables($database_name, $system = true);

    if (in_array($table_name, $tables)) return true;

    return false;
}

function create_table($database_name, $table_name, $column_types) {
    $table_name = fix_name_convention($table_name);

    global $wpdb;

    $convert_types = array("number" => "BIGINT", "text" => "LONGTEXT", "date" => "DATE");

    $column_types_query = "(";
    foreach($column_types as $column => $type) {
        if (array_key_last($column_types) == $column) {
            $column_types_query .= "$column $convert_types[$type]";
            continue;
        }

        $column_types_query .= "$column $convert_types[$type],";
    }
    $column_types_query .= ");";

    $query = "CREATE TABLE $database_name.$table_name " . $column_types_query;

    $wpdb->get_results($query);
}

function create_sarthem_table($database_name, $table_name, $column_types) {
    $table_name = fix_name_convention($table_name);

    global $wpdb;

    $convert_types = array("number" => "BIGINT", "text" => "LONGTEXT", "date" => "DATE");

    $column_types_query = "(";
    foreach($column_types as $column => $type) {
        if (array_key_last($column_types) == $column) {
            $column_types_query .= "$column $convert_types[$type]";
            continue;
        }

        $column_types_query .= "$column $convert_types[$type],";
    }
    $column_types_query .= ");";

    $sarthem_table = "sarthem_";

    $table_name = $sarthem_table . $table_name;

    $query = "CREATE TABLE $database_name.$table_name " . $column_types_query;

    $wpdb->get_results($query);
}
