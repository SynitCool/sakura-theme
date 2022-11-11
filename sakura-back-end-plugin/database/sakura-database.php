<?php
ob_start();

// includes
require_once("includes/database.php");
require_once("includes/state.php");

// database
require_once("sakura-database-cookie.php");
require_once("sakura-database-post.php");

function new_menu_page() {
    ?>
        <div class="main">
            <div class="flex-col">
                <?php admin_menu_bar() ?>
                <?php admin_content() ?>
            </div>
        </div>
    <?php
}

function admin_menu_bar() {
    $SELECTED_COOKIE_NAME = ["selected_database", "selected_table"];

    ?>
        <div class="admin-menu-bar">
            <div class="flex-row">
                <div class="flex-col">
                    <div class="box transparent-color">
                        <i class="fa fa-database icon-size"></i>
                    </div>
                </div>
                <?php
                    foreach ($SELECTED_COOKIE_NAME as $cookie_name) {
                        $current_cookie_value = $_COOKIE[$cookie_name];
                        if ($current_cookie_value != "no-selected") {
                            ?> 
                                <div class="box transparent-color"><?php echo $current_cookie_value ?></div>
                                <div class="box transparent-color">
                                    <i class="fa fa-arrow-right icon-size"></i>
                                </div>
                            <?php
                        }
                    }
                ?>
                <div class="flex-col item-right">
                    <div class="box transparent-color">
                        <span>
                            <label title="Refresh Button" onClick="refreshButton()">
                                <i class="fa fa-refresh icon-size"></i>
                            </label>
                        </span>
                    </div>
                </div>
            </div>
            <hr />
            <div class="flex-row">
                <div class="flex-col">
                    <div class="box transparent-color">
                        <span>
                            <label title="Back Button" onClick="backButton()">
                                <i class="fa fa-arrow-left icon-size icon-button"></i>
                            </label>
                        </span>
                    </div>
                </div>
                <div class="flex-row item-center">
                    <div class="box transparent-color">
                        <i class="fa fa-plus icon-size green-color icon-button"></i>
                    </div>     
                    <div class="box square transparent-color">
                        <i class="fa fa-times icon-size red-color icon-button"></i>
                    </div>
                </div>
                <div class="flex-col item-right">
                    <div class="box transparent-color">
                        <i class="fa fa-cog icon-size icon-button"></i>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

function admin_content() {
    ?>
        <div class="admin-content">
            <hr />
            <div class="flex-col">
                <?php admin_content_title() ?>
            </div>
            <div class="flex-col padding-small">
                <div class="flex-col">
                    <?php
                        if (current_state() != "column-row") {
                            ?>
                                <div class="box transparent-color">Name</div>
                            <?php
                        }
                    ?>
                    <?php
                        if (current_state() == "database") {
                            admin_content_database();
                        }
                        if (current_state() == "table") {
                            admin_content_table();
                        }
                        if (current_state() == "column-row") {
                            admin_content_column_row();
                        }
                    ?>
                </div>
            </div>
        </div>       
    <?php
}

function admin_content_title() {
    ?>
        <h1>
            <?php 
                if (current_state() == "database") {
                    echo "Database";
                }
                if (current_state() == "table") {
                    echo "Table";
                }
                if (current_state() == "column-row") {
                    echo $_COOKIE["selected_table"];
                }
            ?>
        </h1>
    <?php
}

function admin_content_column_row() {
    $columns = get_column_table($_COOKIE["selected_database"], $_COOKIE["selected_table"]);
    $rows = get_row_table($_COOKIE["selected_database"], $_COOKIE["selected_table"], $format = "row");

    ?>
        <table>
            <tr>
                <?php 
                    foreach ($columns as $column) {
                        ?>
                            <th><?php echo $column ?></th>
                        <?php
                    }
                ?>
            </tr>
            <?php
                for($i = 0; $i < count($rows); ++$i) {
                    $current_row = $rows[$i];

                    ?>
                        <tr>
                            <?php 
                                foreach ($current_row as $key => $value) {
                                    ?> 
                                        <td><?php echo $value ?></td>
                                    <?php
                                }
                            ?>
                        </tr>
                    <?php
                }
            ?>
        </table>
    <?php
}

function admin_content_table() {
    $tables = get_tables($_COOKIE["selected_database"]);

    ?>
        <div class="box transparent-color">
            <ul>
                <?php 
                    foreach ($tables as $table) {
                        ?>
                            <li>
                                <span>
                                    <label title="Your Table" onClick="setTableState('<?php echo $table ?>')"><?php echo $table ?></label>
                                </span>
                            </li>
                        <?php
                    } 
                ?>
            </ul>
        </div>
    <?php
}

function admin_content_database() {
    $databases = get_databases();

    ?>
        <div class="box transparent-color">
            <ul>
                <?php 
                    for ($i = 0; $i < count($databases); ++$i) {
                        ?> 
                            <li>
                                <span>
                                    <label title="Your Database" onClick="setDatabaseState('<?php echo $databases[$i] ?>')"><?php echo $databases[$i] ?></label>
                                </span>
                            </li>
                        <?php
                    } 
                ?>
            </ul>
        </div>
    <?php
}

