<?php

use Core\Utility;

require_once __DIR__ . '/bootstrap.php';

$page = 'blog';

$slug = $_GET['slug'] ?? null;

$postCategory = new Core\Models\PostCategory($connection);
$postTag = new Core\Models\PostTag($connection);
$tag = new Core\Models\Tag($connection);
$postClass = new Core\Models\Post($connection, $postCategory, $postTag, $tag);
$comment = new Core\Models\Comment($connection);
$user = new Core\Models\User($connection);

if (empty($postClass->getAll('id', ['where' => ['slug' => $slug]]))) {
    $flash->set('error', 'The content you are looking for can not be found');
    Utility::redirect($config->site->url . '/blog/');
}

$postId = $postClass->getAll('id', ['where' => ['slug' => $slug]])[0]['id'];

include __DIR__ . '/includes/header.php'; ?>
<style> 
label.error {
    float: right;
    margin-top: 4px;
    color: #c87070;
    /* position: absolute; */
    font-size: 14px;
}
#comment-error {
    margin-top: 14px;
}
.comment-one__content {
    width: 100%;
}
.comment-one__content {
    padding-right: 0;
}

.cancel-reply-wrapper {
    margin-left: 12px;
    font-size: 20px;
    font-weight: normal;
    text-decoration: underline;
}
</style>

       <!--Page Header Start-->
       <section class="page-header">
            <div class="page-header__bg" style="background-image: url(<?= $config->site->url ?>/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2><?= Utility::escape($postClass->get('title', $postId)['title']) ?></h2>
            </div>
        </section>
        <!--Page Header End-->

        <!--News Details Start-->
        <section class="news-details">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="news-details__left">
                            <?php if (!empty($postClass->get('featured_image', $postId))) : ?>
                                <div class="news-details__img">
                                    <img src="<?= $config->site->url ?>/public/uploads/posts/featured-images/<?= $postClass->get('featured_image', $postId)['featured_image'] ?>" alt="">
                                </div>
                            <?php endif; ?>
                            <div class="news-details__content">
                                <ul class="list-unstyled news-details__meta">
                                    <li><a href="<?= $config->site->url ?>/blog/author/<?= Utility::escape($user->get('username', $postClass->get('author', $postId))['username']) ?>/"><i class="far fa-user-circle"></i> by <?= $user->get('display_name', $postClass->get('author', $postId))['display_name'] ?> </a></li>
                                    <li><span>/</span></li>
                                    <li><a href="#comments"><i class="far fa-comments"></i> <?= $comment->count(['post_id' => $postId])['count'] ?> Comments</a>
                                    </li>
                                </ul>
                                <h3 class="news-details__title"><?= Utility::escape($postClass->get('title', $postId)['title']) ?></h3>
                                <p class="news-details__text-one"><?= $postClass->get('content', $postId)['content'] ?></p>
                            </div>
                            <div class="news-details__bottom">
                                <p class="news-details__tags">
                                    <span>Tags:</span>
                                    <a href="news-details.html#">Donation</a>
                                    <a href="news-details.html#">Charity</a>
                                    <a href="news-details.html#">Poor</a>
                                </p>
                                <div class="news-details__social-list">
                                    <a href="news-details.html#"><i class="fab fa-twitter"></i></a>
                                    <a href="news-details.html#"><i class="fab fa-facebook-square"></i></a>
                                    <a href="news-details.html#"><i class="fab fa-dribbble"></i></a>
                                    <a href="news-details.html#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="author-one">
                                <div class="author-one__image">
                                    <img src="<?= $user->getAvatar($postClass->get('author', $postId)) ?>" alt="">
                                </div>
                                <div class="author-one__content">
                                    <h3><?= $user->get('display_name', $postClass->get('author', $postId))['display_name'] ?></h3>
                                    <p><?= $user->get('bio', $postClass->get('author', $postId))['bio'] ?></p>
                                </div>
                            </div>
                             <div class="comment-one" id="comments">
                                <?php 
                                $comments = Atlas\Query\Select::new($connection)
                                ->columns(
                                    "p.id AS postId",
                                    "c.id AS comment_id",
                                    "c.parent AS parent_id",
                                    "u.id AS user_id",
                                    "c.content AS comment",
                                    "c.created_at AS date",
                                    "COALESCE(u.email, c.author_email) AS email",
                                    "COALESCE(u.website, c.author_website) AS website",
                                    "CASE 
                                        WHEN c.user_id = 0 THEN c.author_name
                                        ELSE u.display_name
                                    END AS author",
                                    "CASE 
                                        WHEN c.parent = 0 THEN NULL
                                        ELSE 
                                            CASE 
                                                WHEN pc.user_id = 0 THEN pc.author_name
                                                ELSE pu.display_name
                                            END
                                    END AS in_reply_to"
                                )
                                ->from("comments c")
                                ->join("LEFT", "users u", "c.user_id = u.id")
                                ->join("", "posts p", "c.post_id = p.id")
                                ->join("LEFT", "comments pc", "c.parent = pc.id")
                                ->join("LEFT", "users pu", "pc.user_id = pu.id")
                                ->whereSprintf("c.post_id = {$postId} AND c.status = 'APPROVED'")
                                ->fetchAll();

                                if (!empty($comments)) : ?>

                                <h3 class="comment-one__title">Comments</h3>
                                
                                <?php 
                                endif;
                                foreach ($comments as $c) : ?>
                                
                                <div class="comment-one__single" id="comment-<?= $c['comment_id'] ?>">
                                    <div class="comment-one__image">
                                        <img src="<?= $user->getAvatar($c['user_id'], $c['email']) ?>" alt="">
                                    </div>
                                    <div class="comment-one__content">
                                        <h3><?= $c['author'] ?> <span><?= Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $c['date'])->diffForHumans() ?></span></h3>
                                        <p><?= $c['comment'] ?></p>

                                        <!-- <a rel="nofollow" class="reply-to-comment mt-4 d-block" href="?replyto=<?= $c['comment_id'] ?>#comment_box" data-commentid="<?= $c['comment_id'] ?>" data-postid="<?= $postId ?>" data-belowelement="comment-<?= $c['comment_id'] ?>" data-respondelement="comment_box" data-replyto="Reply to <?= $c['author'] ?>" aria-label="Reply to <?= $c['author'] ?>"><i class="fas fa-arrow-circle-right"></i> Reply</a> -->
                                    </div>
                                </div>

                                <?php endforeach;

                                if ($flash->has('pending_comment')) : $commentContent = $flash->get('pending_comment'); ?>
                                    <div class="comment-one__single" id="comment-<?= $commentContent['comment_id'] ?>">
                                        <div class="comment-one__image">
                                            <img src="<?= $user->getAvatar($currentUserId, $commentContent['email']) ?>" alt="">
                                        </div>
                                        <div class="comment-one__content">
                                        <h3><?= $commentContent['name'] ?> <span><?= Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $commentContent['date'])->diffForHumans() ?></span></h3>
                                            <p><?= $commentContent['comment'] ?></p>
                                            <p class="alert alert-info mt-3"><i>Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.</i></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="comment-form" id="comment_box">
                                <?php if ($flash->has('error')) : ?>
                                    <div class="alert alert-danger"><?= $flash->get('error') ?></div>
                                <?php endif; ?>
                                <h3 id="comment_box_title" class="comment-form__title">Leave a Comment</h3>
                                <?php if ($auth->isLogged()) : ?>
                                    <Required>Signed in as <?= $user->get('display_name', $currentUserId)['display_name'] ?>. <a href="<?= $config->site->url ?>/bms/users/profile/" style="color: var(--thm-primary);">Edit Profile.</></a> <a href="<?= $config->site->url ?>/bms/http/auth/sign-out/?ref=<?= urlencode($_SERVER['REQUEST_URI']) ?>" style="color: var(--thm-primary);">Sign Out?</a> Required fields are marked *</p>
                                <?php else : ?>
                                    <p>Your email address will not be published. Required fields are marked *</p>
                                <?php endif ?>
                                <form method="post" action="<?= $config->site->url ?>/bms/http/comments/new/" class="comment-one__form">
                                    <input type="hidden" name="post_id" value="<?= $postId ?>">
                                    <input type="hidden" name="user_id" value="<?= $currentUserId ?>">
                                    <input type="hidden" name="post_slug" value="<?= $slug ?>">

                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box">
                                                <label for="comment_textarea" class="form-label mb-3">Comment: *</label>
                                                <textarea id="comment_textarea" name="comment" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (!$auth->isLogged()) : ?>
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box">
                                                <label for="name" class="form-label mb-3">Name: *</label>
                                                <input type="text" id="name" name="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box">
                                                <label for="email" class="form-label mb-3">Email: *</label>
                                                <input type="email" id="email" name="email" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box">
                                                <label for="website" class="form-label mb-3">Website:</label>
                                                <input type="text" id="website" name="website">
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <input type="hidden" name="parent" id="comment_id_input">
                                            <button type="submit" class="thm-btn comment-form__btn"><i class="fas fa-arrow-circle-right"></i>Submit Comment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="sidebar">
                            <div class="sidebar__single sidebar__search">
                                <form action="news-details.html#" class="sidebar__search-form">
                                    <input type="search" placeholder="Search">
                                    <button type="submit"><i class="icon-magnifying-glass"></i></button>
                                </form>
                            </div>
                            <div class="sidebar__single sidebar__post">
                                <h3 class="sidebar__title">Recent Posts</h3>
                                <ul class="sidebar__post-list list-unstyled">
                                    <li>
                                        <div class="sidebar__post-image">
                                            <img src="assets/images/blog/lp-1-1.jpg" alt="">
                                        </div>
                                        <div class="sidebar__post-content">
                                            <h3>
                                                <a href="news-details.html#" class="sidebar__post-content_meta"><i class="far fa-user-circle"></i>by Admin</a>
                                                <a href="news-details.html">Help Children Rise out of Poverty</a>
                                            </h3>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar__post-image">
                                            <img src="assets/images/blog/lp-1-2.jpg" alt="">
                                        </div>
                                        <div class="sidebar__post-content">
                                            <h3>
                                                <a href="news-details.html#" class="sidebar__post-content_meta"><i class="far fa-user-circle"></i>by Admin</a>
                                                <a href="news-details.html">Help Children Rise out of Poverty</a>
                                            </h3>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar__post-image">
                                            <img src="assets/images/blog/lp-1-3.jpg" alt="">
                                        </div>
                                        <div class="sidebar__post-content">
                                            <h3>
                                                <a href="news-details.html#" class="sidebar__post-content_meta"><i class="far fa-user-circle"></i>by Admin</a>
                                                <a href="news-details.html">Help Children Rise out of Poverty</a>
                                            </h3>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="sidebar__single sidebar__category">
                                <h3 class="sidebar__title">Categories</h3>
                                <ul class="sidebar__category-list list-unstyled">
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Charity</a></li>
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Fundrising</a></li>
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Donations</a></li>
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Save Lifes</a></li>
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Health</a></li>
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Education</a></li>
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Food</a></li>
                                    <li><a href="news-details.html#"><i class="fas fa-arrow-circle-right"></i>Water</a></li>
                                </ul>
                            </div>
                            <div class="sidebar__single sidebar__tags">
                                <h3 class="sidebar__title">Popular Tags</h3>
                                <div class="sidebar__tags-list">
                                    <a href="news-details.html#">Donation</a>
                                    <a href="news-details.html#">Charity</a>
                                    <a href="news-details.html#">Poor</a>
                                    <a href="news-details.html#">Education</a>
                                    <a href="news-details.html#">Fundraising</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script> 
       window.addEventListener('DOMContentLoaded', function() {
  // Check if the URL contains a hash (i.e., an anchor)
  var hash = window.location.hash;
  if (hash && document.querySelector(hash)) {
    // Wait for the page to load and then scroll to the anchor
    window.addEventListener('load', function() {
      var target = document.querySelector(hash);
      var offsetTop = target.getBoundingClientRect().top + window.pageYOffset;
      window.scrollTo({
        top: offsetTop - 120,
        behavior: 'smooth'
      });
    });
  }
  
  // Attach click event listeners to all anchor tags on the page
  var links = document.querySelectorAll('a[href^="#"]');
  links.forEach(function(link) {
    link.addEventListener('click', function(event) {
      event.preventDefault();
      var hash = this.getAttribute('href');
      if (hash && document.querySelector(hash)) {
        var target = document.querySelector(hash);
        var offsetTop = target.getBoundingClientRect().top + window.pageYOffset;
        window.scrollTo({
          top: offsetTop - 120,
          behavior: 'smooth'
        });
        // Update the URL to include the hash
        history.pushState(null, null, hash);
      }
    });
  });
});

