<?php
require './libraries/posts.php';
require './libraries/comments.php';
require './libraries/followers.php';
require './libraries/likes.php';

$id = $_GET['id'];

if (authIsAutenticated()) {
    $id_user = authGetUser()['id_user'];
}

$user = getUserById($db, $id);
$liked_posts = getUserLikedPosts($db, $id);
?>

<section>
    <div class="section__header">
        <h1><?= $user['name']; ?></h1>
    </div>

    <div class="section__content section__content--centered">
        <?php
        if (!$liked_posts) : ?>
            <div class="unavailable-posts">
                <i class="far fa-frown-open fa-5x"></i>
                <h2>Aún no hay posts disponibles</h2>
                <p>Inténtalo de nuevo más tarde.</p>
            </div>
        <?php
        else : ?>
            <?php
            foreach (array_reverse($liked_posts) as $post) :
            ?>
                <div class="card post">
                    <div class="post__content">
                        <div class="post__content__post-data">
                            <a href="index.php?s=profile&id=<?= $id ?>">
                                <div class="profile-picture">
                                    <img src="img/<?= getUserById($db, $post['id_user'])['profile_picture'] ?>" alt="<?= htmlspecialchars(getUserById($db, $post['id_user'])['profile_picture_alt']); ?>">
                                </div>
                            </a>

                            <div class="post__likes">
                                <span class="post__likes__number <?= isLiked($db, $id_user, $post['id_post']) ? 'post__likes__number--is-liked' : '' ?>"><?= count(likesGetById($db, $post['id_post'])) ?></span>

                                <div class="post__likes__icon-wrapper">
                                    <?php
                                    if (authIsAutenticated()) : if (isLiked($db, $id_user, $post['id_post'])) : ?>
                                            <a href="actions/remove-like.php?id_like=<?= isLiked($db, $id_user, $post['id_post'])['id_like'] ?>&id_user=<?= $id_user ?>&s=liked-posts">
                                                <i class="fa-solid fa-heart fa-heart--is-liked"></i>
                                            </a>
                                        <?php else : ?>
                                            <a href="actions/like.php?id_post=<?= $post['id_post'] ?>&id_user=<?= $id_user ?>&s=liked-posts">
                                                <i class="fa-regular fa-heart"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <div>
                                            <i class="fa-regular fa-heart" onclick="unauthorizedModal(<?= authIsAutenticated() ? 'true' : 'false' ?>)"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="post__content__main">
                            <div class="post__user-data">
                                <a href="index.php?s=profile&id=<?= $id ?>">
                                    <p><?= getUserById($db, $post['id_user'])['name'] ?></p>
                                </a>
                                <span>@<?= getUserById($db, $post['id_user'])['username'] ?></span>
                            </div>

                            <div class="post__heading">
                                <div class="post__tag">
                                    <?php
                                    switch ($post['type']) {
                                        case 'Serie':
                                    ?>
                                            <i class="fa-solid fa-film"></i>
                                        <?php
                                            break;
                                        case 'Film':
                                        ?>
                                            <i class="fa-solid fa-film"></i>
                                        <?php
                                            break;
                                        case 'Game':
                                        ?>
                                            <i class="fa-solid fa-gamepad"></i>
                                        <?php
                                            break;
                                        case 'Book':
                                        ?>
                                            <i class="fa-solid fa-book"></i>
                                    <?php
                                            break;
                                    }
                                    ?>
                                </div>

                                <h3><?= htmlspecialchars($post['title']); ?></h3>

                                <div>
                                    <?php
                                    for ($x = 1; $x <= $post['rating']; $x++) {
                                    ?>
                                        <i class="fa-solid fa-star"></i>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    for ($x = 1; $x <= 5 - $post['rating']; $x++) {
                                    ?>
                                        <i class="fa-regular fa-star"></i>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <p><?= htmlspecialchars($post['content']); ?></p>

                            <?php
                            if ($post['image']) : ?>
                                <div class="post__post-photo">
                                    <img src="img/<?= $post['image']; ?>" alt="<?= htmlspecialchars($post['alt_image']); ?>">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="post__content__actions">
                            <?php
                            if (authIsAutenticated() && $id_user === $post['id_user']) : ?>
                                <div class="post__content__dropdown">
                                    <button onclick="displayDropdown(<?= $post['id_post']; ?>)" class="post__content__dropdown-button"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <div id="dropdown-<?= $post['id_post']; ?>" class="post__content__dropdown-content">
                                        <a href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="actions/post-delete.php?id=<?= $post['id_post']; ?>&id_user=<?= $id_user ?>&s=liked-posts"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
                    if (getCommentsById($db, $post['id_post'])) : ?>
                        <div class="post__comment-box">
                            <?php
                            foreach (getCommentsById($db, $post['id_post']) as $comment) :
                            ?>
                                <div class="comment">
                                    <a href="index.php?s=profile&id=<?= $comment['id_user']; ?>">
                                        <p class="comment__user"><?= htmlspecialchars(getUserById($db, $comment['id_user'])['username']); ?></p>
                                    </a>
                                    <p class="comment__text"><?= htmlspecialchars($comment['comment_content']); ?></p>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php
            endforeach;
            ?>
        <?php
        endif; ?>
    </div>
</section>