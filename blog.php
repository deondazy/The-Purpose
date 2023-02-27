<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'blog';

include __DIR__ . '/includes/header.php'; ?>
<style>
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
            <div class="page-header__bg"
                style="background-image: url(<?= $config->site->url ?>/assets/images/blog/blogback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Blog</h2>
                
            </div>
        </section>
        <!--Page Header End-->

        <!--Blog Page Start-->
        <section class="news-page">
            <div class="container">
                <div class="row">
                    <?php 
                    $postCategory = new Core\Models\PostCategory($connection);
                    $postTag = new Core\Models\PostTag($connection);
                    $tag = new Core\Models\Tag($connection);
                    $postClass = new Core\Models\Post($connection, $postCategory, $postTag, $tag);
                    $comment = new Core\Models\Comment($connection);
                    $user = new Core\Models\User($connection);

                    $limit = 6;
                    $totalPosts = $postClass->count(['status' => 'PUBLISH'])['count'];
                    $totalPages = ceil($totalPosts / $limit);
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $limit;

                    $posts = Atlas\Query\Select::new($connection)
                            ->columns('id, content, title, featured_image, created_at, slug, author')
                            ->from('posts')
                            ->whereEquals(['status' => 'PUBLISH'])
                            ->limit($limit)
                            ->offset($offset)
                            ->orderBy('created_at DESC')
                            ->fetchAll();

                    if ($totalPosts == 0) : ?>

                    <p>No posts published yet!</p>

                    <?php 
                    endif;
                    foreach ($posts as $post) : ?>
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                        <!--News Two Single-->
                        <div class="news-two__single">
                            <div class="news-two__img-box">
                                <div class="news-two__img">
                                    <?php if (!empty($post['featured_image'])) : ?>
                                        <img src="<?= $config->site->url ?>/public/uploads/posts/featured-images/<?= $post['featured_image'] ?>" alt="">
                                    <?php else : ?>
                                        <img src="<?= $config->site->url ?>/public/assets/images/blog_featured_image_placeholder.jpg" alt="">
                                    <?php endif; ?>
                                    <a href="<?= $config->site->url ?>/blog/<?= $post['slug'] ?>/">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="news-two__date">
                                    <p><?= Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post['created_at'])->format('d M, Y') ?></p>
                                </div>
                            </div>
                            <div class="news-two__content">
                                <ul class="list-unstyled news-two__meta">
                                    <li><a href="<?= $config->site->url ?>/blog/author/<?= $user->get('username', $post['author'])['username'] ?>/"><i class="far fa-user-circle"></i> <?= $user->get('display_name', $post['author'])['display_name'] ?></a></li>
                                    <li><span>/</span></li>
                                    <li><a href="<?= $config->site->url ?>/blog/<?= $post['slug'] ?>#comments"><i class="far fa-comments"></i> <?= Atlas\Query\Select::new($connection)->columns("COUNT('id') AS count")->from('comments')->whereEquals(['post_id' => $post['id']])->whereEquals(['status' => 'APPROVED'])->fetchOne()['count'] ?> Comments</a>
                                    </li>
                                </ul>
                                <h3>
                                    <a href="<?= $config->site->url ?>/blog/<?= $post['slug'] ?>/"><?= $post['title'] ?></a>
                                </h3>
                                <p class="news-two__text"><?= Core\Utility::getWords($post['content'], 15) ?>...</p>
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
                                    $prev_link = ($currentPage > 1) ? $config->site->url . "/blog/page/" . ($currentPage - 1) : null;
                                    $next_link = ($currentPage < $totalPages) ? $config->site->url . "/blog/page/" . ($currentPage + 1) : null;
                                    ?>
                                    <li class="page-item <?= is_null($prev_link) ? 'disabled' : '' ?>">
                                        <a href="<?= $prev_link ?>" class="page-link rounded">←</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) :?>
                                        <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                                            <a href="<?= $config->site->url . '/blog/page/' . $i . '/' ?>" class="page-link rounded"><?= $i ?></a>
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
        <!--Blog Page End-->
        <?php include __DIR__ . '/includes/footer.php';