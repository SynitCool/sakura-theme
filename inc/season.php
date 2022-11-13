<?php

function current_season() {
    $month = date('m');

    if ($month == 12) {
        return "christmas";
    }

    return "default";
}