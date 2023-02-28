<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'about';

include __DIR__ . '/includes/header.php'; ?>
<style>
.gallery-page__img-box {
    height: 413px;
    width: 100%;
    background-repeat: no-repeat;
    background-size: cover;
    transition: transform 0.3s ease;
}
.gallery-page__img-box:hover {
    transform: scale(1.1);
}

.page-item.active .page-link {
    background-color: var(--thm-primary);
    border-color: var(--thm-primary);
}

.page-link {
    color: var(--thm-primary);
}
</style>

       <!--Page Header Start-->
       <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?= $config->site->url ?>/assets/images/galleryback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Gallery</h2>
            </div>
        </section>
        <!--Page Header End-->

        <!--Gallery page Start-->
        <section class="gallery-page">
            <div class="container">
                <div class="row">
                <?php 
                    $gallery = new Core\Models\Gallery($connection);

                    $limit = 9;
                    $totalPosts = $gallery->count()['count'];
                    $totalPages = ceil($totalPosts / $limit);
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $limit;

                    $images = Atlas\Query\Select::new($connection)
                            ->columns('image')
                            ->from('gallery')
                            ->limit($limit)
                            ->offset($offset)
                            ->orderBy('id DESC')
                            ->fetchAll();

                    if ($totalPosts == 0) : ?>

                    <p>No images in gallery yet!</p>

                    <?php 
                    endif;
                    foreach ($images as $image) : ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                       <!--Gallery page Single-->
                        <div class="gallery-page__single">
                            <div class="gallery-page__img-box" style="background-image: url(<?= $config->site->url ?><?= $image['image'] ?>)">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <?php if ($totalPosts > $limit) : ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination pagination-flat justify-content-center mt-4">
                                    <?php 
                                    $prev_link = ($currentPage > 1) ? $config->site->url . "/gallery/page/" . ($currentPage - 1) : null;
                                    $next_link = ($currentPage < $totalPages) ? $config->site->url . "/gallery/page/" . ($currentPage + 1) : null;
                                    ?>
                                    <li class="page-item <?= is_null($prev_link) ? 'disabled' : '' ?>">
                                        <a href="<?= $prev_link ?>" class="page-link rounded">←</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) :?>
                                        <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                                            <a href="<?= $config->site->url . '/gallery/page/' . $i . '/' ?>" class="page-link rounded"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?= is_null($next_link) ? 'disabled' : '' ?>">
                                        <a href="<?= $next_link ?>" class="page-link rounded">→</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!--Gallery page End-->

<script>
    
</script>
<?php include __DIR__ . '/includes/footer.php';