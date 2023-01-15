<?php
require_once('sakura-admin-post.php');
require_once('sakura-admin-cookie.php');

require_once('includes/get-option.php');
require_once('includes/update-option.php');
require_once('includes/database.php');
require_once('includes/media-library.php');


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

    echo '<pre>'; print_r(get_option("sakura_backend_option")); echo '</pre>';
    echo '<pre>'; print_r($_POST); echo '</pre>';
    echo '<pre>'; print_r($_COOKIE); echo '</pre>';

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
                            profile_create_table();
                        ?>
                    </form>
                    <?php
                        profile_edit_table();
                    ?>
                </div>
            </div>
        </div>
    <?php
}

function initialize() {
  if ((!get_option_theme_season()) && (get_option_season_support() == "manual")) {
    AdminIncludes\update_option_theme_season("default");
  }

  if ((!get_option_profile_database()) && (get_option_profile_feature() == "on")) {
    AdminIncludes\update_option_profile_database("no-selected");
    AdminIncludes\update_option_profile_table("no-selected");
  }

  if ((get_option_profile_feature() == "off")) {
    AdminIncludes\update_option_profile_database("no-selected");
    AdminIncludes\update_option_profile_table("no-selected");
  }

  


    // check table in database
    // $selected_database = get_option_profile_database();

    // if ($$selected_database == "no-selected") return;

    // $selected_table = get_option_profile_table();

    // $table_exist = AdminIncludes\check_table_exist_database($selected_database, $selected_table);

    // if (!$table_exist) AdminIncludes\update_option_profile_table("no-selected");
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

  if (isset( $options[ $args['label_for'] ] )) {
    if ($options[$args['label_for']] == "no-selected") {
      AdminIncludes\update_option_profile_table("no-selected");
    }
  }

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
  if (!$selected_database) return;

  $tables = AdminIncludes\get_tables($selected_database);

  $valid_tables = AdminIncludes\check_table_feature($selected_database, $tables, "profile");
    
  if (!empty($valid_tables)) return;

  ?>
      <p>You have no table that compatible for profile feature!</p>
      <p>Instead create your own table!</p>
      <table>
          <tr>
              <th>
                  <label class="checkbox-label">Table Name</label>
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

function profile_edit_table() {
  $selected_database = get_option_profile_database();

  if ($selected_database == "no-selected") return;
  if (!$selected_database) return;

  $selected_table = get_option_profile_table();

  if ($selected_table == "no-selected") return;
  if (!$selected_table) return; 

  ?>
      <div class="box transparent-color">
            <label class="checkbox-label" id="editTableButton">
                Edit Table
            </label>
      </div>
      <div id="editTableModal" class="modal">
          <div class="modal-content">
              <span class="close">&times;</span>
              <div class="flex-col">
                  <div class="flex-col">
                      <div class="flex-col">
                            <h3>Edit Profile Table</h3>
                      </div>
                      <form method="post">
                          <div class="flex-row">
                              <div class="flex-col">
                                  <p>Search profile by slug</p>
                                  <div class="flex-row">
                                      <input type="text" name="slug-profile" />
                                      <input type="submit" name="search" value="Search" />
                                  </div>
                              </div>
                              <div class="flex-row flex-content-right">
                                  <div class="box transparent-color">
                                    <label title="Add Profile" id="addProfile">
                                      <i class="fa fa-plus icon-size green-color icon-button"></i>
                                    </label>
                                  </div>
                                  <div class="box square transparent-color">
                                    <label title="Edit Profile" id="editProfile">
                                      <i class="fa fa-pencil-square-o icon-size yellow-color icon-button"></i>
                                    </label>
                                  </div>
                              </div>
                          </div>
                      </form>
                      <hr/>
                      <?php 
                      profile_by_slug(); 
                      profile_add_profile_table();
                      ?>
                      <hr/>
                      <div class="flex-col item-center flex-content-center">
                          <p>sakura theme 2022</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  <?php
}

function sakura_theme_media_library() {
  $media_images = AdminIncludes\get_images_from_media_library();
  ?>
    <form method="post">
      <div class="media-library" id="mediaLibrary">
          <div class="media-library-content flex-col">
              <div class="flex-row">
                  <div class="flex-col item-right">
                      <span class="media-library-close" onclick="closeMediaLibrary()">&times;</span>
                  </div>
              </div>
              <div class="flex-row">
                  <div class="flex-col">
                      <h4>Sakura Theme Media Library</h4>
                  </div>
                  <div class="flex-col">
                    <div id="selectedImageCount"></div>
                  </div>
              </div>
              <input type="submit" name="media-library-submit" />
              <div class="flex-col">
                  <ul class="checkbox-container">
                    <?php
                      for ($i = 0; $i < count($media_images); ++$i) {
                        $checkbox_id = "cb".$i;
                        $image = $media_images[$i];
                        ?>
                          <li class="checkbox-item">
                            <input type="checkbox" id="<?php echo $checkbox_id ?>" name="image-library[]" value="<?php echo $checkbox_id ?>"/>
                            <label class="checkbox-label" for="<?php echo $checkbox_id ?>">
                              <img class="padding-large border" src="<?php echo $image ?>"/>
                            </label>
                          </li>
                        <?php
                      }
                    ?>
                  </ul>
              </div>
          </div>
      </div>
    </form>
  <?php
}

function profile_by_slug() {
  $profile_database = get_option_profile_database();
  $profile_table = get_option_profile_table();
  $no_value = array("no-selected", false);

  if (in_array($profile_database, $no_value)) {
    return;
  }

  if (in_array($profile_table, $no_value)){
    return;
  }

  if (!isset($_COOKIE["search-slug-profile"])) {
    ?>
      <p>No Search</p>
    <?php
    return;
  }

  
  $profile_slug = $_COOKIE["search-slug-profile"];

  $sort_sequences = array();
  $sort_sequences["search"] = array("slug", $profile_slug);


  $get_profile_database = AdminIncludes\get_sort_sequence_row_table(
    $profile_database,
    $profile_table,
    $sort_sequences,
    $format = "row", 
    $limit = 1
  );
  
  if (count($get_profile_database) == 0) {
    ?>
      <p><?php echo "No Search for $profile_slug" ?></p>
    <?php
    return;
  }

  $profile = $get_profile_database[0];

  echo '<pre>'; print_r(AdminIncludes\get_sort_sequence_row_table(
    $profile_database,
    $profile_table,
    $sort_sequences,
    $format = "column", 
    $limit = 1
  )); echo '</pre>';

  ?>
    <?php sakura_theme_media_library() ?>
    <form method="post" id="editProfilePanel">
      <div class="flex-col">
          <div class="flex-row">
              <div class="flex-col">
                <h4>Profile</h4>
              </div>
              <div class="flex-col flex-content-right item-center">
                <input type="submit" name="save-table" value="Save" />
              </div>
          </div>
          <div class="flex-col">
              <div class="flex-row">
                <p>slug: </p>
                <input type="text" name="slug" value="<?php echo $profile["slug"] ?>" />
              </div>
              <div class="flex-row">
                  <p>profile_picture_url: </p>
                  <label class="checkbox-label edit-image" title="edit profile picture" onclick="openMediaLibrary('single', 'profile_picture')">
                      <img class="thumbnail-size padding-large border" src="<?php echo $profile["profile_picture_url"] ?>"/>
                  </label>  
              </div>
              <div class="flex-row">
                <p>name: </p>
                <input type="text" name="name" value="<?php echo $profile["name"] ?>"/>
              </div>
              <br/>
              <div class="flex-row">
                <p>description: </p>
                <input type="text" name="description" value="<?php echo $profile["description"] ?>"/>
              </div>
              <br/>
              <div class="flex-row">
                <p>category_1: </p>
                <input type="text" name="category_1" value="<?php echo $profile["category_1"] ?>"/>
              </div>
              <br/>
              <div class="flex-row">
                <p>category_2: </p>
                <input type="text" name="category_2" value="<?php echo $profile["category_2"] ?>"/>
              </div>
              <br/>
              <div class="flex-row">
                <p>category_3: </p>
                <input type="text" name="category_3" value="<?php echo $profile["category_3"] ?>"/>
              </div>
              <br/>
              <div class="flex-row">
                  <p>post_pictures_url: </p>
                  <div class="flex-row flex-gap flex-wrap-images">
                    <label class="checkbox-label edit-image" title="edit post pictures" onclick="openMediaLibrary('multiple', 'posts_picture')">
                        <img class="thumbnail-size padding-small border green-color" src="https://cdn-icons-png.flaticon.com/512/32/32339.png"/>
                    </label>
                    <?php
                      $profile_posts = $profile["post_pictures_url"];
                      $profile_posts = explode("|", $profile_posts);
                      foreach ($profile_posts as $post) {
                        ?>
                          <img class="thumbnail-size padding-large border" src="<?php echo $post ?>"/>
                        <?php
                      }
                    ?>
                  </div>
              </div>
          </div>
          <div class="flex-col"></div>
      </div>
    </form>
  <?php
}

function profile_add_profile_table() {
  ?>
    <form method="post" id="addProfilePanel">
      <div class="flex-col">
          <div class="flex-row">
              <div class="flex-col">
                <h4>Add Profile</h4>
                <p>you can only add pictures for exist profile</p>
              </div>
              <div class="flex-col flex-content-right item-center">
                <input type="submit" name="add-table" value="Add" />
              </div>
          </div>
          <div class="flex-col">
              <div class="flex-row">
                <p>slug: </p>
                <input type="text" name="slug" required/>
              </div>
              <br/>
              <div class="flex-row">
                <p>name: </p>
                <input type="text" name="name" value="<?php echo $profile["name"] ?>" required/>
              </div>
              <br/>
              <div class="flex-row">
                <p>description: </p>
                <input type="text" name="description" value="<?php echo $profile["description"] ?>" required/>
              </div>
              <br/>
              <div class="flex-row">
                <p>category_1: </p>
                <input type="text" name="category_1" value="<?php echo $profile["category_1"] ?>" required/>
              </div>
              <br/>
              <div class="flex-row">
                <p>category_2: </p>
                <input type="text" name="category_2" value="<?php echo $profile["category_2"] ?>" required/>
              </div>
              <br/>
              <div class="flex-row">
                <p>category_3: </p>
                <input type="text" name="category_3" value="<?php echo $profile["category_3"] ?>" required/>
              </div>
          </div>
          <div class="flex-col"></div>
      </div>
    </form>
  <?php
}