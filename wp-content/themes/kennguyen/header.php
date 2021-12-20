<!DOCTYPE html>
<html lang="en">
<?php global $va_options;?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <title><?= $va_options['kn_page_title'] ?></title>
    <meta name="description" content="test"/>
    <meta name="keywords" content="test"/>
    <meta property="fb:app_id" content="<?= $va_options['kn_app_id'] ?>" />
    <meta property="og:title" content="<?= $va_options['kn_page_title'] ?>"/>
    <meta property="og:image" content="<?php bloginfo('template_directory') ?>/common/images/banner_01.jpg"/>
    <meta property="og:site_name" content="<?= $va_options['kn_page_title'] ?>"/>
    <link rel="icon" type="image/x-icon" href="<?= $va_options['kn_favicon'] ? $va_options['kn_favicon']['url'] : '' ?>"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/common.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/styles.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/custom.css"/>
    <?php wp_head(); ?>
    <style>
        #at4-share {
            display: none;
        }
        #at-share-dock {
            display: none;
        }
    </style>
</head>
<body nav_active="nav_active" class="page_payment <?php do_action('get_request'); ?>" <?php body_class(); ?>>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0&appId=<?= $va_options['kn_app_id'] ?>" nonce="vtHh10Cd"></script>
<?php wp_body_open(); ?>
<header class="header active_search" id="header">
    <?php do_action('block_user_login'); ?>
    <div class="header-top">
        <div class="wraper">
            <button class="navbar-toggler toggle_class" type="button" data-bs-toggle="modal" data-bs-target="#navbarSupportedContent"><span class="navbar-toggler-icon"></span></button>
        </div>
    </div>
    <div class="header-bottom">
        <div class="wraper flexBox space midle bottom">
            <a class="logo" href="/">
                <img class="imgAuto" src="<?= isset($va_options['kn_logo']) && $va_options['kn_logo']['url'] !== '' ? $va_options['kn_logo']['url'] : bloginfo('template_directory').'/common/images/logo.svg' ?>" alt=""/>
            </a>
            <div class="header-right flexBox midle end">
                <nav class="navbar navbar-expand-lg modal fade collapse" id="navbarSupportedContent" navbar-collapsetabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="header_nav">
                            <div class="nav flexBox midle space">
                                <?php
                                $menuLocations = get_nav_menu_locations();
                                $menuID = $menuLocations['left-menu'];
                                $primaryNav = wp_get_nav_menu_items($menuID);
                                $currentCategory = get_queried_object();
                                ?>
                                <ul class="flexBox midle">
                                    <?php foreach ($primaryNav as $key => $item) {
                                    $parentCategoryCollection = get_category_by_slug($item->title);
                                    if ($parentCategoryCollection) {
                                    $checkParentMenuActive = $currentCategory->slug == $parentCategoryCollection->slug;
                                    ?>

                                    <li class="nav-item dropdown toggle_parent <?= $currentCategory->parent == $parentCategoryCollection->cat_ID || $checkParentMenuActive ? 'active' : ''?>">
                                        <a class="nav-link" href="/<?=$parentCategoryCollection->slug?>"><?= $parentCategoryCollection->name ?></a>
                                        <div class="toggle_btn icon_toggle">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9" fill="none">
                                                <path d="M13.5443 1.91243C13.9348 1.5219 13.9348 0.88874 13.5443 0.498215C13.1537 0.107691 12.5206 0.107691 12.13 0.498215L13.5443 1.91243ZM7.18029 6.86218L6.47318 7.56928L7.18029 8.27639L7.8874 7.56928L7.18029 6.86218ZM2.23054 0.498215C1.84002 0.107691 1.20686 0.107691 0.816331 0.498215C0.425806 0.88874 0.425806 1.5219 0.816331 1.91243L2.23054 0.498215ZM12.13 0.498215L6.47318 6.15507L7.8874 7.56928L13.5443 1.91243L12.13 0.498215ZM7.8874 6.15507L2.23054 0.498215L0.816331 1.91243L6.47318 7.56928L7.8874 6.15507Z" fill="#2C2C2C"></path>
                                            </svg>
                                        </div>
                                        <div class="sub_menu toggle_content">
                                            <div class="wraper">
                                                <ul class="flexBox">
                                                    <?php
                                                    $args = array(
                                                        'type'      => 'post',
                                                        'child_of'  => 0,
                                                        'hide_empty' => 0,
                                                        'parent'    => $parentCategoryCollection->cat_ID
                                                    );
                                                    $categories = get_categories( $args );
                                                    foreach ( $categories as $key => $category ) {
                                                        $active = $currentCategory->cat_ID == $category->cat_ID ? 'active' : '';
                                                        echo ' <li> <a class="' . $active . '" href="/' .$parentCategoryCollection->slug.'/'.$category->slug . '">' . $category->name . '</a></li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } }?>
                                </ul>
                                <?php
                                //                                wp_nav_menu(
                                //                                    array(
                                //                                        'theme_location' => 'left-menu',
                                //                                        'container' => 'false',
                                //                                        'menu_id' => 'left-menu',
                                //                                        'menu_class' => 'flexBox midle'
                                //                                    )
                                //                                );
                                ?>
                                <?php
                                $menuLocations = get_nav_menu_locations();
                                $menuID = $menuLocations['right-menu'];
                                $primaryNav = wp_get_nav_menu_items($menuID);

                                ?>
                                <ul class="flexBox midle">
                                    <?php if (isset($_SESSION['user'])) {
                                        if (check_membership() == 2) {
                                            foreach ( $primaryNav as $navItem ) {
                                                $li = '<li class="nav-item"><a href="'.$navItem->url.'" title="'.$navItem->title.'">'.$navItem->title.'</a></li>';
                                                $arr = explode('/', $navItem->url);
                                                if ($arr[3] == 'upgrade-today') {
                                                    $li = '';
                                                }
                                                echo $li;
                                            }
                                        } else {
                                            foreach ( $primaryNav as $navItem ) {
                                                $li = '<li class="nav-item"><a href="'.$navItem->url.'" title="'.$navItem->title.'">'.$navItem->title.'</a></li>';
                                                $arr = explode('/', $navItem->url);
                                                if ($arr[3] == 'upgrade-today') {
                                                    $li = '<li class="nav-item"><a href="'.$navItem->url.'" title="UPGRADE TODAY">UPGRADE TODAY</a></li>';
                                                }
                                                echo $li;
                                            }
                                        }
                                        ?>
                                        <li class="nav-item nav_setting">
                                            <a class="nav-link" href="<?php site_url() ?>/account">
                                                <div class="btn_setting">
                                                    <img src="<?php bloginfo('template_directory') ?>/common/images/icon/icon_setting.svg" alt=""/>
                                                </div>
                                                <span>Account Setting</span>
                                            </a>
                                        </li>
                                        <?php
                                    } else {
                                        $loginUrl = site_url() . '/login';
                                        foreach ( $primaryNav as $navItem ) {
                                            $li = '<li class="nav-item"><a class="nav-link" href="'.$navItem->url.'" title="'.$navItem->title.'">'.$navItem->title.'</a></li>';
                                            $arr = explode('/', $navItem->url);

                                            if ($arr[3] == 'my-craft-room') {
                                                $li = '<li class="nav-item login"> <a class="nav-link login_link" href="'.$loginUrl.'">Login</a></li>';
                                            }
//                                            if ($arr[3] == 'upgrade-today') {
//                                                $title = str_replace('$_MONEY',$va_options['kn_monthly_package_sale_price'] . '$', $navItem->title);
//                                                $li = '<li class="nav-item"><a href="'.$navItem->url.'" title="'.$title.'">'.$title.'</a></li>';
//                                            }
                                            echo $li;

                                        }
                                    } ?>
<!--                                <ul class="flexBox midle">-->
<!--                                    <li class="nav-item"><a class="nav-link" href="category.html">CRAFT COLECTION</a></li>-->
<!--                                    <li class="nav-item"><a class="nav-link" href="contact.html">CRAFT ACADEMY</a></li>-->
<!--                                </ul>-->
<!--                                <ul class="flexBox midle">-->
<!--                                    <li class="nav-item"><a class="nav-link" href="#" target="_blank">SHOP</a></li>-->
<!--                                    <li class="nav-item"><a class="nav-link" href="upgrade.html">UPGRADE TO DAY</a></li>-->
<!--                                    <li class="nav-item"><a class="nav-link" href="news.html">MY CRAFT ROOM</a></li>-->
<!--                                </ul>-->
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
<!--            <div class="nav_setting dropdown">-->
<!--                <div class="btn_setting dropdown-toggle" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><img src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/icon_setting.svg" alt=""/></div>-->
<!--                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">-->
<!--                    <ul>-->
<!--                        --><?php
//                            $user = $_SESSION['user'];
//                            if (empty($user)) { ?>
<!--                                <li><a class="dropdown-item" href="--><?php //site_url() ?><!--/login"><i class="icon"> <img src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/icon_login.png" alt=""/></i>Login</a></li>-->
<!--                                <li><a class="dropdown-item" href="--><?php //site_url() ?><!--/singup"><i class="icon"> <img src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/icon_signup.png" alt=""/></i>Sign up</a></li>-->
<!---->
<!--                            --><?php //   } else
//                            { ?>
<!--                                <li><a class="dropdown-item" href="--><?php //site_url() ?><!--/manager"><i class="icon"> <img src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/icon_profile.png" alt=""/></i>Profile manager</a></li>-->
<!--                                <li>-->
<!--                                    <a class="dropdown-item" href="logout.html" data-bs-toggle="modal" data-bs-target="#modal_logout">-->
<!--                                        <i class="icon"> <img src="--><?php //bloginfo('template_directory') ?><!--/common/images/icon/icon_logout.png" alt=""/>-->
<!--                                        </i>Log out</a></li>-->
<!---->
<!--                            --><?php //   }
//                        ?>
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</header>

<div id="content" class="site-content">

