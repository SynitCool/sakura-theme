<?php
ob_start();

// includes
require_once("includes/database.php");
require_once("includes/state.php");

// database
require_once("sakura-database-cookie.php");
require_once("sakura-database-post.php");

function new_menu_page() {
    // global $wpdb;

    // $query = $wpdb->get_results("DESCRIBE ".$_COOKIE["selected_database"].".".$_COOKIE["selected_table"]);

    ?>
        <p>
            <?php
                echo '<pre>'; print_r($_COOKIE); echo '</pre>';
                echo "\n";
            ?>
        </p>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
    <?php


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
                    <?php 
                        if (current_state() != "database") {
                            ?>
                                <div class="box transparent-color">
                                    <span>
                                        <label title="Back Button" onClick="backButton()">
                                            <i class="fa fa-arrow-left icon-size icon-button"></i>
                                        </label>
                                    </span>
                                </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="flex-row item-center">
                    <div class="box transparent-color">
                        <label id="addButton">
                            <i class="fa fa-plus icon-size green-color icon-button"></i>
                        </label>
                    </div>
                    <?php
                        if (current_state() == "database") {
                            admin_menu_bar_add_database();
                        }

                        if (current_state() == "table") {
                            admin_menu_bar_add_table();
                        }

                        if (current_state() == "column-row") {
                            admin_menu_bar_add_column_row();
                        }
                    ?>
                    <div class="box square transparent-color">
                        <label title="Open Edit Mode" onClick="activateEditMode('<?php echo $_COOKIE["edit_mode"] ?>')">
                            <i class="fa fa-pencil-square-o icon-size yellow-color icon-button"></i>
                        </label>
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

function admin_menu_bar_add_database() {
    ?>
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="flex-col">
                    <form method="post">
                        <h3>Adding New Database</h3>
                        <table>
                            <tr>
                                <td>
                                    <label>Database Name</label>
                                </td>
                                <td>
                                    <input type="text" name="database-name" required/>
                                </td>
                                <td>
                                    <input type="submit" name="add-database" value="Add Database"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    <?php
}

function admin_menu_bar_add_table() {
    ?>
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="flex-col">
                    <h3>Adding New Table</h3>
                    <hr/>
                    <form method="post">
                        <table>
                            <tr>
                                <label>Column Length</label>
                            </tr>
                            <tr>
                                <td>
                                    <input type="number" min="1" max="10" value="<?php echo $_COOKIE["new_table_length"];?>" name="new-table-length" required/>
                                </td>
                                <td>
                                    <input type="submit" value="Update" name="update-new-table-length" />
                                </td>
                            </tr>
                        </table>
                        <hr/>
                    </form>
                    <form method="post">
                        <table>
                            <tr>
                                <label>Table Name</label>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" maxlength=20 name="table-name" required/>
                                </td>
                            </tr>
                        </table>
                        <table class="add-table">
                            <tr>
                                <td>
                                    <p>Column</p>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <p>Type</p>
                                </td>
                            </tr>
                            <?php 
                                for ($i = 0; $i < intval($_COOKIE["new_table_length"]); ++$i) {
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="text" maxlength="20" name=<?php echo "column-new-table-" . $i ?> required/>
                                            </td>
                                            <td>
                                                <p>=></p>
                                            </td>
                                            <td>
                                                <select name=<?php echo "type-new-table-" . $i ?>>
                                                    <option value="number">Number</option>
                                                    <option value="text">Text</option>
                                                    <option value="date">Date</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </table>
                        <hr/>
                        <input type="submit" value="Add Table" name="add-new-table" />
                    </form>
                </div>
            </div>
        </div>
    <?php
}

function admin_menu_bar_add_column_row() {
    ?>
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="flex-col">
                    <form method="post">
                        <h3>Adding New Row</h3>
                        <hr/>
                        <table class="add-table">
                            <tr>
                                <td>
                                    <p>Column</p>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <p>Type</p>
                                </td>
                                <td>
                                    <p>Value</p>
                                </td>
                            </tr>
                            <?php
                                $column_types = get_column_type_table($_COOKIE["selected_database"], $_COOKIE["selected_table"]);
                                $index = 0;
                                foreach ($column_types as $column => $type) {
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="text" maxlength="20" readonly value="<?php echo $column ?>"/>
                                            </td>
                                            <td>
                                                <p>=></p>
                                            </td>
                                            <td>
                                                <select disabled>
                                                    <?php
                                                        $list_types = array("number", "text", "date");
                                                        foreach ($list_types as $l_type) {
                                                            if ($type == $l_type) {
                                                                ?>
                                                                    <option value="<?php echo $l_type ?>" selected><?php echo ucfirst($l_type) ?></option>
                                                                <?php
                                                                continue;
                                                            }

                                                            ?>
                                                                <option value="<?php echo $l_type?>"><?php echo ucfirst($l_type) ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="<?php echo $type ?>" name="column-<?php echo $index?>" required />
                                            </td>
                                        </tr>
                                    <?php
                                    $index += 1;
                                }
                            ?>
                        </table>
                        <hr/>
                        <input type="submit" value="Add Row" name="add-new-row" />
                    </form>
                </div>
            </div>
        </div>
    <?php
}

function admin_content_table() {
    $tables = get_tables($_COOKIE["selected_database"]);

    ?>
        <table class="explorer">
            <tr>
                <td class="type-bar">Name</td>
            </tr>
            <?php
                if ($_COOKIE["edit_mode"] == "off") {
                    foreach ($tables as $table) {
                        ?>
                            <tr>
                                <td>
                                    <i class="fa fa-table icon-size"></i><label title="Your Table" onClick="setTableState('<?php echo $table ?>')"><?php echo $table ?></label>
                                </td>
                            </tr>
                        <?php
                    } 
                }

                if ($_COOKIE["edit_mode"] == "on") {
                    foreach ($tables as $table) {
                        ?>
                            <tr>
                                <td>
                                    <i class="fa fa-table icon-size"></i><label title="Your Table" onClick="setTableState('<?php echo $table ?>')"><?php echo $table ?></label>
                                </td>
                                <td>
                                    <div class="box square transparent-color">
                                        <label title="Delete Your Table" onClick="deleteTableButton('<?php echo $table ?>')">
                                            <i class="fa fa-times icon-size red-color icon-button"></i>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php
                    } 
                }
            ?>
        </table>
    <?php
}

function admin_content_database() {
    $databases = get_databases();

    ?>
        <table class="explorer">
            <tr>
                <td class="type-bar">Name</td>
            </tr>
            <?php 
                if ($_COOKIE["edit_mode"] == "on") {
                    for ($i = 0; $i < count($databases); ++$i) {
                        ?> 
                            <tr>
                                <td>
                                    <i class="fa fa-database icon-size"></i><label title="Your Database" onClick="setDatabaseState('<?php echo $databases[$i] ?>')"><?php echo $databases[$i] ?></label>
                                </td>
                                <td>
                                    <div class="box square transparent-color">
                                        <label title="Delete Your Database" onClick="deleteDatabaseButton('<?php echo $databases[$i] ?>')">
                                            <i class="fa fa-times icon-size red-color icon-button"></i>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php
                    } 
                }

                if ($_COOKIE["edit_mode"] == "off") {
                    for ($i = 0; $i < count($databases); ++$i) {
                        ?> 
                            <tr>
                                <td>
                                    <i class="fa fa-database icon-size"></i><label title="Your Database" onClick="setDatabaseState('<?php echo $databases[$i] ?>')"><?php echo $databases[$i] ?></label>
                                </td>
                            </tr>
                        <?php
                    } 
                }
            ?>
        </table>
    <?php
}

function admin_content_column_row() {
    $columns = get_column_table($_COOKIE["selected_database"], $_COOKIE["selected_table"]);
    $rows = get_row_table($_COOKIE["selected_database"], $_COOKIE["selected_table"], $format = "row");

    ?>
        <div class="scroll-table">
            <table class="column-row">
                <tr class="table-row">
                    <?php 
                        if ($_COOKIE["edit_mode"] == "off") {
                            foreach ($columns as $column) {
                                ?>
                                    <th class="table-head"><?php echo $column ?></th>
                                <?php
                            }
                        }

                        if ($_COOKIE["edit_mode"] == "on") {
                            foreach ($columns as $column) {
                                ?>
                                    <th class="table-head"><?php echo $column ?></th>
                                <?php
                            }
                            ?>
                                <th class="table-head">Edit</th>
                            <?php
                        }
                    ?>
                </tr>
                <?php
                    if ($_COOKIE["edit_mode"] == "off") {
                        for($i = 0; $i < count($rows); ++$i) {
                            $current_row = $rows[$i];
    
                            ?>
                                <tr class="table-row">
                                    <?php 
                                        foreach ($current_row as $key => $value) {
                                            ?> 
                                                <td class="table-data"><?php echo $value ?></td>
                                            <?php
                                        }
                                    ?>
                                </tr>
                            <?php
                        }
                    }

                    if ($_COOKIE["edit_mode"] == "on") {
                        for($i = 0; $i < count($rows); ++$i) {
                            $current_row = $rows[$i];
                            $column_row = "";
    
                            ?>
                                <tr class="table-row">
                                    <?php 
                                        foreach ($current_row as $key => $value) {
                                            $column_row .= "$key=$value|";

                                            ?> 
                                                <td class="table-data"><?php echo $value ?></td>
                                            <?php
                                        }
                                        ?>
                                            <td class="table-data">
                                                <div class="box square transparent-color">
                                                    <label title="Delete Your Row" onClick="deleteRowButton('<?php echo $column_row?>')">
                                                        <i class="fa fa-times icon-size red-color icon-button"></i>
                                                    </label>
                                                </div>
                                            </td>
                                        <?php
                                    ?>
                                </tr>
                            <?php
                        }
                    }
                ?>
            </table>
        </div>
    <?php
}

