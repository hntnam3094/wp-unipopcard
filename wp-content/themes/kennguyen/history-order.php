<?php
/**
 * Template Name: History page
 *
 * @package KenNguyen
 * @subpackage Kem_Nguyen
 * @since Ken Nguyen 1.0
 */

if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
    global $wpdb;

    $table = $wpdb->prefix . 'order';

    $queryResult = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM {$table} WHERE id_customer=%d ",$user->id));

    get_header();
    ?>
    <main>
        <section class="my_project pt-40 pb-100">
            <div class="wraper">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="manager_member">
                            <div class="info flexBox midle">
                                <div class="avatar">
                                    <div class="imgDrop"> <img src="<?php bloginfo('template_directory') ?>/common/images/avatar.png" alt=""/></div>
                                </div>
                                <div class="name">
                                    <div class="fz-18">Account of</div>
                                    <div class="fz-24"><?= $user->first_name .' '. $user->last_name ?></div>
                                </div>
                            </div>
                            <div class="info_course">
                                <ul>
                                    <li class="mt-40"><a href="<?php site_url() ?>/manager">
                                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_01_on.svg" alt=""/></div>
                                            <div class="txt">My Downloaded Projects</div></a></li>
                                    <li class="mt-40"><a class="active" href="<?php site_url() ?>/history">
                                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03_on.svg" alt=""/></div>
                                            <div class="txt">History order</div></a></li>
                                    <li class="mt-40"><a href="<?php site_url() ?>/account">
                                            <div class="icon"> <img src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03.svg" alt=""/><img class="on" src="<?php bloginfo('template_directory') ?>/common/images/icon/acc_03_on.svg" alt=""/></div>
                                            <div class="txt">Account Settings</div></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 project">
                        <div class="course_my pt-40 pb-50">
                            <h1 class="ttl_main fz-20 text-center text-up">History order</h1>
                            <div class="row">
                                <?php
                                    if (isset($queryResult)) {
                                            ?>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Email/Name</th>
                                                    <th scope="col">Package</th>
                                                    <th scope="col">Bought date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                        <?php
                                        function validateEmail($email) {
                                            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                return true;
                                            }
                                            else {
                                                return false;
                                            }
                                        }
                                        foreach ($queryResult as $key =>$item) { ?>
                                                <tr>
                                                    <th scope="row"><?= $key + 1 ?></th>
                                                    <td><?= validateEmail($item->email) ? $item->email : $item->full_name ?></td>
                                                    <td><?= $item->package ?></td>
                                                    <td><?= $item->bought_date ?></td>
                                                </tr>
                                            <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php
                                    } else {
                                       ?>
                                        <div class="content pt-5">
                                            <p>You do not have any order!</p>
                                            <a href="<?php site_url() ?>/upgrade-today">JOIN NOW</a>
                                        </div>
                                        <?php
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <?php get_footer();
} else {
    wp_redirect(home_url());
    exit;
}
?>
