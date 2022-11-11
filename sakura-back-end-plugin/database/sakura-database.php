<?php
ob_start();

// includes
require_once("includes/database.php");

// database
require_once("sakura-database-cookie.php");
require_once("sakura-database-post.php");


function menu_page_callback() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    // add error/update messages
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
    }
    // show error/update messages
    settings_errors( 'wporg_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'sakura_admin' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'sakura_admin' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

function new_menu_page() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    // add error/update messages
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'sakura_admin_messages', 'sakura_admin_message', __( 'Settings Saved', 'sakura_backend' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'sakura_admin_messages' );

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

function menu_page() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    // add error/update messages
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'sakura_admin_messages', 'sakura_admin_message', __( 'Settings Saved', 'sakura_backend' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'sakura_admin_messages' );

    global $wpdb;

    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'sakura_backend_option' );
    $results = $wpdb->get_results("SELECT * FROM wordpress.wp_users;");

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
        </hr>
        <div class="page-content">
            <div class="row">
                <div class="block">
                    <p><?php echo $_COOKIE["selected_database"] ?></p>
                </div>
                <div class="block">
                    <p>-----></p>
                </div>
                <div class="block">
                    <p><?php echo $_COOKIE["selected_table"] ?></p>
                </div>
            </div>
            <div class="tabbed">
                <?php nav_tab() ?>
                <?php database_tab_page() ?>
                <?php table_tab_page() ?>
                <?php column_and_row_page() ?>
                <?php editing_column_and_row_page() ?>
            </div>
        </div>
    <?php
}

function nav_tab() {
    ?>
        <input type="radio" id="tab1" name="css-tabs" checked>
        <input type="radio" id="tab2" name="css-tabs">
        <input type="radio" id="tab3" name="css-tabs">
        <input type="radio" id="tab4" name="css-tabs">
        
        <ul class="tabs">
            <li class="tab"><label for="tab1">Database</label></li>
            <li class="tab"><label for="tab2">Table</label></li>
            <li class="tab"><label for="tab3">Column and Row</label></li>
            <li class="tab"><label for="tab4">Editing Column and Row</label></li>
        </ul>
    <?php
}

function database_tab_page() {
    ?>
        <div class="tab-content">
            <h3>List Of Database</h3>
            <form method="post">
                <ul>
                    <?php 
                        $databases = get_databases();
                        for ($i = 0; $i < count($databases); ++$i) {
                            ?> 
                                <li>
                                    <span>
                                        <label title="Your Database"><?php echo $databases[$i] ?></label>
                                    </span>
                                </li>
                            <?php
                        }
                    ?>
                </ul>
                <hr/>
                <div>
                    <h3>Setting Database</h3>
                    <div>
                        <h4>Add & Remove Database Setting</h4>
                        <label>Database Name</label>
                        <br/>
                        <input type="text" name="database-name" />
                        <input type="submit" value="Add Database" name="add-database" class="button"/>
                        <input type="submit" value="Delete Database" name="delete-database" class="button"/>
                    </div>
                </div>
            </form>
        </div>
    <?php
}

function table_tab_page() {
    ?>
        <div class="tab-content">
            <h3><?php echo "List Of Table From " . $_COOKIE["selected_database"] ?></h3>
            <form method="post">
                <ul>
                    <?php
                        if ($_COOKIE["selected_database"] != "no-selected") {
                            $tables = get_tables($_COOKIE["selected_database"]);
                            foreach ($tables as $table) {
                                ?>
                                    <li><?php echo $table ?></li>
                                <?php
                            }
                        }
                    ?>           
                </ul>
                <hr />
                <div>
                    <h3>Setting Table</h3>
                    <div>
                        <h4>Show Table Setting</h4>
                        <label>Database Name</label>
                        <br/>
                        <input type="text" name="database-name" />
                        <input type="submit" class="button" role="button" value="Show Table" name="show-table" />
                    </div>
                    <br/>
                    <br/>
                    <div>
                        <h4>Add & Remove Table Setting</h4>
                        <label>Table Name</label>
                        <br/>
                        <input type="text" name="table-name" />
                        <input type="submit" class="button" role="button" value="Add Table" name="add-table" />
                        <input type="submit" class="button" role="button" value="Delete Table" name="delete-table" />
                    </div>
                </div>
            </form>
        </div>
    <?php
}

