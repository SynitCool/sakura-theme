<?php

require_once("utils.php");

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

function create_sarthem_database($database_name) {
    $database_name = fix_name_convention($database_name);
    $sarthem_database = "sarthem_";

    global $wpdb;

    $database_name = $sarthem_database . $database_name;

    $wpdb->get_results("CREATE DATABASE $database_name");
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


function delete_table($database_name, $table_name) {
    global $wpdb;

    $wpdb->get_results("DROP TABLE $database_name.$table_name");
}

function delete_database($database_name) {
    global $wpdb;

    $wpdb->get_results("DROP DATABASE $database_name");
}

function delete_row($database_name, $table_name, $column_values) {
    global $wpdb;

    $query = "DELETE FROM $database_name.$table_name WHERE ";

    $column_values_explode = explode("|", $column_values);
    $column_row = array();
    for ($i = 0; $i < count($column_values_explode); ++$i) {
        $current_index = $column_values_explode[$i];

        if ($current_index == '') continue;
        
        $current_index_explode = explode("=", $current_index);

        $column = $current_index_explode[0];
        $row = $current_index_explode[1];

        $column_row[$column] = $row;
    }

    foreach($column_row as $key => $value) {
        if (array_key_last($column_row) == $key) {
            $query .= "$key='$value'";
            continue;
        }

        $query .= "$key='$value' AND ";

    }

    $query_results = $wpdb->get_results($query);
} 

