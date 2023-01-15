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

function get_row_table($database_name, $table_name, $format = "column", $limit = 5) {
    global $wpdb;

    if ($limit == -1) {
        $query = $wpdb->get_results("SELECT * FROM $database_name.$table_name");
    } else {
        $query = $wpdb->get_results("SELECT * FROM $database_name.$table_name LIMIT $limit");
    }

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

function get_sort_sequence_row_table($database_name, $table_name, $sort_sequences, $format = "column", $limit = 5) {
    global $wpdb;

    $query = "SELECT * FROM $database_name.$table_name";


    if (array_key_exists("search", $sort_sequences)) {
        $search = $sort_sequences["search"];

        $search_column = $search[0];
        $search_value = $search[1];

        $query .= " WHERE $search_column = '$search_value'";
    }

    if (array_key_exists("sort", $sort_sequences)) {
        $sort_value = $sort_sequences["sort"];
        $query .= " ORDER BY $sort_value";
    }

    $query .= " LIMIT $limit;";

    $query_results = $wpdb->get_results($query);

    if ($format == "column") {
        $columns = get_column_table($database_name,$table_name);
        $column_rows = array();
    
        foreach ($columns as $column) {
            $column_rows[$column] = array();
        }
    
        for ($i = 0; $i < count($query_results); ++$i) {
            $current_row = $query_results[$i];
    
            $row_array = get_object_vars($current_row);
    
            foreach($row_array as $key=>$value) {
                array_push($column_rows[$key], $value);
            }
        }
    
        return $column_rows;
    }

    if ($format == "row") {
        $column_row_array = array();
        for ($i = 0; $i < count($query_results); ++$i) {
            $current_row = $query_results[$i];
    
            $row_array = get_object_vars($current_row);

            array_push($column_row_array, $row_array);
        }

        return $column_row_array;
    }

    return $query_results;
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

function check_value_column_exist_table($database_name, $table_name, $column, $value) {
    $get_rows = get_row_table($database_name, $table_name, $limit=-1);
    $column_values = $get_rows[$column];

    if (in_array($value, $column_values)) {
        return true;
    }

    return false;
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

function update_row_table_by_search($database_name, $table_name, $sort_search, $new_row) {
    global $wpdb;

    $query = "UPDATE $database_name.$table_name";

    $query .= " SET";

    $last_column_row = array_key_last($new_row);
    foreach ($new_row as $column => $value) {
        if ($column == $last_column_row) {
            $query .= " $column = '$value'";
        } else {
            $query .= " $column = '$value',";
        }
    }

    $search_column = $sort_search[0];
    $search_value = $sort_search[1];

    $query .= " WHERE $search_column = '$search_value'";

    $query_results = $wpdb->get_results($query);
}
