<div class="navbar navbar-expand-lg navbar-static shadow">
    <div class="container-fluid">
        <div class="d-flex d-lg-none">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded">
                <i class="ph-list"></i>
            </button>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-mobile" aria-expanded="false">
                <i class="ph-squares-four"></i>
            </button>
        </div>

        <div class="navbar-collapse order-2 order-lg-1 collapse" id="navbar-mobile" style="">
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <a href="<?= $config->site->url ?>" class="navbar-nav-link rounded">View Site</a>
                </li>
            </ul>
        </div>

        <ul class="nav gap-sm-2 order-1 order-lg-2 ms-auto">
            <?php $user = new Core\Models\User($connection) ?>

            <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link align-items-center rounded p-1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="status-indicator-container">
                        <img src="<?= (new Core\Models\User($connection))->getAvatar($currentUserId) ?>" class="w-32px h-32px rounded" alt="">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2"><?= $user->get('display_name', $currentUserId)['display_name'] ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="<?= $config->site->url ?>/bms/users/profile/" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My Profile
                    </a>
                    
                    <a href="<?= $config->site->url ?>/bms/http/auth/sign-out/" class="dropdown-item">
                        <i class="ph-sign-out me-2"></i>
                        Sign Out
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>