<?php global $va_options;?>
<section class="footing pt-20 pb-20">
    <div class="wraper">
        <div class="row">
            <div class="col-6">
                <address>© 2021 KenNguyen. All rights reserved.</address>
            </div>
            <div class="col-6">
                <div class="row">
                    <?php
                    $menuLocations = get_nav_menu_locations();
                    $menuID = $menuLocations['other-footer'];
                    $primaryNav = wp_get_nav_menu_items($menuID);
                    foreach ($primaryNav as $key => $item) {
                        echo '<div class="col-4"> <a href="'.$item->url.'">'.$item->title.'</a></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
