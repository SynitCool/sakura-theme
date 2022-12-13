<?php

require_once("inc/season.php");
require_once("inc/options.php");

if (current_season() == "christmas") {
  ?>
        <footer class="text-center christmas-footer text-lg-start text-light">
          <div class="col">
            <div class="col">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="http://www.sman1cikarangutara.sch.id/wp-content/uploads/2022/03/LOGO-PANJANG-300x70.png" alt="logo" /></a>
            </div>
            <div class="col-md-5 mx-auto justify-content-center justify-content-lg-between p-4">
              <span>Get connected with us on social networks:</span>
              <br/>
              <?php sakura_theme_social_icons(); ?>
              <hr/>
            </div>
            <div class="row border-bottom p-4">
              <div class="col p-4">
                <h6 class="text-uppercase fw-bold mb-4 text-light">About Website</h6>
                <p>
                    This website is using sakura-theme. Sakura-theme is an awesome wordpress theme that develop
                    for SMAN 1 Cikarang Utara. Sakura-theme is an open source project.
                </p>
                <p>For more info about sakura-theme, head to:</p>
                <a class="text-light" href="https://github.com/SynitCool/sakura-theme">https://github.com/SynitCool/sakura-theme</a>
              </div>
              <div class="col p-4">
                <h6 class="text-uppercase fw-bold mb-4 text-light">Contact Us</h6>
                <p>
                  <i class="fa fa-home me-3"></i> Jl. Ki Hajar Dewantara No.23 Karangasih, Kec. Cikarang Utara Bekasi - Jawa Barat 17530</p>
                <p>
                  <i class="fa fa-envelope me-3"></i>
                  info@sman1cikarangutara.sch.id
                </p>
                <p><i class="fa fa-phone me-3"></i> 0812-9188-8474</p>
                <p><i class="fa fa-print me-3"></i> 0812-9188-8474</p>
              </div>
              <div class="container-audio">
              <p>We Wish You A Merry Christmas!</p>
              <!-- sound -->
              <?php
                if (get_sound_option() == "on") {
                  ?>
                    <audio controls loop autoplay>
                      <source src="https://firebasestorage.googleapis.com/v0/b/part-of-images.appspot.com/o/christmas-music%2Fwe-wish-you-a-merry-christmas-backsound.mp3?alt=media" type="audio/mpeg">
                      Your browser dose not Support the audio Tag
                    </audio>
                  <?php
                }
              ?>
              <!-- endsound -->
            </div>
            </div>
           
            <div class="col p-4 text-center">
              © 2022 Copyright
              <p class="fw-bold">SMAN 1 CIKARANG UTARA</p>
              <br/>
              Developed by
              <a class="text-reset fw-bold theme-color" href="https://www.instagram.com/synitiscool/">SynitIsCool</a>
            </div>
          </div>
        </footer>
        <?php
          wp_footer();
        ?>
      </body>
    </html>
  <?php
}

if (current_season() == "default") {
    ?>
          <!--  footer -->
          <!-- Footer -->
          <footer class="text-center text-lg-start text-light footer">
              <!-- Section: Social media -->
              <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
                <!-- Left -->
                <div class="me-5 d-none d-lg-block">
                  <span>Get connected with us on social networks:</span>
                </div>
                <!-- Left -->
                <!-- Right -->
                <?php sakura_theme_social_icons(); ?>
                <!-- Right -->
              </section>
              <!-- Section: Social media -->

              <!-- Section: Links  -->
              <section class="text-light">
                <div class="container text-center text-md-start mt-5">
                  <!-- Grid row -->
                  <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                      <!-- Content -->
                      <!-- <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3"></i>
                      </h6> -->
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="http://www.sman1cikarangutara.sch.id/wp-content/uploads/2022/03/LOGO-PANJANG-300x70.png" alt="logo" /></a>
                    <hr />
                    <p>
                        This website is using sakura-theme. Sakura-theme is an awesome wordpress theme that develop
                        for SMAN 1 Cikarang Utara. Sakura-theme is an open source project.
                    </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                      <!-- Links -->
                      <h6 class="text-uppercase fw-bold mb-4 text-light">
                        Learn More
                      </h6>
                      <p>
                        <a href="https://github.com/SynitCool/sakura-theme" class="text-reset text-light">Sakura-Theme</a>
                      </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                      <!-- Links -->
                      <h6 class="text-uppercase fw-bold mb-4 text-light">
                        Read More
                      </h6>
                      <p>
                        <a href="https://id.wikipedia.org/wiki/SMA_Negeri_1_Cikarang_Utara" target="_blank" class="text-reset text-light">SMAN 1 Cikarang Utara</a>
                      </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-5 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4">
                      <!-- Links -->
                      <h6 class="text-uppercase fw-bold mb-4 text-light">Contact Us</h6>
                      <p>
                        <i class="fa fa-home me-3"></i> Jl. Ki Hajar Dewantara No.23 Karangasih, Kec. Cikarang Utara Bekasi - Jawa Barat 17530</p>
                      <p>
                        <i class="fa fa-envelope me-3"></i>
                        info@sman1cikarangutara.sch.id
                      </p>
                      <p><i class="fa fa-phone me-3"></i> 0812-9188-8474</p>
                      <p><i class="fa fa-print me-3"></i> 0812-9188-8474</p>
                    </div>
                    <!-- Grid column -->
                  </div>
                  <!-- Grid row -->
                </div>
              </section>
              <!-- Section: Links  -->

              <!-- Copyright -->
              <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2022 Copyright
                <p class="fw-bold">SMAN 1 CIKARANG UTARA</p>
                <br/>
                Developed by
                <a class="text-reset fw-bold theme-color" href="https://www.instagram.com/synitiscool/">SynitIsCool</a>
              </div>
              <!-- Copyright -->
            </footer>
            <!-- Footer -->
            <?php
              wp_footer();
            ?>
         </body>
      </html>
    <?php
  }