<?php
require_once('sakura-admin-post.php');

require_once('includes/get-option.php');
require_once('includes/update-option.php');
require_once('includes/database.php');


function sakura_admin_page() {
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

    // initialize
    initialize();

    // show error/update messages
    settings_errors( 'sakura_admin_messages' );

    ?>
        <div class="main">
            <div class="flex-col">
                <div class="flex-col">
                    <h1>Theme Season Support</h1>
                    <form action="options.php" method="post">
                        <?php
                            // output setting sections and their fields
                            // (sections are registered for "wporg", each field is registered to a specific section)
                            do_settings_sections( 'sakura_admin' );
                            // output security fields for the registered setting "wporg"
                            settings_fields( 'sakura_admin' );
                            // output save settings button
                            submit_button( 'Save Settings' );
                        ?>
                    </form>
                    <form method="post">
                        <?php
                            profile_create_table()
                        ?>
                    </form>
                </div>
            </div>
        </div>
    <?php
}

function initialize() {
    // check table in database
    $selected_database = get_option_profile_database();

    if ($selected_database == "no-selected") return;

    $selected_table = get_option_profile_table();

    $table_exist = AdminIncludes\check_table_exist_database($selected_database, $selected_table);

    if (!$table_exist) AdminIncludes\update_option_profile_table("no-selected");
}

function theme_section() {
    ?>
        <p>Setting for your theme looks!</p>
    <?php
}

function season_support_field($args) {
    $options = get_option( 'sakura_backend_option' );

    ?>
        <select 
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
            name="sakura_backend_option[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="auto" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'auto', false ) ) : ( '' ); ?>>
                auto
            </option>
            <option value="manual" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'manual', false ) ) : ( '' ); ?>>
                manual
            </option>
        </select>
    <?php
}

function theme_season_field($args) {
    $options = get_option( 'sakura_backend_option' );

    ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
            name="sakura_backend_option[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="default" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'default', false ) ) : ( '' ); ?>>
                default
            </option>
            <option value="christmas" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'christmas', false ) ) : ( '' ); ?>>
                christmas
            </option>
        </select>
    <?php
}

function sound_field($args) {
    $options = get_option( 'sakura_backend_option' );

    ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
            name="sakura_backend_option[<?php echo esc_attr( $args['label_for'] ); ?>]">>
            <option value="on" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'on', false ) ) : ( '' ); ?>>
                on
            </option>
            <option value="off" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'off', false ) ) : ( '' ); ?>>
                off
            </option>
        </select>
    <?php
}

function profile_section() {
    ?>
        <p>Add your wordpress website profiles!</p>
    <?php
}

function profile_feature_field($args) {
    $options = get_option( 'sakura_backend_option' );

    ?>
        <select 
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
            name="sakura_backend_option[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="on" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'on', false ) ) : ( '' ); ?>>
                on
            </option>
            <option value="off" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'off', false ) ) : ( '' ); ?>>
                off
            </option>
        </select>
    <?php
}

function profile_database_field($args) {
    $options = get_option( 'sakura_backend_option' );
    $databases = AdminIncludes\get_databases();

    ?>
        <select 
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
            name="sakura_backend_option[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="no-selected" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'no-selected', false ) ) : ( '' ); ?>>
                no-selected
            </option>
            <?php
                foreach ($databases as $database) {
                    ?>
                        <option value=<?php echo $database ?> <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], $database, false ) ) : ( '' ); ?>>
                            <?php echo $database ?>
                        </option>
                    <?php
                }
            ?>
        </select>
    <?php
}

function profile_table_field($args) {
    $options = get_option( 'sakura_backend_option' );
    $valid_tables = $args['valid_tables']

    ?>
        <select 
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
            name="sakura_backend_option[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="no-selected" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'no-selected', false ) ) : ( '' ); ?>>
                no-selected
            </option>
            <?php
                foreach ($valid_tables as $table) {
                    ?>
                        <option value=<?php echo $table ?> <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], $table, false ) ) : ( '' ); ?>>
                            <?php echo $table ?>
                        </option>
                    <?php
                }
            ?>
        </select>
        <p>Table supposed to have columns:</br>
            - slug: text;</br>
            - name: text;</br>
            - description: text;</br>
            - profile_picture_url: text;</br>
            - category_1: text;</br>
            - category_2: text;</br>
            - category_3: text;</br>
            - post_pictures_url: text;
        </p>
    <?php
}

function profile_create_table() {
    $selected_database = get_option_profile_database();

    if ($selected_database == "no-selected") return;

    $tables = AdminIncludes\get_tables($selected_database);

    $valid_tables = AdminIncludes\check_table_feature($selected_database, $tables, "profile");
    
    if (!empty($valid_tables)) return;

    ?>
        <p>You have no table that compatible for profile feature!</p>
        <p>Instead create your own table!</p>
        <table>
            <tr>
                <th>
                    <label>Table Name</label>
                </th>
            </tr>
            <tr>
                <td>
                    <input maxlength=20 name="table-name" type="text" required/>
                </td>
            </tr>
            <tr>
                <td>
                    <input name="create-table-profile" class="box green-color rounded white-color-item no-border fit-button-size" type="submit" title="Create Table" value="Create Table"/>
                </td>
            </tr>
        </table>
    <?php
}