// wait for the document to be ready
document.addEventListener("DOMContentLoaded", function() {
  // select all links with the class 'comment-reply-link'
  var links = document.querySelectorAll(".reply-to-comment");
  
  // add a click event listener to each link
  links.forEach(function(link) {
    link.addEventListener("click", function(event) {
      // prevent the default behavior of the link
      event.preventDefault();

      // focus on the comment textarea
      document.getElementById("comment_textarea").focus();
      
      // change the text on the comment section h3
      var replyTo = link.getAttribute("data-replyto");
      var commentSectionH3 = document.getElementById("comment_box_title")
      commentSectionH3.innerText = replyTo;

      // create a 'cancel reply' link
      var cancelReplyLink = document.createElement("a");
      cancelReplyLink.innerText = "Cancel reply";
      cancelReplyLink.href = "#";
      cancelReplyLink.classList.add("cancel-reply-link"); // add a CSS class to the link
      
      var cancelReplyWrapper = document.createElement("span"); // wrap the link in a span element
      cancelReplyWrapper.classList.add("cancel-reply-wrapper"); // add a CSS class to the span element
      cancelReplyWrapper.appendChild(cancelReplyLink); // append the link to the span element
      
      cancelReplyLink.addEventListener("click", function(event) {
        event.preventDefault();

        // reset the comment section h3 and the comment ID input value
        commentSectionH3.innerText = "Leave a Comment";
        document.getElementById("comment_id_input").value = "";

        // remove the 'cancel reply' link
        this.parentNode.removeChild(this);
      });

      // append the 'cancel reply' link next to the 'Reply to' text
      commentSectionH3.insertBefore(cancelReplyWrapper, commentSectionH3.childNodes[1]);

      // get the comment ID from the URL
      var urlParams = new URLSearchParams(link.search);
      var commentId = urlParams.get("replyto");

      // set the comment ID in the value of a hidden input in the comment form
      document.getElementById("comment_id_input").value = commentId;
    });
  });
});


        </script>
        <!--News Details End-->
        <?php include __DIR__ . '/includes/footer.php';