<?php 

require_once __DIR__ . '/bootstrap.php';

$page = 'events';

include __DIR__ . '/includes/header.php'; ?>
<style> 
.events-one__img {
    height: 396px;
    width: 100%;
    background-repeat: no-repeat;
    background-size: cover;
}
.event-overlay {
    background: linear-gradient(transparent, rgba(0, 0, 0, 1));
    position: absolute;
    width: 100%;
    height: 200px;
    bottom: 0;
}
.events-one__date-box {
    left: 0px;
    height: 60px;
    width: 120px;
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
            <div class="page-header__bg"
                style="background-image: url(<?= $config->site->url ?>/assets/images/Eventback.png);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Events</h2>
               
            </div>
        </section>
        <!--Page Header End-->

        <!--Events Page Start-->
        <section class="events-page">
            <div class="container">
                <div class="row">
                <?php 
                    $event = new Core\Models\Event($connection);

                    $limit = 6;
                    $totalPosts = $event->count()['count'];
                    $totalPages = ceil($totalPosts / $limit);
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $limit;

                    $events = Atlas\Query\Select::new($connection)
                            ->columns('title, image, link, event_date')
                            ->from('events')
                            ->limit($limit)
                            ->offset($offset)
                            ->orderBy('event_date DESC')
                            ->fetchAll();

                    if ($totalPosts == 0) : ?>

                    <p>No events yet!</p>

                    <?php 
                    endif;
                    foreach ($events as $event) : ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!--Events One Single-->
                        <div class="events-one__single">
                            <div class="events-one__img" style="background-image: url(<?= $config->site->url ?>/public/uploads/events/<?= $event['image'] ?>)">
                                <div class="event-overlay"></div>
                                <div class="events-one__date-box">
                                    <p><?= Carbon\Carbon::parse($event['event_date'])->format('d M, Y') ?></p>
                                </div>
                                <div class="events-one__bottom">
                                    <p><i class="far fa-clock"></i><?= Carbon\Carbon::parse($event['event_date'])->format('h:i a') ?></p>
                                    <h3 class="events-one__bottom-title"><a rel="nofollow" target="_blank" href="<?= $event['link'] ?>"><?= $event['title'] ?></a></h3>
                                </div>
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
                                    $prev_link = ($currentPage > 1) ? $config->site->url . "/events/page/" . ($currentPage - 1) : null;
                                    $next_link = ($currentPage < $totalPages) ? $config->site->url . "/events/page/" . ($currentPage + 1) : null;
                                    ?>
                                    <li class="page-item <?= is_null($prev_link) ? 'disabled' : '' ?>">
                                        <a href="<?= $prev_link ?>" class="page-link rounded">←</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) :?>
                                        <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                                            <a href="<?= $config->site->url . '/events/page/' . $i . '/' ?>" class="page-link rounded"><?= $i ?></a>
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
        <!--Events Page End-->

        <?php include __DIR__ . '/includes/footer.php';