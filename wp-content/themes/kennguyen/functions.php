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
    register_nav_menu('other-footer',__( 'Footer for login, signup, payment' ));
    global $_wp_theme_features;
    $_wp_theme_features['post-thumbnails']= true;

}
add_action('init', 'theme_setup');

//custom hide menu in admin
function hide_menu() {
    remove_menu_page( 'edit.php' ); //Posts

    if (!DEV_ENVIRONMENT) {
        remove_menu_page( 'edit.php?post_type=acf-field-group' ); //Posts
    }
}
add_action('admin_head', 'hide_menu');

add_filter ( 'nav_menu_css_class', 'so_37823371_menu_item_class', 10, 4 );
function so_37823371_menu_item_class ( $classes, $item, $args, $depth ){
    $classes[] = 'nav-item';
    return $classes;
}

function create_custom_post_type_craft()
{
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Craft management', //Tên post type dạng số nhiều
    );


    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Craft management', //Mô tả của post type
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
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


    register_post_type('craft', $args); //Tạo post type với slug tên là craftcollection và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
add_action('init', 'create_custom_post_type_craft');

//function create_custom_post_type_craft_academy()
//{
//    /*
//     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
//     */
//    $label = array(
//        'name' => 'Craft academy', //Tên post type dạng số nhiều
//    );
//
//
//    /*
//     * Biến $args là những tham số quan trọng trong Post Type
//     */
//    $args = array(
//        'labels' => $label, //Gọi các label trong biến $label ở trên
//        'description' => 'Craft academy', //Mô tả của post type
//        'supports' => array(
//            'title',
//            'editor',
//            'custom-fields'
//        ), //Các tính năng được hỗ trợ trong post type
//        'taxonomies' => array( 'category', 'post_tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
//        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
//        'public' => true, //Kích hoạt post type
//        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
//        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
//        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
//        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
//        'menu_position' => 4, //Thứ tự vị trí hiển thị trong menu (tay trái)
//        'menu_icon' => 'dashicons-admin-post', //Đường dẫn tới icon sẽ hiển thị
//        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
//        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
//        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
//        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
//        'capability_type' => 'post' //
//    );
//
//
//    register_post_type('craftacademy', $args); //Tạo post type với slug tên là craftcollection và các tham số trong biến $args ở trên
//}
///* Kích hoạt hàm tạo custom post type */
//add_action('init', 'create_custom_post_type_craft_academy');

function create_custom_post_type_manage_question_and_answer()
{
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Manage Q&A', //Tên post type dạng số nhiều
    );


    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Manage Q&A', //Mô tả của post type
        'supports' => array(
            'title',
            'editor',
            'custom-fields'
        ), //Các tính năng được hỗ trợ trong post type
        'taxonomies' => array(  ), //Các taxonomy được phép sử dụng để phân loại nội dung
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


    register_post_type('questionanswer', $args); //Tạo post type với slug tên là craftcollection và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
add_action('init', 'create_custom_post_type_manage_question_and_answer');


function create_custom_post_type_package()
{
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Package Managerment', //Tên post type dạng số nhiều
    );


    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Package Managerment', //Mô tả của post type
        'supports' => array(
            'title',
            'custom-fields'
        ), //Các tính năng được hỗ trợ trong post type
        'taxonomies' => array(  ), //Các taxonomy được phép sử dụng để phân loại nội dung
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


    register_post_type('package', $args); //Tạo post type với slug tên là craftcollection và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
//add_action('init', 'create_custom_post_type_package');


function create_custom_post_type_package_content()
{
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Package content', //Tên post type dạng số nhiều
    );


    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Package content', //Mô tả của post type
        'supports' => array(
            'title',
            'custom-fields'
        ), //Các tính năng được hỗ trợ trong post type
        'taxonomies' => array(  ), //Các taxonomy được phép sử dụng để phân loại nội dung
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


    register_post_type('packagecontent', $args); //Tạo post type với slug tên là craftcollection và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
