<?php 

/**
 * Menu Item array
 *
 * 0: Name of the menu item
 * 1: Filename of the menu item
 * 2: Icon for the menu item
 */
$menuItem[] = ['Dashboard', '', 'ph-house'];
$menuItem[] = ['Posts', 'posts/', 'ph-pencil-line'];
    $submenuItem['posts/'][] = ['Add New Post', 'posts/new/'];
    $submenuItem['posts/'][] = ['Manage Posts', 'posts/'];
$menuItem[] = ['Categories', 'categories/', 'ph-square-half'];
    $submenuItem['categories/'][] = ['Add New Category', 'categories/new/'];
    $submenuItem['categories/'][] = ['Manage Categories', 'categories/'];
$menuItem[] = ['Tags', 'tags/', 'ph-tag'];
    $submenuItem['tags/'][] = ['Add New Tag', 'tags/new/'];
    $submenuItem['tags/'][] = ['Manage Tags', 'tags/'];
$menuItem[] = ['Gallery', 'gallery/', 'ph-image'];
    $submenuItem['gallery/'][] = ['Add New Image', 'gallery/new/'];
    $submenuItem['gallery/'][] = ['Media Manager', 'gallery/'];
$menuItem[] = ['Sign Out', 'sign-out/', 'ph-sign-out'];
?>

<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar header -->
    <div class="sidebar-section bg-black bg-opacity-10 border-bottom border-bottom-white border-opacity-10">
        <div class="sidebar-logo d-flex justify-content-center align-items-center">
            <a href="#" class="d-inline-flex align-items-center py-2">
                <img src="#" class="sidebar-logo-icon" alt="">
                <img src="#" class="sidebar-resize-hide ms-3" height="14" alt="">
            </a>

            <div class="sidebar-resize-hide ms-auto">
                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="ph-arrows-left-right"></i>
                </button>

                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                    <i class="ph-x"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- /sidebar header -->

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <?php
                $url = $config->site->url . '/bms/';

                foreach ($menuItem as $menu) : ?>

                    <?php if (isset($submenuItem[$menu[1]])) : ?>
                        <li class="nav-item nav-item-submenu <?= ($parent == $menu[1]) ? 'nav-item-expanded nav-item-open' : '' ?>">
                    <?php else : ?>
                        <li class="nav-item">
                    <?php endif; ?>


                    <?php if ($file == $menu[1]) : ?>
                        <a href="<?= $url . $menu[1]; ?>" class="nav-link active">
                    <?php else : ?>
                        <a href="<?= $url . $menu[1]; ?>" class="nav-link">
                    <?php endif; ?>

                    <i class="<?= $menu[2]; ?>"></i>
                    <span><?= $menu[0]; ?></span>
                    </a>

                    <?php if (isset($submenuItem[$menu[1]])) : ?>
                        <ul class="nav-group-sub collapse <?= ($parent == $menu[1]) ? 'show' : '' ?>">
                            <?php foreach ($submenuItem[$menu[1]] as $sub) : ?>
                                <li class="nav-item">
                                    <a href="<?= $url . $sub[1]; ?>" class="nav-link <?= ($file == $sub[1]) ? 'active' : '' ?>"><?= $sub[0]; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

    <div class="alert bg-secondary bg-opacity-20 sidebar-resize-hide rounded p-3 m-3">
            <span class="fw-bold">Custom BMS V:1.0.0</span>
    </div>

</div>