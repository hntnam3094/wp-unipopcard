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
                    <div class="images"> <img class="imgAuto" src="<?php bloginfo('template_directory') ?>/common/images/avatar.png" alt=""/></div>
                    <div class="content">
                        <p>Lia Griffith is a designer, maker, artist, and author. Since launching her handcrafted lifestyle site with her first paper rose in 2013, Lia and her team have developed thousands of original DIY templates, SVG cut files, and tutorials to empower others who want to learn, make, and create. While paper flowers are where this journey began, Lia is most passionate about helping others find joy in crafting and reopen the door to their creative soul. She believes in changing lives one craft at a time. Join us.</p>
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
                                    <ul class="list_link">
                                        <li>OUR TEAM</li>
                                        <li>CONTACT US</li>
                                        <li>LEGAL</li>
                                        <li>FAQ</li>
                                        <li>PRESS FEATURES</li>
                                        <li>PARTNERS &amp; AFILIATES</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 toggle_parent">
                                <h4 class="ttl toggle_btn">RESOURCES</h4>
                                <div class="toggle_content">
                                    <ul class="list_link">
                                        <li>PAPER FLOWER</li>
                                        <li>GLOSSARY</li>
                                        <li>FELT FLOWER GLOSSARY</li>
                                        <li>VIDEO LIBRARY</li>
                                        <li>SHOP</li>
                                        <li>GIVE A GIFT</li>
                                        <li>BECOME A MEMBER</li>
                                        <li>MATERIAL SOURCES</li>
                                        <li>FREEBIES</li>
                                    </ul>
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
