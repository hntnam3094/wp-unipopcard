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
                <a class="btn btn_more" href="<?php site_url() ?>/logout" type="button">Log out</a>
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
                            <li> <a href="<?= $va_options['sn_facebook']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_01.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_instagram']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_02.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_pinterest']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_03.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_youtube']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_04.svg" alt=""/></a></li>
                            <li> <a href="<?= $va_options['sn_email']; ?>"> <img src="<?php bloginfo('template_directory') ?>/common/images/social_05.svg" alt=""/></a></li>
                        </ul>
                        <div class="text mt-20">
                            <p>Join our email list to learn about new projects, discounts, and membership perks!</p>
                        </div>
                        <?php if (check_membership() != 1) {
                            echo '<div class="form_submit pt-20">
                                        <form action="">
                                            <input class="input" type="text" placeholder="Your Email Adress"/>
                                            <input class="submit" type="submit" value="JOIN NOW"/>
                                        </form>
                                    </div>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="fb-root"></div>
<script async="" defer="" crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&amp;version=v12.0" nonce="EsXrjZVa"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!--<script src="--><?php //bloginfo('template_directory') ?><!--/common/js/jquery.min.js"></script>-->
<script src="<?php bloginfo('template_directory') ?>/common/js/select_custom.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/jquery.matchHeight-min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/owl.carousel.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/slick.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/popper.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/main.js"></script>
<script src="<?php bloginfo('template_directory') ?>/common/js/custom.js"></script>
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
<script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-617ddd1be044758e"></script>-->
<script>
    // window.addEventListener('load', function() {
    //     // Initialize the JS Payments SDK client.
    //     let jsPaymentClient = new  TwoPayClient('251761074825');
    //
    //     // Create the component that will hold the card fields.
    //     let component = jsPaymentClient.components.create('card');
    //
    //     // Mount the card fields component in the desired HTML tag. This is where the iframe will be located.
    //     component.mount('#card-element');
    //
    //     // Handle form submission.
    //     document.getElementById('payment-form').addEventListener('submit', (event) => {
    //         event.preventDefault();
    //
    //         // Extract the Name field value
    //         const billingDetails = {
    //             name: document.querySelector('#name').value
    //         };
    //
    //         // Call the generate method using the component as the first parameter
    //         // and the billing details as the second one
    //         jsPaymentClient.tokens.generate(component, billingDetails).then((response) => {
    //             console.log(response.token);
    //         }).catch((error) => {
    //             console.error(error);
    //         });
    //     });
    // });
    $(function () {
        TCO.loadPubKey();
        $("#payment-form").submit(function (e) {
            tokenRequest();
            return false;
        })

    })

    var tokenRequest = function () {
        var args = {
            sellerId: "251761074825",
            publishableKey: "7B37BE41-5897-499F-9A70-7429DC2F7FF2",
            ccNo: $('#creditCardNumber').val(),
            cvv: $('#cvv').val(),
            expMonth: $('#expiredMonth').val(),
            expYear: $('#expiredYear').val(),
        }
        TCO.requestToken(successCallback, errorCallback, args);
    }

    var successCallback = function (data) {
        var myForm = document.getElementById('payment-form')
        myForm.token.value = data.response.token.token
        myForm.submit()
    }

    var errorCallback = function (data) {
        if (data.errorCode == 200) {
            tokenRequest()
        } else {
            alert(data.errorMsg)
        }
    }

    $(function (){
        const urlParams = new URLSearchParams(window.location.search);
        let paramQ = urlParams.get('q')
        let paramCategory = urlParams.get('category')
        if (paramQ || paramCategory) {
            $('#input-search-data').val(paramQ)
            document.getElementById('input-search-data').scrollIntoView();
        }

        $('#btn-share-facebook').on('click', () => {
            if ($('#at-share-dock .at-svc-facebook').length > 0) {
                $('#at-share-dock .at-svc-facebook')[0].click()
            }
        })
        $('#btn-share-pinterest').on('click', () => {
            console.log('vàooo', $('#at4-share .at-svc-pinterest_share'))
            if ($('#at-share-dock .at-svc-pinterest_share').length > 0) {
                $('#at-share-dock .at-svc-pinterest_share')[0].click()
            }
        })

        $('#btn-search-data').on('click', () => {
            urlParams.set('q', $('#input-search-data').val());
            window.location.href='?' + urlParams.toString()
        })
    })
</script>
<?php wp_footer(); ?>

</body>
</html>
