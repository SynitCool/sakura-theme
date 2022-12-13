<?php
require_once("options.php");


function current_season() {
    $theme_option = get_theme_option();
    if ($theme_option != "auto") {
        return $theme_option;
    }

    $month = date('m');

    if ($month == 12) {
        return "christmas";
    }

    return "default";
}