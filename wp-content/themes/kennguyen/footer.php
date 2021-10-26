<?php global $va_options?>
<!-- Modal-->
<div class="modal fade" id="modal_logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="pt-30">Do you want to log out of your account?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn_cancel" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn_more" type="button">Log out</button>
            </div>
        </div>
    </div>
</div>
<?php if( function_exists('slbd_display_widgets') ) { echo slbd_display_widgets(); } ?>
<footer class="footer pt-40 pb-30">
    <div class="wraper">
        <div class="row">
            <div class="col-12 col-lg-5">
                <div class="content_main flexBox">
                    <div class="images"> <img class="imgAuto" src="<?php echo $va_options['kn_avatar']['url']; ?>" alt=""/></div>
                    <div class="content">
                        <p><?php echo $va_options['kn_introduction']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="row">
                            <div class="col-12 col-md-6 toggle_parent">
                                <h4 class="ttl toggle_btn">ABOUT</h4>
                                <div class="toggle_content">
                                    <?php wp_nav_menu(
                                        array(
                                            'theme_location' => 'footer-about',
                                            'container' => 'false',
                                            'menu_id' => 'footer-about',
                                            'menu_class' => 'list_link'
                                        )
                                    ); ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 toggle_parent">
                                <h4 class="ttl toggle_btn">RESOURCES</h4>
                                <div class="toggle_content">
                                    <?php wp_nav_menu(
                                        array(
                                            'theme_location' => 'footer-resources',
                                            'container' => 'false',
                                            'menu_id' => 'footer-resources',
                                            'menu_class' => 'list_link'
                                        )
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <h4 class="ttl">STAY CONNECTED</h4>
                        <ul class="social flexBox midle mt-20">
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_01.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_02.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_03.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_04.svg" alt=""/></a></li>
                            <li> <a href="#"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_05.svg" alt=""/></a></li>
                        </ul>
                        <div class="text mt-20">
                            <p>Join our email list to learn about new projects, discounts, and membership perks!</p>
                        </div>
                        <div class="form_submit pt-20">
                            <form action="">
                                <input class="input" type="text" placeholder="Your Email Adress"/>
                                <input class="submit" type="submit" value="JOIN NOW"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="fb-root"></div>
<script async="" defer="" crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&amp;version=v12.0" nonce="EsXrjZVa"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/jquery.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/select_custom.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/jquery.matchHeight-min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/owl.carousel.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/slick.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/popper.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/main.js"></script>

<?php wp_footer(); ?>

</body>
</html>
