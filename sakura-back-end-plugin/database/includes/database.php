<?php

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

function create_database($database_name) {
    global $wpdb;

    $wpdb->get_results("CREATE DATABASE $database_name");
}

function delete_database($database_name) {
    global $wpdb;

    $wpdb->get_results("DROP DATABASE $database_name");
}

