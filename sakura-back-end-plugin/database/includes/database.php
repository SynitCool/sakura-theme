<?php

require_once("utils.php");

function get_databases() {
    global $wpdb;

    $query = $wpdb->get_results("SHOW DATABASES");
    
    $databases = array();
    foreach ($query as $db_class) {
        array_push($databases, $db_class->Database);
    }

    return $databases;
}

function get_tables($database_name) {
    global $wpdb;

    $query = $wpdb->get_results("SHOW tables FROM $database_name");
    
    $tables = array();
    foreach ($query as $table_class) {
        $table_array = get_object_vars($table_class);;

        array_push($tables, $table_array["Tables_in_$database_name"]);
    }

    return $tables;
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

function get_column_type_table($database_name, $table_name) {
    global $wpdb;

    $query = $wpdb->get_results("DESCRIBE $database_name.$table_name");

    $convert_type = array("bigint(20)" => "number", "date" => "date", "longtext" => "text");

    $column_types = array();
    for ($i = 0; $i < count($query); ++$i) {
        $current_field = $query[$i];

        $column = $current_field->Field;
        $type = $current_field->Type;

        $type = $convert_type[$type];

        $column_types[$column] = $type;
    }

    return $column_types;
}

function get_row_table($database_name, $table_name, $format = "column", $limit = 5) {
    global $wpdb;

    $query = $wpdb->get_results("SELECT * FROM $database_name.$table_name LIMIT $limit");

    if ($format == "column") {
        $columns = get_column_table($database_name,$table_name);
        $column_rows = array();
    
        foreach ($columns as $column) {
            $column_rows[$column] = array();
        }
    
        for ($i = 0; $i < count($query); ++$i) {
            $current_row = $query[$i];
    
            $row_array = get_object_vars($current_row);
    
            foreach($row_array as $key=>$value) {
                array_push($column_rows[$key], $value);
            }
        }
    
        return $column_rows;
    }

    if ($format == "row") {
        $column_row_array = array();
        for ($i = 0; $i < count($query); ++$i) {
            $current_row = $query[$i];
    
            $row_array = get_object_vars($current_row);

            array_push($column_row_array, $row_array);
        }

        return $column_row_array;
    }

}

function add_all_row($database_name, $table_name, $row_values) {
    global $wpdb;

    $query = "INSERT INTO $database_name.$table_name VALUES";
    $query .= " (";
    
    for ($i = 0; $i < count($row_values); ++$i) {
        if ($i == count($row_values) - 1) {
            $query .= "'$row_values[$i]'";
            continue;
        }
        
        $query .= "'$row_values[$i]'".", ";
    }

    $query .= ");";

    $result_query = $wpdb->get_results($query);
}

function create_database($database_name) {
    $database_name = fix_name_convention($database_name);

    global $wpdb;

    $wpdb->get_results("CREATE DATABASE $database_name");
}

function create_table($database_name, $table_name, $column_types) {
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

function delete_table($database_name, $table_name) {
    global $wpdb;

    $wpdb->get_results("DROP TABLE $database_name.$table_name");
}

function delete_database($database_name) {
    global $wpdb;

    $wpdb->get_results("DROP DATABASE $database_name");
}

