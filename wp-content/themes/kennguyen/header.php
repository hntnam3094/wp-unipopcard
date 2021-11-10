<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <title>Ken Nguyen</title>
    <meta name="description" content="test"/>
    <meta name="keywords" content="test"/>
    <meta property="og:title" content="test"/>
    <meta property="og:image" content="<?php bloginfo('template_directory') ?>/common/images/banner_01.jpg"/>
    <meta property="og:site_name" content="test"/>
    <link rel="icon" href="<?php bloginfo('template_directory') ?>/common/images/favicon.ico"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/common.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/styles.css"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/common/css/custom.css"/>
    <?php wp_head(); ?>
</head>
<body nav_active="nav_active" class="page_payment <?php do_action('get_request'); ?>" <?php body_class(); ?>>
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
                <img class="imgAuto" src="<?php bloginfo('template_directory') ?>/common/images/logo.svg" alt=""/>
            </a>
            <div class="header-right flexBox midle end">
                <nav class="navbar navbar-expand-lg modal fade collapse" id="navbarSupportedContent" navbar-collapsetabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="header_nav">
                            <div class="nav flexBox midle space">
                                <?php wp_nav_menu(
                                    array(
                                        'theme_location' => 'left-menu',
                                        'container' => 'false',
                                        'menu_id' => 'left-menu',
                                        'menu_class' => 'flexBox midle'
                                    )
                                ); ?>
<!--                                --><?php //wp_nav_menu(
//                                    array(
//                                        'theme_location' => 'right-menu',
//                                        'container' => 'false',
//                                        'menu_id' => 'right-menu',
//                                        'menu_class' => 'flexBox midle'
//                                    )
//                                ); ?>
                                <?php
                                $menuLocations = get_nav_menu_locations();
                                $menuID = $menuLocations['right-menu'];
                                $primaryNav = wp_get_nav_menu_items($menuID);

                                ?>
                                <ul class="flexBox midle">
                                    <?php if (isset($_SESSION['user'])) {
                                        if (check_type_member() == 2) {
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
                                            $li = '<li class="nav-item"><a href="'.$navItem->url.'" title="'.$navItem->title.'">'.$navItem->title.'</a></li>';
                                            $arr = explode('/', $navItem->url);

                                            if ($arr[3] == 'upgrade-today') {
                                                $li = '<li class="nav-item"><a href="'.$navItem->url.'" title="'.$navItem->title.'">START FOR 1$ </a></li>';
                                            }
                                            if ($arr[3] == 'my-craft-room') {
                                                $li = '<li class="nav-item login"> <a class="nav-link login_link" href="'.$loginUrl.'">Login</a></li>';
                                            }
                                            echo $li;

                                        }
                                    } ?>


                                </ul>

<!--                                <ul class="flexBox midle">-->
<!--                                    <li class="nav-item"><a class="nav-link" href="category.html">CRAFT COLECTION</a></li>-->
<!--                                    <li class="nav-item"><a class="nav-link" href="contact.html">CRAFT ACADEMY</a></li>-->
<!--                                </ul>-->
<!--                                    <ul class="flexBox midle">-->
<!--                                        <li class="nav-item"><a class="nav-link" href="#">SHOP</a></li>-->
<!--                                        <li class="nav-item"><a class="nav-link" href="upgrade.html">START FOR 1$</a></li>-->
<!--                                        <li class="nav-item"><a class="nav-link" href="news.html">LOGIN</a></li>-->
<!--                                    </ul>-->

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