function column_and_row_page() {
    ?>
        <div class="tab-content">
            <h3><?php echo "Select " . $_COOKIE["selected_database"] . " From " . $_COOKIE["selected_table"]?></h3>
            <form method="post">
                <table>
                    <?php
                        if (($_COOKIE["selected_database"] != "no-selected") && ($_COOKIE["selected_table"] != "no-selected")) {
                            $row_array = get_row_table($_COOKIE["selected_database"], $_COOKIE["selected_table"]);
                            foreach ($row_array as $column=>$rows) {
                            ?>
                                <tr>
                                    <th><?php echo $column ?></th>
                                    <?php
                                        for ($i = 0; $i < count($rows); ++$i) {
                                            ?><td><?php echo $rows[$i] ?></td><?php
                                        }
                                    ?>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                </table>
                <hr />
                <div>
                    <h3>Setting Column And Row</h3>
                    <div>
                        <h4>Show Column And Row Setting</h4>
                        <label>Table Name</label>
                        <br/>
                        <input type="text" name="table-name" />
                        <br/>
                        <br/>
                        <input type="submit" class="button" role="button" value="Show Column And Row" name="show-column-and-row" />
                    </div>
                </div>
            </form>
        </div>
    <?php
}

function editing_column_and_row_page() {
    ?>
        <div class="tab-content">
            <h3><?php echo "Select " . $_COOKIE["selected_database"] . " From " . $_COOKIE["selected_table"]?></h3>
            <form method="post">
                <table>
                    <?php
                        if (($_COOKIE["selected_database"] != "no-selected") && ($_COOKIE["selected_table"] != "no-selected")) {
                            $row_array = get_row_table($_COOKIE["selected_database"], $_COOKIE["selected_table"]);
                            foreach ($row_array as $column=>$rows) {
                            ?>
                                <tr>
                                    <th><?php echo $column ?></th>
                                    <?php
                                        for ($i = 0; $i < count($rows); ++$i) {
                                            ?><td><?php echo $rows[$i] ?></td><?php
                                        }
                                    ?>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                </table>
                <hr />
                <div>
                    <h3>Setting Column And Row</h3>
                    <div>
                        <h4>Show Column And Row Setting</h4>
                        <label>Table Name</label>
                        <br/>
                        <input type="text" name="table-name" />
                        <br/>
                        <br/>
                        <input type="submit" class="button" role="button" value="Show Column And Row" name="show-column-and-row" />
                    </div>
                </div>
            </form>
        </div>
    <?php
}

function section_callback($args) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'sakura_backend' ); ?></p>
    <?php
}

function field_callback( $args ) {
    global $wpdb;
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'sakura_backend_option' );
    $results = $wpdb->get_results("SELECT * FROM wp_users");

    ?>
        <p>
            <?php
                echo '<pre>'; print_r(get_row_table("wp_usermeta")); echo '</pre>';
                // echo $results[0]->Database;
                echo "\n";
                foreach ($options as $key => $value) {
                    echo "$key: $value\n";
                }
            ?>
        </p>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
    <?php
    ?>
        <div class="page-content">
            <div class="tabbed">
                <input type="radio" id="tab1" name="css-tabs" checked>
                <input type="radio" id="tab2" name="css-tabs">
                <input type="radio" id="tab3" name="css-tabs">
                
                <ul class="tabs">
                    <li class="tab"><label for="tab1">Database</label></li>
                    <li class="tab"><label for="tab2">Database Setting</label></li>
                    <li class="tab"><label for="tab3">New age bullshit</label></li>
                </ul>
                
                <div class="tab-content">
                    <h4>List Of Database</h4>
                    <ul>
                        <?php 
                            $databases = get_databases();
                            for ($i = 0; $i < count($databases); ++$i) {
                                ?> 
                                    <li><label><?php echo $databases[$i] ?></label></li>
                                <?php
                            }
                        ?>
                    </ul>

                    <?php
                        if (isset($_POST['say-hello'])){
                            create_database("new_db");
                        }
                    ?>

                    <form method="post">
                        <input type="submit" value="Say Hello" name="say-hello" />
                    </form>
                </div>
                
                <div class="tab-content">
                    <h4>Zombie lipsum</h4>
                    <p>Zombie ipsum brains reversus ab cerebellum viral inferno, brein nam rick mend grimes malum cerveau cerebro. De carne cerebro lumbering animata cervello corpora quaeritis. Summus thalamus brains sit​​, morbo basal ganglia vel maleficia? De braaaiiiins apocalypsi gorger omero prefrontal cortex undead survivor fornix dictum mauris. </p>
                </div>
                
                <div class="tab-content">
                    <h4>New age bullshit</h4>
                    <p>Our conversations with other pilgrims have led to an awakening of pseudo-astral consciousness. Who are we? Where on the great myth will we be re-energized? We are at a crossroads of complexity and stagnation.</p>
                    <p>Eons from now, we dreamers will exist like never before as we are aligned by the cosmos. We are being called to explore the stratosphere itself as an interface between nature and complexity. We must learn how to lead infinite lives in the face of bondage.</p>
                    <p>Generated by the <a href="http://sebpearce.com/bullshit/">New Age Bullshit Generator</a></p>
                </div>
            </div>
            
            
        </div>
    <?php
    ?>
        <select
                id="<?php echo esc_attr( $args['label_for'] ); ?>"
                data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
                name="sakura_backend_option[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'red pill', 'sakura_backend' ); ?>
            </option>
            <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'blue pill', 'sakura_backend' ); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'sakura_backend' ); ?>
        </p>
        <p class="description">
            <?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'sakura_backend' ); ?>
        </p>
    <?php
}


function current_state() {
    $database_cookie = $_COOKIE["selected_database"];
    $table_cookie = $_COOKIE["selected_table"];

    if ($database_cookie == "no-selected") {
        return "database";
    }

    if (($database_cookie != "no-selected") && ($table_cookie == "no-selected")) {
        return "table";
    }

    if (($database_cookie != "no-selected") && ($table_cookie = "no-selected")) {
        return "column-row";
    }

    return false;
}