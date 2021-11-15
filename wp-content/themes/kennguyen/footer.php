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
<div class="modal fade" id="modal_thanks_guest_email" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
<!--                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>-->
                <div class="pt-30" id="result-register-guest-email">Thank you for your infomation. We will contact you shortly.</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn_cancel" type="button" data-bs-dismiss="modal">Close</button>
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
                        <?php get_template_part('template-parts/order/form-email'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

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
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-617ddd1be044758e"></script>

<script>
    $(document).ready(function(){
        var offset = 11; // khái báo số lượng bài viết đã hiển thị
        $('#btn-load-more').click(function(event) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            $.ajax({ // Hàm ajax
                type : "post", //Phương thức truyền post hoặc get
                dataType : "html", //Dạng dữ liệu trả về xml, json, script, or html
                url : '<?php echo admin_url('admin-ajax.php');?>', // Nơi xử lý dữ liệu
                data : {
                    action: "loadmore", //Tên action, dữ liệu gởi lên cho server
                    offset: offset, // gởi số lượng bài viết đã hiển thị cho server
                    category: urlParams.get('category'),
                    s: urlParams.get('q')
                },
                beforeSend: function(){
                    // Có thể thực hiện công việc load hình ảnh quay quay trước khi đổ dữ liệu ra
                    $('#btn-load-more').hide()
                    $('#div-loading-data').show()
                },
                success: function(response) {
                    $('#btn-load-more').show()
                    $('#div-loading-data').hide()
                    $('#listCollectionNew').append(response);
                    offset = offset + 8; // tăng bài viết đã hiển thị
                    if (response == '') {
                        $('#btn-load-more').hide()
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    //Làm gì đó khi có lỗi xảy ra
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                    $('#div-loading-data').hide()
                    $('#btn-load-more').hide()
                }
            });
        });
    });
</script>

<script>
    // (function(document, src, libName, config) {
    //     var script = document.createElement("script");
    //     script.src = src;
    //     script.async = true;
    //     var firstScriptElement = document.getElementsByTagName("script")[0];
    //     script.onload = function() {
    //         for (var namespace in config) {
    //             if (config.hasOwnProperty(namespace)) {
    //                 window[libName].setup.setConfig(namespace, config[namespace]);
    //             }
    //         }
    //         window[libName].register();
    //         window[libName].cart.setTest(true);
    //     };
    //
    //     firstScriptElement.parentNode.insertBefore(script, firstScriptElement);
    // })(
    //     document,
    //     "https://secure.2checkout.com/checkout/client/twoCoInlineCart.js",
    //     "TwoCoInlineCart",
    //     {
    //         app: { merchant: "251761074825" },
    //         cart: { host: "https://secure.2checkout.com/checkout/buy?merchant=251761074825&tpl=one-column&prod=3TRROJJM4U&qty=1" }
    //     }
    // );
    (function (document, src, libName, config) {
        var script             = document.createElement('script');
        script.src             = src;
        script.async           = true;
        var firstScriptElement = document.getElementsByTagName('script')[0];
        script.onload          = function () {
            for (var namespace in config) {
                if (config.hasOwnProperty(namespace)) {
                    window[libName].setup.setConfig(namespace, config[namespace]);
                }
            }
            window[libName].register();
        };

        firstScriptElement.parentNode.insertBefore(script, firstScriptElement);
    })(document,
        'https://secure.2checkout.com/checkout/client/twoCoInlineCart.js',
        'TwoCoInlineCart',{
        "app":
            {
                "merchant":"<?= $va_options['kn_2co_account'] ?>",
                "iframeLoad":"checkout"
            },
            "cart"
                :{"host":"https:secure.2checkout.com","customization":"inline"}});


    let idPackage = document.getElementById('id_package')
    if (idPackage) {
        idPackage = document.getElementById('id_package').value
    }
    let package = {}
    if (idPackage == 1) {
        package = {
            name: '<?= $va_options['kn_monthly_package_title'] ?>',
            ShortDescription: '1',
            quantity: 1,
            price: '<?= $va_options['kn_monthly_package_sale_price'] ?>',
            type: 'digital'
        }
    } else {
        package = {
            name: '<?= $va_options['kn_yearly_package_title'] ?>',
            ShortDescription: '2',
            quantity: 1,
            price: '<?= $va_options['kn_year_package_sale_price'] ?>',
            type: 'digital'
        }
    }
    $(document).delegate('#payment_email', 'change', function () {
        let url = window.location.href
        let Email = document.getElementById('payment_email').value

        $.ajax({
            url: url,
            method: 'post',
            data: {'email' : Email, 'isCheckExist': true},
            dataType: 'json',
            success: function (data) {
                if (data.code == 201) {
                    $('#message').text('Your email has been paid before, so you will not be able to continue to receive the offer')
                    if (idPackage == 1) {
                        package['price'] = '<?= $va_options['kn_monthly_package_price'] ?>'
                    } else {
                        package['price'] = '<?= $va_options['kn_year_package_price'] ?>'
                    }
                }
                if (data.code == 200) {
                    $('#message').text('')
                    if (idPackage == 1) {
                        package['price'] = '<?= $va_options['kn_monthly_package_sale_price'] ?>'
                    } else {
                        package['price'] = '<?= $va_options['kn_year_package_sale_price'] ?>'
                    }
                }

                $('#total_price_1').text(package['price'] + '$')
                $('#total_price_2').text('$ ' + package['price'])
            }
        })
    })

 if (window.document.getElementById('buy-button')) {
     window.document.getElementById('buy-button').addEventListener('click', function () {
         let firstName = document.getElementById('payment_first_name').value
         let lastName = document.getElementById('payment_last_name').value
         let Email = document.getElementById('payment_email').value

         if (firstName == '' || lastName == '' || Email == '') {
             alert('Please enter full contact information')
         } else {
             let checkKen = document.getElementById('check-payment').checked
             if (checkKen) {
                 let url = window.location.href
                 let data = {
                     'email' : Email,
                     'full_name': firstName +' '+ lastName,
                     'package': idPackage == 1 ? 'Monthly' : 'Yearly',
                     'price': idPackage == 1 ? '<?= $va_options['kn_monthly_package_price'] ?>' : '<?= $va_options['kn_year_package_price'] ?>',
                     'sale_price': package['price'],
                     'isCreateOrder': true
                 }
                 $.ajax({
                     url: url,
                     method: 'post',
                     data: data,
                     dataType: 'json',
                     success: function (data) {
                         if (data.code == 200) {
                             if (data.price) {
                                 package['price'] = data.price
                             }
                             TwoCoInlineCart.setup.setMode('DYNAMIC');
                             TwoCoInlineCart.cart.setCurrency('USD');

                             TwoCoInlineCart.cart.setReset(true);

                             TwoCoInlineCart.products.removeAll();
                             TwoCoInlineCart.products.add(package);
                             TwoCoInlineCart.billing.setEmail(Email);

                             // let success = false
                             // TwoCoInlineCart.events.subscribe('payment:finalized', function () {
                             //
                             // });
                             let urlRedirect = window.location.protocol + "//" + window.location.host + '/thank-you?id_package=' + idPackage + '&merchartno=' + data.idOrder
                             TwoCoInlineCart.cart.setReturnMethod({
                                 type: 'redirect',
                                 url : urlRedirect
                             });



                             TwoCoInlineCart.cart.setTest(<?= $va_options['kn_2co_demo'] ?>)
                             TwoCoInlineCart.cart.checkout()
                         }
                     }
                 })

             } else {
                 alert('Please, read and agreed to the Terms of Service, Privacy Policy & Cancellation Policy')
             }
         }

     })
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
            if ($('#at-share-dock .at-svc-pinterest_share').length > 0) {
                $('#at-share-dock .at-svc-pinterest_share')[0].click()
            }
        })

        $('#btn-search-data').on('click', () => {
            urlParams.set('q', $('#input-search-data').val());
            window.location.href='?' + urlParams.toString()
        })
    })
    function handle(e){
        if(e.keyCode === 13){
            e.preventDefault(); // Ensure it is only this code that runs
            if ($('#input-search-data').val()) {
                $('#btn-search-data').click()
            }
        }
    }
