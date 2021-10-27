<?php
/**
 * Template Name: Singup page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */
get_header()
?>
<main>
    <section class="action_account">
        <div class="bg imgDrop"><img src="<?php bloginfo('template_directory') ?>/common/images/bg.png" alt=""/></div>
        <div class="wraper">
            <div class="form_action"> <a class="logo_form" href="index.html"><img class="imgAutp" src="<?php bloginfo('template_directory') ?>/common/images/logo.svg" alt=""/></a><a class="btn_close" href="index.html"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_close.svg" alt=""/></a>
                <form action="">
                    <div class="sub2 mt-40 fz-18">Start Your Free Trial Now</div>
                    <div class="group mt-20">
                        <input class="input" type="text" placeholder="Fist name"/>
                    </div>
                    <div class="group mt-20">
                        <input class="input" type="text" placeholder="Last name"/>
                    </div>
                    <div class="group mt-20">
                        <input class="input" type="mail" placeholder="Email"/>
                    </div>
                    <div class="group mt-20">
                        <input class="input input_password" type="password" placeholder="Password"/><i class="toggle-password"></i>
                    </div>
                    <div class="group mt-20">
                        <input class="btn_acction mt-20" type="submit" value="Create Account"/>
                    </div>
                    <div class="group mt-20">
                        <p class="text">Already have an account? <a class="forget_pass" href="<?php site_url() ?>/login">Log in</a></p>
                        <p>By clicking “Create account” I accept the <br>Terms of Service, the Anti-Spam Policy, <br>and the Privacy Policy. Accessibitity info.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="footing pt-20 pb-20">
        <div class="wraper">
            <div class="row">
                <div class="col-6">
                    <address>© 2021 KenNguyen. All rights reserved.</address>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-4"> <a href="#">Privacy Policy</a></div>
                        <div class="col-4"> <a href="#">Privacy Policy</a></div>
                        <div class="col-4"> <a href="#">Privacy Policy</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer() ?>
