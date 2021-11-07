<?php
/**
 * Template Name: Verify page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */
        get_header();
        $token = $_GET['token'];

        if (isset($token)) {
            global $wpdb;
            $table = $wpdb->prefix.'customer';

            $data = [ 'active' => 1, 'trackingMd5' => '' ]; // NULL value.
            $where = [ 'trackingMd5' => $token ]; // NULL value in WHERE clause.
            $results = $wpdb->update( $table, $data, $where ); // Also works in this case.

            if ($results != 0) {
                ?>
                <div class="jumbotron text-center pt-50 pb50">
                    <p class="lead text-success"><strong>Active account successful!</strong></p>
                    <p>
                        Having trouble? <a href="">Contact us</a>
                    </p>
                    <p class="lead">
                        <a class="btn btn-success" href="<?php site_url() ?>/login">
                            LOGIN
                        </a>
                    </p>
                </div>
                <?php
            } else {
                ?>
                <div class="jumbotron text-center pt-50 pb50">
                    <p class="lead text-danger"><strong>Active account do not success, please contact us to support your account</strong></p>
                    <p>
                        Having trouble? <a href="">Contact us</a>
                    </p>
                    <p class="lead">
                        <a class="btn btn-success" href="<?php site_url() ?>/singup">
                            SIGN UP
                        </a>
                    </p>
                </div>
<?php
            }
        }
        get_footer();
        ?>
