<?php
require_once('includes/get-option.php');

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
                </div>
            </div>
        </div>
    <?php
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