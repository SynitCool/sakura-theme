<?php

namespace SarthemIncludes;

function get_row_by_column_row($database_name, $table_name, $column, $row) {
    global $wpdb;

    $query = $wpdb->get_results("SELECT * FROM $database_name.$table_name WHERE $column='$row'");

    $column_row_array = array();
    for ($i = 0; $i < count($query); ++$i) {
        $current_row = $query[$i];

        $row_array = get_object_vars($current_row);
        
        array_push($column_row_array, $row_array);
    }

    return $column_row_array;
}
