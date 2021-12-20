<?php
if ( ! class_exists( 'VA_Theme_Options' ) ) {
    /* class VA_Theme_Options sẽ chứa toàn bộ code tạo options trong theme từ Redux Framework */
    class VA_Theme_Options {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        /* Load Redux Framework */
        public function __construct() {
            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }


            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }


        }

        /**
        Thiết lập các method muốn sử dụng
        Method nào được khai báo trong này thì cũng phải được sử dụng
         **/
        public function initSettings() {
            // Set the default arguments
            $this->setArguments();


            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();


            // Create the sections and fields
            $this->setSectionsSettingGeneral();

            $this->setSectionsSettingHome();

            $this->setSections();

            //$this->setSectionsSettingLeftMenu();

            //$this->setPayment();

            $this->setEmailSetting();

            $this->setFacebookAppLogin();

            $this->setGoogleLogin();

            $this->set2checkout();

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }


            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }

        /**
        Thiết lập cho method setAgruments
        Method này sẽ chứa các thiết lập cơ bản cho trang Options Framework như tên menu chẳng hạn
         **/
        public function setArguments()
        {
            $theme = wp_get_theme(); // Lưu các đối tượng trả về bởi hàm wp_get_theme() vào biến $theme để làm một số việc tùy thích.
            $this->args = array(
                // Các thiết lập cho trang Options
                'opt_name' => 'va_options', // Tên biến trả dữ liệu của từng options, ví dụ: tp_options['field_1']
                'display_name' => $theme->get('Name'), // Thiết lập tên theme hiển thị trong Theme Options
                'menu_type' => 'menu',
                'allow_sub_menu' => true,
                'menu_title' => __('General setting', 'vietanh'),
                'page_title' => __('General setting', 'vietanh'),
                'dev_mode' => false,
                'customizer' => true,
                'menu_icon' => '', // Đường dẫn icon của menu option
                // Chức năng Hint tạo dấu chấm hỏi ở mỗi option để hướng dẫn người dùng */
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                ) // end Hints
            );
        }

        /**
        Thiết lập khu vực Help để hướng dẫn người dùng
         **/
        public function setHelpTabs() {
            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'vietanh' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'vietanh' )
                );


                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'vietanh' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'vietanh' )
                );


                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'vietanh' );
            }

        /**
        Thiết lập từng phần trong khu vực Theme Options
        mỗi section được xem như là một phân vùng các tùy chọn
        Trong mỗi section có thể sẽ chứa nhiều field
         **/
        public function setSections() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting footer', 'vietanh' ),
                'desc'   => __( 'All of settings for header on this theme.', 'vietanh' ),
                    'icon'   => 'el-icon-cog',
                    'fields' => array(
                        array(
                            'id' => 'kn_avatar',
                            'type' => 'media',
                            'title' => __('Avatar', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'kn_introduction',
                            'type' => 'textarea',
                            'title' => __('Introduction', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'section2-start',
                            'type' => 'section',
                            'title' => __('Social network', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'sn_facebook',
                            'type' => 'text',
                            'title' => __('Link facebook', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'sn_instagram',
                            'type' => 'text',
                            'title' => __('Link instagram', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'sn_pinterest',
                            'type' => 'text',
                            'title' => __('Link pinterest', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'sn_youtube',
                            'type' => 'text',
                            'title' => __('Link youtube', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'sn_email',
                            'type' => 'text',
                            'title' => __('Link email', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'section3-start',
                            'type' => 'section',
                            'title' => __('Link on sign up and login - option 1', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'op1_title',
                            'type' => 'text',
                            'title' => __('Title', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'op1_link',
                            'type' => 'text',
                            'title' => __('Link', 'vietanh'),
                            'compiler' => true,
                            'default'=>'#'
                        ),
                        array(
                            'id' => 'section4-start',
                            'type' => 'section',
                            'title' => __('Link on sign up and login - option 2', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'op2_title',
                            'type' => 'text',
                            'title' => __('Title', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'op2_link',
                            'type' => 'text',
                            'title' => __('Link', 'vietanh'),
                            'compiler' => true,
                            'default'=>'#'
                        ),
                        array(
                            'id' => 'section5-start',
                            'type' => 'section',
                            'title' => __('Link on sign up and login - option 3', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'op3_title',
                            'type' => 'text',
                            'title' => __('Title', 'vietanh'),
                            'compiler' => true
                        ),
                        array(
                            'id' => 'op3_link',
                            'type' => 'text',
                            'title' => __('Link', 'vietanh'),
                            'compiler' => true,
                            'default'=>'#'
                        ),
                    )
                ); // end section


        }

        public function setSectionsSettingGeneral() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting general', 'vietanh' ),
                'desc'   => __( 'All of settings for ken nguyen theme.', 'vietanh' ),
                'icon'   => 'el-icon-cog',
                'fields' => array(
                    array(
                        'id' => 'kn_logo',
                        'type' => 'media',
                        'title' => __('Logo', 'vietanh'),
                        'compiler' => true,
                        'desc' => __('Cho phép dùng đuôi: jpg,png,gif', 'vietanh')
                    ),
                    array(
                        'id' => 'kn_favicon',
                        'type' => 'media',
                        'title' => __('Favicon', 'vietanh'),
                        'compiler' => true,
                        'desc' => __('Cho phép dùng đuôi: jpg,png,gif', 'vietanh')
                    ),
                    array(
                        'id' => 'kn_page_title',
                        'type' => 'text',
                        'title' => __('Page title', 'vietanh'),
                        'compiler' => true,
                        'default' => 'Ken Nguyen'
                    )
//                    array(
//                        'id' => 'kn_logo_2checkout',
//                        'type' => 'media',
//                        'title' => __('Logo for 2checkout', 'vietanh'),
//                        'compiler' => true,
//                        'desc' => __('Cho phép dùng đuôi: jpg,png,gif', 'vietanh')
//                    )
                )
            ); // end section

        }

        public function setSectionsSettingLeftMenu() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Left menu settings', 'vietanh' ),
                'desc'   => __( 'Setting slug category for left menu (Craft collection, Academy collection).', 'vietanh' ),
                'icon'   => 'el-icon-cog',
                'fields' => array(
                    array(
                        'id' => 'kn_slug_craft_collection',
                        'type' => 'text',
                        'title' => __('Craft collection category slug', 'vietanh'),
                        'compiler' => true,
                        'default' => 'craft-collection',
                        'desc' => __('Input your craft collection category slug', 'vietanh')
                    ),
                    array(
                        'id' => 'kn_slug_craft_academy',
                        'type' => 'text',
                        'title' => __('Craft academy category slug', 'vietanh'),
                        'compiler' => true,
                        'default' => 'craft-academy',
                        'desc' => __('Input your craft academy category slug', 'vietanh')
                    ),
                )
            ); // end section

        }

        public function setPayment() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting upgrade today page', 'upgrade_today' ),
                'desc'   => __( 'All of settings for package payment.', 'upgrade_today' ),
                'icon'   => 'el-icon-cog',
                'fields' => array(
                    array(
                        'id' => 'section-month-start',
                        'type' => 'section',
                        'title' => __('Month package', 'vietanh'),
                        'compiler' => true
                    ),
                    array(
                        'id' => 'kn_monthly_package_title',
                        'type' => 'text',
                        'title' => __('Title', 'vietanh'),
                        'compiler' => true,
                        'default' => 'Monthly membership'
                    ),
                    array(
                        'id' => 'kn_monthly_package_detail',
                        'type' => 'textarea',
                        'title' => __('Detail package', 'vietanh'),
                        'compiler' => true,
                        'default' => '
                        After 30 days,<br>$9.99/month<br>(paid month)
                        '
                    ),
                    array(
                        'id' => 'kn_monthly_package_price',
                        'type' => 'text',
                        'title' => __('Giá gốc gói tháng', 'vietanh'),
                        'compiler' => true,
                        'default' => '9.99'
                    ),
                    array(
                        'id' => 'kn_monthly_package_sale_price',
                        'type' => 'text',
                        'title' => __('Giá giảm gói tháng', 'vietanh'),
                        'compiler' => true,
                        'default' => '3.33'
                    ),
                    array(
                        'id' => 'kn_monthly_package_content_1',
                        'type' => 'multi_text',
                        'title' => __('Package content 1', 'vietanh'),
                        'compiler' => true
                    ),
                    array(
                        'id' => 'section-year-start',
                        'type' => 'section',
                        'title' => __('Year package', 'vietanh'),
                        'compiler' => true
                    ),
                    array(
                        'id' => 'kn_yearly_package_title',
                        'type' => 'text',
                        'title' => __('Title', 'vietanh'),
                        'compiler' => true,
                        'default' => 'Yearly membership'
                    ),
                    array(
                        'id' => 'kn_year_package_detail',
                        'type' => 'textarea',
                        'title' => __('Detail package', 'vietanh'),
                        'compiler' => true,
                        'default' => '
                        After 365 days,<br>$8.88/month<br>(paid month)
                        '
                    ),
                    array(
                        'id' => 'kn_year_package_price',
                        'type' => 'text',
                        'title' => __('Giá gốc gói năm', 'vietanh'),
                        'compiler' => true,
                        'default' => '8.88'
                    ),
                    array(
                        'id' => 'kn_year_package_sale_price',
                        'type' => 'text',
                        'title' => __('Giá giảm gói năm', 'vietanh'),
                        'compiler' => true,
                        'default' => '2.22'
                    )
                )
            ); // end section


        }

        public function setEmailSetting() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting email', 'upgrade_today' ),
                'desc'   => __( 'All of settings for email.', 'email_setting' ),
                'icon'   => 'el-icon-cog',
                'fields' => array(
                    array(
                        'id' => 'kn_email_from',
                        'type' => 'text',
                        'title' => __('Email', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_email_password',
                        'type' => 'text',
                        'title' => __('Email password', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_email_host',
                        'type' => 'text',
                        'title' => __('Email host', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_email_port',
                        'type' => 'text',
                        'title' => __('Email port', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_email_secure',
                        'type' => 'text',
                        'title' => __('SMTPSecure', 'vietanh'),
                        'compiler' => true,
                    )
                )
            );
        }



        public function setSectionsSettingHome() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting home page', 'vietanh' ),
                'desc'   => __( 'All of settings for header on this theme.', 'vietanh' ),
                'icon'   => 'el-icon-home',
                'fields' => array(
                    array(
                        'id' => 'kn_banner',
                        'type' => 'media',
                        'title' => __('Banner desktop', 'vietanh'),
                        'compiler' => true,
                        'desc' => __('Cho phép dùng đuôi: jpg,png,gif', 'vietanh')
                    ),
                    array(
                        'id' => 'kn_banner_mobile',
                        'type' => 'media',
                        'title' => __('Banner mobile', 'vietanh'),
                        'compiler' => true,
                        'desc' => __('Cho phép dùng đuôi: jpg,png,gif', 'vietanh')
                    ),
                    array(
                        'id' => 'kn_url_video',
                        'type' => 'text',
                        'title' => __('Video', 'vietanh'),
                        'compiler' => true,
                        'desc' => __('Cho phép dùng đuôi: jpg,png,gif', 'vietanh')
                    ),
                    array(
                        'id' => 'kn_image_video',
                        'type' => 'media',
                        'title' => __('Image for video', 'vietanh'),
                        'compiler' => true,
                        'desc' => __('Cho phép dùng đuôi: jpg,png,gif', 'vietanh')
                    ),
                )
            ); // end section

        }

        public function setFacebookAppLogin() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting Login with Facebook', 'vietanh' ),
                'desc'   => __( 'All of settings for login with facebook.', 'vietanh' ),
                'icon'   => 'el-icon-facebook',
                'fields' => array(
                    array(
                        'id' => 'kn_app_id',
                        'type' => 'text',
                        'title' => __('App ID', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_app_serect',
                        'type' => 'text',
                        'title' => __('App Serect', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_url_callback',
                        'type' => 'text',
                        'title' => __('Url Callback', 'vietanh'),
                        'compiler' => true,
                    )
                )
            ); // end section

        }

        public function setGoogleLogin() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting Login with Google', 'vietanh' ),
                'desc'   => __( 'All of settings for login with Google.', 'vietanh' ),
                'icon'   => 'el-icon-certificate',
                'fields' => array(
                    array(
                        'id' => 'kn_client_id',
                        'type' => 'text',
                        'title' => __('Client ID', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_client_serect',
                        'type' => 'text',
                        'title' => __('Client Serect', 'vietanh'),
                        'compiler' => true,
                    )
                )
            ); // end section

        }

        public function set2checkout() {
            // Home Section
            $this->sections[] = array(
                'title'  => __( 'Setting 2Checkout', 'vietanh' ),
                'desc'   => __( 'All of settings for payment by 2Checkout.', 'vietanh' ),
                'icon'   => 'el-icon-credit-card',
                'fields' => array(
                    array(
                        'id' => 'kn_2co_account',
                        'type' => 'text',
                        'title' => __('2Checkout Account', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_2co_publish_key',
                        'type' => 'text',
                        'title' => __('2Checkout Publish Key', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_2co_private_key',
                        'type' => 'text',
                        'title' => __('2Checkout Private Key', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_2co_serect_word',
                        'type' => 'text',
                        'title' => __('2Checkout Serect Word', 'vietanh'),
                        'compiler' => true,
                    ),
                    array(
                        'id' => 'kn_2co_demo',
                        'type' => 'checkbox',
                        'title' => __('2Checkout Demo mode', 'vietanh'),
                        'compiler' => true,
                    )
                )
            ); // end section

        }


    }
    global $reduxConfig;
    $reduxConfig = new VA_Theme_Options();
};
