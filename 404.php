<?php get_header(); ?>

<?php
    $profile_feature = SarthemIncludes\get_option_profile_feature();
    $profile_database = SarthemIncludes\get_option_profile_database();
    $profile_table = SarthemIncludes\get_option_profile_table();
    
    if (($profile_feature == "on") && ($profile_database != "no-selected") && ($profile_table != "no-selected")) {
        $url      = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_path = parse_url( $url, PHP_URL_PATH );
        $slug = pathinfo( $url_path, PATHINFO_BASENAME );

        $profile_rows = SarthemIncludes\get_row_by_column_row($profile_database, $profile_table, "slug", $slug);
        $profile_exist = True;
        if (empty($profile_rows)) {
            $profile_exist = False;
        } else {
            $profile = $profile_rows[0];
    
            $profile_name = $profile['name'];
            $profile_desc = $profile['description'];
			$profile_category_1 = $profile['category_1'];
			$profile_category_2 = $profile['category_2'];
			$profile_category_3 = $profile['category_3'];
			$profile_picture_url = $profile['profile_picture_url'];
			$profile_posts_url = $profile['post_pictures_url'];

			$profile_posts_url = explode("|", $profile_posts_url);
        }
    }
?>

<?php
    if (($profile_exist) && ($profile_feature == "on") && ($profile_database != "no-selected") && ($profile_table != "no-selected")) {
        ?>
            <div class="container">
				<div class="d-flex flex-column text-center">
					<div class="p-2">
						<img class="rounded-circle" alt="avatar1" width="150" height="150" src=<?php echo $profile_picture_url ?> />
					</div>
					<div class="p-2">
						<h1><?php echo $profile_name ?></h1>
						<p><?php echo $profile_desc ?></p>
					</div>
					<div class="p-2">
						<div class="row">
							<div class="col">
								<p><?php echo $profile_category_1 ?></p>
							</div>
							<div class="col">
								<p><?php echo $profile_category_2 ?></p>
							</div>
							<div class="col">
								<p><?php echo $profile_category_3 ?></p>
							</div>
						</div>
					</div>
					<br/>
					<div class="p-2">
						<div class="col">
							<?php
								$post_count = count($profile_posts_url);

								$posts_grid = array();
								array_push($posts_grid, array());
								for ($i = 0; $i < $post_count; ++$i) {
									$last_ind = array_key_last($posts_grid);
									if (count($posts_grid[$last_ind]) < 3) {
										array_push($posts_grid[$last_ind], $profile_posts_url[$i]);
									} else {
										array_push($posts_grid, array());

										$last_ind = array_key_last($posts_grid);
										array_push($posts_grid[$last_ind], $profile_posts_url[$i]);
									}
								}

								foreach ($posts_grid as $grid) {
									?>
										<div class="row">
											<?php 
												foreach ($grid as $post) {
													if (count($grid) < 3) {
														?> 
															<div class="col-md-4">
																<img class="rounded" alt="avatar1" src=<?php echo $post ?> />
															</div>
														<?php
													} else {
														?> 
															<div class="col">
																<img class="rounded" alt="avatar1" src=<?php echo $post ?> />
															</div>
														<?php
													}
												}	
											?>
										</div>
										<br />
									<?php
								}
							?>
                        </div>
					</div>
				</div>
			</div>
        <?php
    } else {
        ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="error-template">
                            <h1>
                                Oops!</h1>
                            <h2>
                                404 Not Found</h2>
                            <div class="error-details">
                                Sorry, an error has occured, Requested page not found!
                            </div>
                            <div class="error-actions">
                                <a href="/" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                                    Take Me Home </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
    }
?>

<?php get_footer(); ?>