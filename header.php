<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <?php
        wp_head( );
      ?>      
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <?php sakura_theme_loading(); ?>
      </div>
      <!-- end loader -->
      <?php 
         if (current_season() == "default") {
            ?>
               <!-- header -->
               <header>
                  <!-- header inner -->
                  <div class="header">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-12 col-sm-3 col logo_section">
                              <div class="full">
                                 <div class="center-desk">
                                    <div class="logo">
                                       <?php sakura_theme_get_header_logo(); ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-10 offset-md-1">
                              <nav class="navigation navbar navbar-expand-md navbar-dark ">
                                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                 </button>
                                 <div class="collapse navbar-collapse" id="navbarsExample04">
                                    <?php sakura_theme_header_menu(); ?>
                                 </div>
                              </nav>
                           </div>
                        </div>
                     </div>
                  </div>
               </header>
               <!-- end header inner -->
               <!-- end header -->
            <?php
         }

         if (current_season() == "christmas") {
            ?>       
               <!-- effects -->
               <?php
                  include dirname(__FILE__) . "/effects/snow.php";
               ?>
               <!-- end effects -->
               <!-- header -->
               <header>
                  <div class="row header-container">
                     <div class="col my-auto">
                        <div class="logo">
                           <?php sakura_theme_get_header_logo(); ?>
                        </div>
                     </div>
                     <div class="col-md-9">
                        <nav class="navigation navbar navbar-expand-md navbar-dark">
                           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                           </button>
                           <div class="collapse navbar-collapse" id="navbarsExample04">
                              <?php sakura_theme_header_menu(); ?>
                           </div>
                        </nav>
                     </div>
                  <div>
               </header>
               <!-- end header inner -->
               <!-- end header -->
            <?php
         }
      ?>