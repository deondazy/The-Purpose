<?php

use Atlas\Query\Select;
use Core\Utility;

require_once __DIR__ . '/bootstrap.php';

$page = 'blog';

$tagSlug = $_GET['tag_slug'];

$tag = new Core\Models\Tag($connection);

if ($tag->count(['slug' => $tagSlug])['count'] == 0) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/blog/');
}

// Get Author ID
$tagId = $tag->getAll('id', ['where' => ['slug' => $tagSlug]])[0]['id'];

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
                <h2>Tag: <?= $tag->get('name', $tagId)['name'] ?></h2>
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
                    $totalPosts = Select::new($connection)
                        ->columns("COUNT(DISTINCT t.post_id) as count")
                        ->from('post_tags t')
                        ->join('LEFT', 'posts p', 't.post_id = p.id')
                        ->whereEquals(['p.status' => 'PUBLISH'])
                        ->whereEquals(['t.tag_id' => $tagId])
                        ->fetchOne()['count'];
                    $totalPages = ceil($totalPosts / $limit);
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $limit;

                    $posts = Atlas\Query\Select::new($connection)
                            ->columns(
                                "DISTINCT (p.id) as id", 
                                'p.content as content', 
                                'p.title as title', 
                                'p.featured_image as featured_image', 
                                'p.created_at as created_at', 
                                'p.slug as slug', 
                                'p.author as author'
                            )
                            ->from('post_tags t')
                            ->join('LEFT', 'posts p', 't.post_id = p.id')
                            ->whereEquals(['p.status' => 'PUBLISH'])
                            ->whereEquals(['t.tag_id' => $tagId])
                            ->limit($limit)
                            ->offset($offset)
                            ->orderBy('created_at DESC')
                            ->fetchAll();

                    if ($totalPosts == 0) : ?>

                    <p>No posts published with this tag!</p>

                    <?php 
                    endif;
                    foreach ($posts as $post) : 
                        $authorUsername = $user->get('username', $post['author'])['username'] ?? null;
                        $authorDisplayname = $user->get('display_name', $post['author'])['display_name'] ?? null;
                    ?>
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
                                    <li>
                                        <a href="<?= $config->site->url ?>/blog/author/<?= $authorUsername ?>/">
                                            <i class="far fa-user-circle"></i> 
                                            <?= $authorDisplayname ?>
                                        </a>
                                    </li>
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
                                    $prev_link = ($currentPage > 1) ? $config->site->url . "/blog/category/{$categorySlug}/page/" . ($currentPage - 1) : null;
                                    $next_link = ($currentPage < $totalPages) ? $config->site->url . "/blog/category/{$categorySlug}/page/" . ($currentPage + 1) : null;
                                    ?>
                                    <li class="page-item <?= is_null($prev_link) ? 'disabled' : '' ?>">
                                        <a href="<?= $prev_link ?>" class="page-link rounded">←</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) :?>
                                        <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                                            <a href="<?= $config->site->url . '/blog/category/' . $categorySlug . '/page/' . $i . '/' ?>" class="page-link rounded"><?= $i ?></a>
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