//add_action('init', 'create_custom_post_type_package_content');

// Alter the main query
function add_craft_to_frontpage( $query ) {
    if ( is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'post','craft' ) );
    }
    return $query;
}

add_action( 'pre_get_posts', 'add_craft_to_frontpage' );

function custom_post_type_slider(){
    /*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'Home slider', //Tên post type dạng số nhiều
        'singular_name' => 'Home slider' //Tên post type dạng số ít
    );

    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Home slider', //Mô tả của post type
        'supports' => array(
            'title',
            'thumbnail'
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
//function wpb_custom_post_status(){
//    register_post_status('free', array(
//        'label'                     => _x( 'Miễn phí', 'post' ),
//        'public'                    => true,
//        'exclude_from_search'       => true,
//        'show_in_admin_all_list'    => true,
//        'show_in_admin_status_list' => true,
//        'label_count'               => _n_noop( 'Miễn phí <span class="count">(%s)</span>', 'Miễn phí <span class="count">(%s)</span>' ),
//    ) );
//
//    register_post_status('sale', array(
//        'label'                     => _x( 'Đang bán', 'post' ),
//        'public'                    => true,
//        'exclude_from_search'       => true,
//        'show_in_admin_all_list'    => true,
//        'show_in_admin_status_list' => true,
//        'label_count'               => _n_noop( 'Đang bán <span class="count">(%s)</span>', 'Đang bán <span class="count">(%s)</span>' ),
//    ) );
//}
//add_action( 'init', 'wpb_custom_post_status' );
//
//
//add_action('admin_footer-post.php', 'wpb_append_post_status_list2');
//add_action('admin_footer-post-new.php', 'wpb_append_post_status_list2');
//function wpb_append_post_status_list2(){
//    global $post;
//    $complete = '';
//    $label = 'Free';
//    $value = 'free';
//    if($post->post_type == 'craftcollection' || $post->post_type == 'craftacademy'){
//
//        if($post->post_status == 'free'){
//            $complete = ' selected=\"selected\"';
//        }
//
//        $data = $complete ? $label : '';
//        echo '
//                <script>
//                jQuery(document).ready(function($){
//                    console.log("vàooo")
//                $("select#post_status").prepend("<option value=\"'.$value.'\" '.$complete.'>'.$label.'</option>");
//                $("#post-status-display").prepend("'.$data.'");
//                });
//                </script>
//                ';
//    }
//}
//
//// Using jQuery to add it to post status dropdown
//add_action('admin_footer-post.php', 'wpb_append_post_status_list');
//add_action('admin_footer-post-new.php', 'wpb_append_post_status_list');
//function wpb_append_post_status_list(){
//    global $post;
//    $complete = '';
//    $label = 'Sale';
//    $value = 'sale';
//    if($post->post_type == 'craftcollection' || $post->post_type == 'craftacademy'){
//        if($post->post_status == 'sale'){
//            $complete = ' selected=\"selected\"';
//        }
//        $data = $complete ? $label : '';
//        echo '
//                <script>
//                jQuery(document).ready(function($){
//                $("select#post_status").prepend("<option value=\"'.$value.'\" '.$complete.'>'.$label.'</option>");
//                $("#post-status-display").append("'.$data.'");
//                });
//                </script>
//                ';
//    }
//}
//
//add_action('admin_footer-edit.php','rudr_status_into_inline_edit');
//
//function rudr_status_into_inline_edit() { // ultra-simple example
//    echo "<script>
//	jQuery(document).ready( function($) {
//        $( 'select[name=\"_status\"]' ).prepend( '<option value=\"free\">Free</option>' );
//        $( 'select[name=\"_status\"]' ).prepend( '<option value=\"sale\">Sale</option>' );
//	});
//	</script>";
//}

function getRequest() {
    global $wp;
    $classes = '';
    if ($wp->request == 'login' || $wp->request == 'singup' || $wp->request == 'forgot-pass' || $wp->request == 'thanks-register' || $wp->request == 'payment')
    {
        $classes = 'action_page';
    }
    echo $classes;
}

add_action('get_request', 'getRequest');

//function wpabsolute_block_users_backend() {
//    if ( is_admin() && ! current_user_can( 'administrator' ) && ! wp_doing_ajax() ) {
//        wp_redirect( home_url() );
//        exit;
//    }
//}
//add_action( 'init', 'wpabsolute_block_users_backend' );


function activeAccountSMTP($email) {
    global $va_options;
    global $wpdb;
    $table = $wpdb->prefix . 'customer';
    $urlActive = site_url() . '/thanks-register?token='. md5($email);

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    $fullname = '';
    $url = home_url();
    $queryResult = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table}  WHERE email=%s",$email));

    if (!empty($queryResult)) {
        $fullname = $queryResult[0]->first_name . ' ' . $queryResult[0]->last_name;
    }
    $dear = !empty($fullname) ? $fullname : $email;

    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = $va_options['kn_email_secure'];
    $mail->Port       = $va_options['kn_email_port'];
    $mail->Host       = $va_options['kn_email_host'];
    $mail->Username   = $va_options['kn_email_from'];
    $mail->Password   = $va_options['kn_email_password'];

    $mail->IsHTML(true);
    $mail->AddAddress($email, "Verify account register for KenNguyen!!");
    $mail->SetFrom($va_options['kn_email_from'], "Verify account register for KenNguyen!!");
    $mail->Subject = "Verify account register for KenNguyen!!";
    $content = '<div style="width:100%; background-color: #EEEEEE"><div class="adM">
                    </div><div style="max-width:600px; margin: 0 auto"><div class="adM">
                        </div><table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#eeeeee" width="100%" style="max-width:600px">
                            <tbody><tr>
                                <td style="font-family:arial;font-size:12px;color:#333333;padding:10px 20px;text-align:center">
                                </td>
                            </tr>
                        </tbody></table>
                        <table style="margin-left:0;border-collapse:collapse;background-color:#ffffff;width:100%;max-width:600px" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                            <tr>
                                <td style="background-color:#ffffff">
                                    <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width:600px;border-bottom:1px solid #cccccc">
                                       <tbody>
                                         <tr>
                                            <td style="padding:20px;text-align:left">
                                                <span style="color:#000000;font-family:Arial;font-size:18px;font-weight:bold">
                                                    <a href="'.$url.'" target="_blank" >
                                                        <img style="width:120px"  src="'.getLogoBase64().'" alt="Logo">
                                                    </a>
                                                </span>
                                                <br>
                                                <a href="'.$url.'" style="color:#000000;text-decoration:none" target="_blank">
                                                    <span style="font-family:Arial;font-size:14px;font-weight:bold">
                                                        Active register account for KenNguyen
                                                    </span>
                                                </a>
                                            </td>
                                          
                                         </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td style="padding:20px">
                
                                                    <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width:600px">
                                                      <tbody>
                                                          <tr>
                                                            <td style="padding:20px 20px 15px;font-family:arial;font-size:12px;line-height:20px;color:#333333">
                                                              Dear '.$dear.',
                                                            </td>
                                                          </tr>
                                                          <tr style="border-bottom:10px solid #eeeeee">
                                                            <td style="padding:0 20px 20px;font-family:arial;font-size:12px;line-height:20px;color:#333333;border-bottom:10px solid #eeeeee">
                                                             Click on the link below to activate your account for <a href="'.$url.'" style="font-weight: bold;color: #333;font-style: italic;text-decoration: none" target="_blank" >KenNguyen</a>
                                                             <br/><br/> 
                                                             '.$urlActive.'
                                                            <br><br>
                                                              Thank you for use our services of <a href="'.$url.'" >KenNguyen</a> online products and services.
                                                              <br>
                                                            </td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#eeeeee" width="100%" style="max-width:600px">
                            <tbody><tr>
                                <td style="font-family:arial;font-size:12px;color:#333333;padding:10px 20px;text-align:center">
                                </td>
                            </tr>
                        </tbody></table><div class="yj6qo"></div><div class="adL">
                    </div></div><div class="adL">
                </div></div>';

    $mail->MsgHTML($content);
    $mail->Send();

}
add_action( 'active_account_email', 'activeAccountSMTP');

function getLogoBase64() {
    $path = isset($va_options['kn_logo']) && $va_options['kn_logo']['url'] !== '' ? $va_options['kn_logo']['url'] : get_template_directory_uri() . '/common/images/logo_new.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}
function forgetPasswordSMTP($email, $password, $isNewAccount = false) {
    global $wpdb;
    global $va_options;
    $table = $wpdb->prefix . 'customer';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    $fullname = '';
    $url = home_url();
    $queryResult = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table}  WHERE email=%s",$email));

    if (!empty($queryResult)) {
        $fullname = $queryResult[0]->first_name . ' ' . $queryResult[0]->last_name;
    }
    $startDate = $queryResult[0]->start_date;
    $endDate = $queryResult[0]->end_date;
    $member_package = $queryResult[0]->type_member == 1 ? $va_options['kn_monthly_package_title'] : $va_options['kn_yearly_package_title'];
    $email_account = $queryResult[0]->email;

    $dear = !empty($fullname) ? $fullname : $email;

    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = $va_options['kn_email_secure'];
    $mail->Port       = $va_options['kn_email_port'];
    $mail->Host       = $va_options['kn_email_host'];
    $mail->Username   = $va_options['kn_email_from'];
    $mail->Password   = $va_options['kn_email_password'];

    $mail->IsHTML(true);
    $mail->AddAddress($email, $isNewAccount ? "Successful payment at Ken Nguyen!" : "Create new password for KenNguyen account!");
    $mail->SetFrom($va_options['kn_email_from'], $isNewAccount ? "Successful payment at Ken Nguyen!" : "Create new password for KenNguyen account!");
    $mail->Subject = $isNewAccount ? "Successful payment at Ken Nguyen!" : "Create new password for KenNguyen account!";
    $content = '<div style="width:100%; background-color: #EEEEEE"><div class="adM">
                    </div><div style="max-width:600px; margin: 0 auto"><div class="adM">
                        </div><table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#eeeeee" width="100%" style="max-width:600px">
                            <tbody><tr>
                                <td style="font-family:arial;font-size:12px;color:#333333;padding:10px 20px;text-align:center">
                                </td>
                            </tr>
                        </tbody></table>
                        <table style="margin-left:0;border-collapse:collapse;background-color:#ffffff;width:100%;max-width:600px" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                            <tr>
                                <td style="background-color:#ffffff">
                                    <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width:600px;border-bottom:1px solid #cccccc">
                                       <tbody>
                                         <tr>
                                            <td style="padding:20px;text-align:left">
                                                <span style="color:#000000;font-family:Arial;font-size:18px;font-weight:bold">
                                                    <a href="'.$url.'" target="_blank" >
                                                       <img style="width:120px"  src="'.getLogoBase64().'" alt="Logo">
                                                    </a>
                                                </span>
                                                <br>
                                                <a href="'.$url.'" style="color:#000000;text-decoration:none" target="_blank">
                                                    <span style="font-family:Arial;font-size:14px;font-weight:bold">
                                                        Create new password for KenNguyen account!
                                                    </span>
                                                </a>
                                            </td>
                                          
                                         </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td style="padding:20px">
                
                                                    <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width:600px">
                                                      <tbody>
                                                          <tr>
                                                            <td style="padding:20px 20px 15px;font-family:arial;font-size:12px;line-height:20px;color:#333333">
                                                              Dear '.$dear.',
                                                            </td>
                                                          </tr>
                                                          <tr style="border-bottom:10px solid #eeeeee">
                                                            <td style="padding:0 20px 20px;font-family:arial;font-size:12px;line-height:20px;color:#333333;border-bottom:10px solid #eeeeee">
                                                             This is new your password for '.$url.'
                                                             <br/>
                                                              <strong style="font-size: 20px; background-color: #EEEEEE"> '.$password.'</strong>
                                                              <br/> Please change your password when you login successful!
                                                            <br><br>
                                                              Thank you for use our services of <a href="'.$url.'" >KenNguyen</a> online products and services.
                                                              <br>
                                                            </td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#eeeeee" width="100%" style="max-width:600px">
                            <tbody><tr>
                                <td style="font-family:arial;font-size:12px;color:#333333;padding:10px 20px;text-align:center">
                                </td>
                            </tr>
                        </tbody></table><div class="yj6qo"></div><div class="adL">
                    </div></div><div class="adL">
                </div></div>';

    if ($isNewAccount) {
        $content = '<div style="width:100%; background-color: #EEEEEE"><div class="adM">
                    </div><div style="max-width:600px; margin: 0 auto"><div class="adM">
                        </div><table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#eeeeee" width="100%" style="max-width:600px">
                            <tbody><tr>
                                <td style="font-family:arial;font-size:12px;color:#333333;padding:10px 20px;text-align:center">
                                </td>
                            </tr>
                        </tbody></table>
                        <table style="margin-left:0;border-collapse:collapse;background-color:#ffffff;width:100%;max-width:600px" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                            <tr>
                                <td style="background-color:#ffffff">
                                    <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width:600px;border-bottom:1px solid #cccccc">
                                       <tbody>
                                         <tr>
                                            <td style="padding:20px;text-align:left">
                                                <span style="color:#000000;font-family:Arial;font-size:18px;font-weight:bold">
                                                    <a href="'.$url.'" target="_blank" >
                                                        <img style="width:120px"  src="'.getLogoBase64().'" alt="Logo">
                                                    </a>
                                                </span>
                                                <br>
                                                <a href="'.$url.'" style="color:#000000;text-decoration:none" target="_blank">
                                                    <span style="font-family:Arial;font-size:14px;font-weight:bold">
                                                        Successful payment at Ken Nguyen!
                                                    </span>
                                                </a>
                                            </td>
                                          
                                         </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td style="padding:20px">
                
                                                    <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width:600px">
                                                      <tbody>
                                                          <tr>
                                                            <td style="padding:20px 20px 15px;font-family:arial;font-size:12px;line-height:20px;color:#333333">
                                                              Dear '.$dear.',
                                                            </td>
                                                          </tr>
                                                          <tr >
                                                              <td style="font-size: 17px; padding-left: 20px">
                                                                You have successfully paid your account at '.$url.'
                                                              </td>
                                                          </tr>
                                                          <tr >
                                                           <td style="font-size: 17px; padding-left: 20px">
                                                              Premium package: <b>'.$member_package.'</b>
                                                              </td>
                                                            </tr>
                                                            <tr >
                                                            <td style="font-size: 17px; padding-left: 20px">
                                                                Used Time: From <b>'.$startDate.'</b> To <b>'.$endDate.'</b>
                                                              </td>
                                                            </tr>
                                                            <br>
                                                          <tr style="border-bottom:10px solid #eeeeee">
                                                            <td style="padding:0 20px 20px;font-family:arial;font-size:12px;line-height:20px;color:#333333;border-bottom:10px solid #eeeeee">
                                                             This is your email and password for <a href="'.$url.'" style="text-decoration:none!important;text-decoration:none;color:#0064c8" target="_blank" >'.$url.'</a>
                                                             <br/>
                                                              Email: <strong style="font-size: 13px; text-decoration: none; color: #333333"> '.$email_account.'</strong
                                                             <br/>
                                                              Password: <strong style="font-size: 13px;"> '.$password.'</strong
                                                            <br><br>
                                                              Thank you for use our services of <a href="'.$url.'" >KenNguyen</a> online products and services.
                                                              <br>
                                                            </td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#eeeeee" width="100%" style="max-width:600px">
                            <tbody><tr>
                                <td style="font-family:arial;font-size:12px;color:#333333;padding:10px 20px;text-align:center">
                                </td>
                            </tr>
                        </tbody></table><div class="yj6qo"></div><div class="adL">
                    </div></div><div class="adL">
                </div></div>';
    }

    $mail->MsgHTML($content);
    $mail->Send();

}
add_action( 'forget_password_email', 'forgetPasswordSMTP', 10, 3);

function your_function()
{
    add_settings_field(
        'myprefix_setting-id',
        'This is the setting title',
        'myprefix_setting_callback_function',
        'general',
        'default',
        array('label_for' => 'myprefix_setting-id')
    );
}
add_action('admin_init', 'your_function');

/*  Custom Field for Categories.
    ======================================== */

// Add new term page
function my_taxonomy_add_meta_fields( $taxonomy ) { ?>
    <div class="form-field term-group">
    <label for="show_category">
        <?php _e( 'Category in month', 'codilight-lite' ); ?> <input type="checkbox" id="show_category" name="show_category" value="yes" />
    </label>
    </div>
    <div class="form-field term-group">
        <label for="feature_category">
            <?php _e( 'Feature category', 'codilight-lite' ); ?> <input type="checkbox" id="feature_category" name="feature_category" value="yes" />
        </label>
    </div>
    <?php
}
add_action( 'category_add_form_fields', 'my_taxonomy_add_meta_fields', 10, 2 );

// Edit term page
function my_taxonomy_edit_meta_fields( $term, $taxonomy ) {
    $feature_category = get_term_meta( $term->term_id, 'feature_category', true );
    $show_category = get_term_meta( $term->term_id, 'show_category', true ); ?>


    <tr class="form-field term-group-wrap">
    <th scope="row">
        <label for="show_category"><?php _e( 'Category in month', 'codilight-lite' ); ?></label>
    </th>
    <td>
        <input type="checkbox" id="show_category" name="show_category" value="yes" <?php echo ( $show_category ) ? checked( $show_category, 'yes' ) : ''; ?>/>
    </td>
    </tr>

    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="feature_category"><?php _e( 'Feature category', 'codilight-lite' ); ?></label>
        </th>
        <td>
            <input type="checkbox" id="feature_category" name="feature_category" value="yes" <?php echo ( $feature_category ) ? checked( $feature_category, 'yes' ) : ''; ?>/>
        </td>
    </tr>

    <?php
}
add_action( 'category_edit_form_fields', 'my_taxonomy_edit_meta_fields', 10, 2 );

// Save custom meta
function my_taxonomy_save_taxonomy_meta( $term_id, $tag_id ) {
    if ( isset( $_POST[ 'show_category' ] ) ) {
        update_term_meta( $term_id, 'show_category', 'yes' );
    } else {
        update_term_meta( $term_id, 'show_category', '' );
    }

    if ( isset( $_POST[ 'feature_category' ] ) ) {
        update_term_meta( $term_id, 'feature_category', 'yes' );
    } else {
        update_term_meta( $term_id, 'feature_category', '' );
    }
}
add_action( 'created_category', 'my_taxonomy_save_taxonomy_meta', 10, 2 );
add_action( 'edited_category', 'my_taxonomy_save_taxonomy_meta', 10, 2 );

add_action('init','add_get_val');
function add_get_val() {
    global $wp;
    $wp->add_query_var('category');
    $wp->add_query_var('q');
}

// Add the custom columns to the book post type:
//add_filter( 'manage_craftacademy_posts_columns', 'set_custom_edit_craftacademy_columns' );
//function set_custom_edit_craftacademy_columns($columns) {
//    $columns['status'] = __( 'Status', 'smashing' );
//
//    return $columns;
//}
//
//add_action( 'manage_craftacademy_posts_custom_column', 'smashing_craftacademy_column', 10, 2);
//function smashing_craftacademy_column( $column, $post_id ) {
//    // Image column
//    if ( 'status' === $column ) {
//        echo get_post_status( $post_id);
//    }
//}

// Add the custom columns to the book post type:
add_filter( 'manage_craft_posts_columns', 'set_custom_edit_craft_columns' );
function set_custom_edit_craft_columns($columns) {
    $columns['craft_type'] = __( 'Type', 'smashing' );
    $columns['craft_thumb'] = __( 'Image', 'smashing' );

    $n_columns = array();
    $move = 'craft_thumb'; // which column to move
    $before = 'title'; // move before this column

    foreach($columns as $key => $value) {
        if ($key==$before){
            $n_columns[$move] = $move;
        }
        $n_columns[$key] = $value;
    }
    return $n_columns;
}

add_image_size( 'admin-craft-thumb-image', 60, 60, false );
add_action( 'manage_craft_posts_custom_column', 'smashing_craft_column', 10, 2);
function smashing_craft_column( $column, $post_id ) {
    // Image column
    if ( 'craft_type' === $column ) {
        if (get_field('type_account') == 0) {
            echo '<span class="craft-status craft-status-free">Free</span>';
        } else if (get_field('type_account') == 1) {
            echo '<span class="craft-status craft-status-sale">Monthly</span>';
        } else if (get_field('type_account') == 2){
            echo '<span class="craft-status craft-status-yearly">Yearly</span>';
        }
    }

    if ( 'craft_thumb' === $column ) {
        echo the_post_thumbnail('admin-craft-thumb-image');
    }
}

add_action('admin_head', 'j0e_add_admin_styles');
function j0e_add_admin_styles() {
    echo '<style>
.redux-action_bar > * {
    margin-left: 5px !important;
}
.page-numbers {
    background-color: white;
    padding: 6px;
    text-decoration: none;
    font-size: 15px;
    font-weight: bold;
}

.column-craft_thumb {width: 60px;}
.column-craft_type {text-align: center !important;}
.craft-status-sale {
    background-color: #ffc107 !important;
}
.craft-status-free {
    background-color: #28a745 !important;
}
.craft-status-yearly {
    background-color: #bb2124 !important;
}
.craft-status {
    color: #fff;
    background-color: #007bff;
    padding-right: 0.6em;
    padding-left: 0.6em;
    border-radius: 10rem;
    display: inline-block;
    padding: 0.25em 0.4em;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
}
</style>';
}

function check_membership() {
    $isMember = 0;
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $today = date("Y-m-d");
        if (!empty($user->start_date) && !empty($user->end_date)) {
            if ($today >= $user->start_date && $today <= $user->end_date) {
                $isMember = $user->type_member;
            }
        }
    }
    return $isMember;
}