</script>
<script>
    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $("form input[name=submit-form-guest-email]").click(function(e) {
        e.preventDefault();

        let email = $("input[name=guest_email]").val()
        if($(this).length > 0 && $(this)[0].offsetParent.length > 0) {
            email = $(this)[0].offsetParent[0].value;
        }
        if (validateEmail(email)) {
            $('.submit-loading-email').show()
            $('.submit-form-email').hide()
            // This does the ajax request (The Call).
            $.ajax({
                method: 'POST',
                url: '<?php echo admin_url('admin-ajax.php');?>', // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                data: {
                    'action':'ajax_request_register_guest_email', // This is our PHP function below
                    'guest_email' : email // This is the variable we are sending via AJAX
                },
                success:function(data) {
                    $("#result-register-guest-email").html(data)
                    $("#modal_thanks_guest_email").modal("show");
                    $('.submit-loading-email').hide()
                    $('.submit-form-email').show()
                    $("input[name=guest_email]").val('')
                },
                error: function(errorThrown){
                    $('.submit-loading-email').hide()
                    $('.submit-form-email').show()
                    //window.alert(errorThrown);
                }
            });
        } else {
            if (email == '') {
                $("#result-register-guest-email").html(`Please enter email !`)
            } else {
                $("#result-register-guest-email").html(`Your email: ${email} <br/> Invalid email format e.g. admin@kennguyen.com ! <br/> Please enter the correct format !`)
            }
            $("#modal_thanks_guest_email").modal("show");
        }

    });

</script>
<?php wp_footer(); ?>

</body>
</html>
