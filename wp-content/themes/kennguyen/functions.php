<?php
if (!session_id()) {
    session_start();
}
require_once dirname( __FILE__ ).'/core/init.php';

function theme_setup() {
    register_nav_menu('left-menu',__( 'Menu trái' ));
    register_nav_menu('right-menu',__( 'Menu phải' ));
    register_nav_menu('footer-about',__( 'Footer column about' ));
    register_nav_menu('footer-resources',__( 'Footer column resources' ));

    add_image_size('banner-thumb', 1349, 281);
    add_image_size('collection-thumb', 285, 285);
    add_image_size('month-thumb', 183, 183);
    add_image_size('video-image-thumb', 920, 563);
    global $_wp_theme_features;
    $_wp_theme_features['post-thumbnails']= true;

}
add_action('init', 'theme_setup');

add_filter ( 'nav_menu_css_class', 'so_37823371_menu_item_class', 10, 4 );

function so_37823371_menu_item_class ( $classes, $item, $args, $depth ){
    $classes[] = 'nav-item';
    return $classes;
}

function create_custom_post_type_craft_collection()
{
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Craft collection', //Tên post type dạng số nhiều
    );


    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Craft collection', //Mô tả của post type
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'trackbacks',
            'revisions',
            'custom-fields'
        ), //Các tính năng được hỗ trợ trong post type
        'taxonomies' => array( 'category', 'post_tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 4, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-admin-post', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post' //
    );


    register_post_type('craftcollection', $args); //Tạo post type với slug tên là craftcollection và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
add_action('init', 'create_custom_post_type_craft_collection');

function create_custom_post_type_craft_academy()
{
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Craft academy', //Tên post type dạng số nhiều
    );


    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Craft academy', //Mô tả của post type
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'trackbacks',
            'revisions',
            'custom-fields'
        ), //Các tính năng được hỗ trợ trong post type
        'taxonomies' => array( 'category', 'post_tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 4, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-admin-post', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post' //
    );


    register_post_type('craftacademy', $args); //Tạo post type với slug tên là craftcollection và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
add_action('init', 'create_custom_post_type_craft_academy');

// Alter the main query
function add_craft_to_frontpage( $query ) {
    if ( is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'post', 'craftacademy', 'craftcollection' ) );
    }
    return $query;
}

add_action( 'pre_get_posts', 'add_craft_to_frontpage' );

function custom_post_type_slider(){
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Ảnh slider', //Tên post type dạng số nhiều
        'singular_name' => 'Ảnh slider' //Tên post type dạng số ít
    );

    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Ảnh slider', //Mô tả của post type
        'supports' => array(
            'title',
            'thumbnail',
        ), //Các tính năng được hỗ trợ trong post type
        //'taxonomies' => array( 'category', 'post_tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-admin-post', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post' //
    );

    register_post_type('slider', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên

}
add_action('init', 'custom_post_type_slider');


// Registering custom post status
function wpb_custom_post_status(){
    register_post_status('free', array(
        'label'                     => _x( 'Miễn phí', 'post' ),
        'public'                    => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Miễn phí <span class="count">(%s)</span>', 'Miễn phí <span class="count">(%s)</span>' ),
    ) );

    register_post_status('sale', array(
        'label'                     => _x( 'Đang bán', 'post' ),
        'public'                    => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Đang bán <span class="count">(%s)</span>', 'Đang bán <span class="count">(%s)</span>' ),
    ) );
}
add_action( 'init', 'wpb_custom_post_status' );


add_action('admin_footer-post.php', 'wpb_append_post_status_list2');
add_action('admin_footer-post-new.php', 'wpb_append_post_status_list2');
function wpb_append_post_status_list2(){
    global $post;
    $complete = '';
    $label = 'Miễn phí';
    $value = 'free';
    if($post->post_type == 'craftcollection' || $post->post_type == 'craftacademy'){

        if($post->post_status == 'free'){
            $complete = ' selected=\"selected\"';
        }

        $data = $complete ? $label : '';
        echo '
                <script>
                jQuery(document).ready(function($){
                    console.log("vàooo")
                $("select#post_status").prepend("<option value=\"'.$value.'\" '.$complete.'>'.$label.'</option>");
                $("#post-status-display").prepend("'.$data.'");
                });
                </script>
                ';
    }
}

// Using jQuery to add it to post status dropdown
add_action('admin_footer-post.php', 'wpb_append_post_status_list');
add_action('admin_footer-post-new.php', 'wpb_append_post_status_list');
function wpb_append_post_status_list(){
    global $post;
    $complete = '';
    $label = 'Đang bán';
    $value = 'sale';
    if($post->post_type == 'craftcollection' || $post->post_type == 'craftacademy'){
        if($post->post_status == 'sale'){
            $complete = ' selected=\"selected\"';
        }
        $data = $complete ? $label : '';
        echo '
                <script>
                jQuery(document).ready(function($){
                $("select#post_status").prepend("<option value=\"'.$value.'\" '.$complete.'>'.$label.'</option>");
                $("#post-status-display").append("'.$data.'");
                });
                </script>
                ';
    }
}

function getRequest() {
    global $wp;
    $classes = '';
    if ($wp->request == 'login' || $wp->request == 'singup' || $wp->request == 'forgot-pass')
    {
        $classes = 'action_page';
    }
    echo $classes;
}

add_action('get_request', 'getRequest');

function wpabsolute_block_users_backend() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && ! wp_doing_ajax() ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'init', 'wpabsolute_block_users_backend' );

<<<<<<< HEAD
function activeAccountSMTP($email) {
    $urlActive = site_url() . '/verify?token='. md5($email);

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "hntnam98@gmail.com";
    $mail->Password   = "jyakbhhxylrgjvpi";

    $mail->IsHTML(true);
    $mail->AddAddress($email, "Veify email for KenNguyen");
    $mail->SetFrom("hntnam98@gmail.com", "Verify account!!");
    $mail->Subject = "Verify account!!";
    $content = "<b>Click vào đường dẫn dưới đây để kích hoạt tài khoản!</b><br>";
    $content .= "<a href='".$urlActive."'>Kích hoạt tài khoản</a>";
    $mail->MsgHTML($content);
    $mail->Send();

}
add_action( 'active_account_email', 'activeAccountSMTP');

function forgetPasswordSMTP($email) {
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "hntnam98@gmail.com";
    $mail->Password   = "jyakbhhxylrgjvpi";

    $mail->IsHTML(true);
    $mail->AddAddress($email, "Forgot password email for KenNguyen");
    $mail->SetFrom("hntnam98@gmail.com", "Forgot password!!");
    $mail->Subject = "Forgot password!!";
    $content = "<b>Quên mật khẩu!</b><br>";
    $content .= "Mật khẩu tạm thời của bạn là:  <b>Az123456</b><br>";
    $content .= "Vui lòng đổi mật khẩu sau khi đăng nhập thành công!";
    $mail->MsgHTML($content);
    $mail->Send();

}
add_action( 'forget_password_email', 'forgetPasswordSMTP');

=======
>>>>>>> origin/dev