add_filter('set-screen-option', 'test_table_set_option', 10, 3);
function test_table_set_option($status, $option, $value)
{
    var_dump($value);
    return $value;
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}

add_action('wp_ajax_loadmore', 'get_post_loadmore');
add_action('wp_ajax_nopriv_loadmore', 'get_post_loadmore');
function get_post_loadmore() {
    $offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0; // lấy dữ liệu phái client gởi
    $category = isset($_POST['category']) ? (string)$_POST['category'] : '';
    $keyword = isset($_POST['q']) ? (string)$_POST['q'] : '';
    if (empty($category)) {
        $category = 0;
    } else {
        $category = get_cat_ID($category);
    }
    $args = array(
        'post_status' => 'publish',
        'post_type'      => array('craft'),
        'cat' => $category,
        's'		=> $keyword,
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => $offset,
        'showposts' => 8,
    );

    $getposts = new WP_query($args);
    global $wp_query; $wp_query->in_the_loop = true;
    while ($getposts->have_posts()) : $getposts->the_post(); ?>
        <div class="column col-6 col-md-3">
            <a class="item block mt-40" href="<?= get_the_permalink() ?>">
                <div class="images">
                    <div class="imgDrop"> <?php echo get_the_post_thumbnail( get_the_ID() ); ?></div>
                </div>
                <div class="content" data-mh="content">
                    <h4 class="text-up trim trim_2"><?php echo get_the_title();?></h4>
                    <div class="desc">
                        <?php $categories = get_the_category(get_the_ID());
                        $listCategory = [];
                        foreach($categories as $category){
                            array_push($listCategory, $category->name);
                        }
                        echo implode(', ', $listCategory);
                        ?>
                    </div>
                </div>
            </a>
        </div>
    <?php endwhile; wp_reset_postdata();
    die();
}

