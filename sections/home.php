<?php
require './libraries/posts.php';
require './libraries/comments.php';

$posts = getAllPosts($db);

?>

<section>
    <div class="section__header">
        <h1>Home</h1>
    </div>

    <div class="section__content">
        <?php
        if (!$posts) : ?>
            <div class="unavailable-posts">
                <i class="far fa-frown-open fa-5x"></i>
                <h2>Aún no hay posts disponibles</h2>
                <p>Inténtalo de nuevo más tarde.</p>
            </div>
        <?php
        else : ?>
            <?php
            foreach ($posts as $post) :
            ?>
                <div class="card post">
                    <div class="post__content">
                        <div class="post__content__post-data">
                            <div class="profile-picture">
                                <img src="img/<?= getUserById($db, $post['id_user'])['profile_picture'] ?>" alt="<?= htmlspecialchars(getUserById($db, $post['id_user'])['profile_picture_alt']); ?>">
                            </div>

                            <div class="post__likes">
                                <span>99</span>
                                <i class="fa-solid fa-heart"></i>
                            </div>
                        </div>

                        <div class="post__content__main">
                            <div class="post__user-data">
                                <a href="index.php?s=profile">
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
                            if (authIsAutenticated()) : ?>
                                <div class="post__content__dropdown">
                                    <button onclick="displayDropdown(<?= $post['id_post']; ?>)" class="post__content__dropdown-button"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <div id="dropdown-<?= $post['id_post']; ?>" class="post__content__dropdown-content">
                                        <a href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="actions/post-delete.php?id=<?= $post['id_post']; ?>"><i class="fa-solid fa-trash"></i></a>
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
                                <a href="index.php?s=profile">
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