add_filter( 'views_edit-craft', 'meta_views_wpse_94630', 10, 1 );

function meta_views_wpse_94630( $views )
{
    $views['craftfree'] = '<a href="edit.php?meta_data=type_account&meta_value=0&post_type=craft">Craft free</a>';
    $views['craftmonthly'] = '<a href="edit.php?meta_data=type_account&meta_value=1&post_type=craft">Craft for member monthly</a>';
    $views['craftyearly'] = '<a href="edit.php?meta_data=type_account&meta_value=2&post_type=craft">Craft for member yearly</a>';
    return $views;
}

add_action( 'load-edit.php', 'load_custom_filter_wpse_94630' );

function load_custom_filter_wpse_94630()
{
    global $typenow;

    // Adjust the Post Type
    if( 'craft' != $typenow )
        return;

    add_filter( 'posts_where' , 'posts_where_wpse_94630' );
}

function posts_where_wpse_94630( $where )
{
    global $wpdb;
    if ( isset( $_GET[ 'meta_data' ] ) && !empty( $_GET[ 'meta_data' ] ))
    {
        $meta = esc_sql( $_GET['meta_data'] );
        $metaValue = esc_sql( $_GET['meta_value'] );
        $where .= " AND ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key='$meta' and meta_value='$metaValue' )";
    }
    return $where;
}

function check_second_order() {
    $second_order = false;
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $today = date("Y-m-d");
        if (!empty($user->start_date) && !empty($user->end_date)) {
            if ($today >= $user->start_date && $today <= $user->end_date) {
                $type_member = $user->type_member;
            }
        }
    }
    return $second_order;
}

function ajax_request_register_guest_email() {

    // The $_REQUEST contains all the data sent via AJAX from the Javascript call
    if ( isset($_REQUEST) ) {
        global $wpdb;
        $table = $wpdb->prefix .'guest_email';
        $data = array(
            'email'    => $_REQUEST['guest_email']
        );

        $query = 'SELECT * FROM wp_guest_email where email like "'.$_POST['guest_email'].'"';
        $total_query = "SELECT COUNT(1) FROM (${query}) AS totalEmail";
        $total = $wpdb->get_var( $total_query );
        if ($total == 0) {
            $wpdb->insert( $table, $data );
            echo 'Thank you for your information. We will contact you shortly.';
        } else {
            echo 'Your email is registered. We will contact you shortly.';
        }
    }

    // Always die in functions echoing AJAX content
    wp_die();
}

// This bit is a special action hook that works with the WordPress AJAX functionality.
add_action( 'wp_ajax_ajax_request_register_guest_email', 'ajax_request_register_guest_email' );
add_action("wp_ajax_nopriv_ajax_request_register_guest_email", "ajax_request_register_guest_email");

function default_timezone () {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
}
add_action('init', 'default_timezone');
