<?php
require './libraries/posts.php';

$id_post = $_GET['id_post'];
$id = $_GET['id'];
$s = $_GET['redirect'];

if (authIsAutenticated()) {
    $id_user = authGetUser()['id_user'];
}

$post = getPostById($db, $id_post);
?>

<section>
    <div class="section__header">
        <h1>Editar post</h1>
    </div>

    <div class="section__content">
        <?php
        if (authIsAutenticated()) : ?>
            <form class="card new-post" action="actions/post-edit.php?id_user=<?= $id_user ?>&id_post=<?= $id_post ?>&s=<?= $s ?>&id=<?= $id ?>" method="POST">
                <div class="new-post__column new-post__column--profile-picture">
                    <a href="index.php?s=profile&id=<?= $id_user ?>">
                        <div class="profile-picture">
                            <img src="img/<?= getUserById($db, $id_user)['profile_picture'] ?>" alt="<?= htmlspecialchars(getUserById($db, $id_user)['profile_picture_alt']); ?>">
                        </div>
                    </a>
                </div>

                <div class="new-post__column new-post__column--form">
                    <div class="new-post__row">
                        <div class="new-post__select-wrapper">
                            <select name="type" id="type" class="new-post__select" default="<?= $post['type'] ?? ''; ?>">
                                <option selected="<?= $post['type'] === "Film" ? true : false; ?>" value="Film">Película</option>
                                <option selected="<?= $post['type'] === "Serie" ? true : false; ?>" value="Serie">Serie</option>
                                <option selected="<?= $post['type'] === "Book" ? true : false; ?>" value="Book">Libro</option>
                                <option selected="<?= $post['type'] === "Game" ? true : false; ?>" value="Game">Juego</option>
                            </select>
                        </div>

                        <fieldset class="new-post__star-rating">
                            <input type="radio" value="5" id="stars-star5" name="rating" checked="<?= $post['rating'] === "5" ? true : false; ?>">
                            <label for="stars-star5" title="5 Estrellas"></label>
                            <input type="radio" value="4" id="stars-star4" name="rating" checked="<?= $post['rating'] === "4" ? true : false; ?>">
                            <label for="stars-star4" title="4 Estrellas"></label>
                            <input type="radio" value="3" id="stars-star3" name="rating" checked="<?= $post['rating'] === "3" ? true : false; ?>">
                            <label for="stars-star3" title="3 Estrellas"></label>
                            <input type="radio" value="2" id="stars-star2" name="rating" checked="<?= $post['rating'] === "2" ? true : false; ?>">
                            <label for="stars-star2" title="2 Estrellas"></label>
                            <input type="radio" value="1" id="stars-star1" name="rating" checked="<?= $post['rating'] === "1" ? true : false; ?>">
                            <label for="stars-star1" title="1 Estrellas"></label>
                        </fieldset>
                    </div>

                    <input id="new-post__title" class="new-post__title" type="text" name="title" placeholder="Title" value="<?= $post['title'] ?? ''; ?>" />

                    <textarea id="new-post__content" name="content" class="new-post__post-box" rows="4" placeholder="Post something..."><?= $post['content'] ?? ''; ?></textarea>

                    <div class="new-post__actions">
                        <label class="new-post__file">
                            <input type="file" />
                            <i class="fa-solid fa-image"></i>
                        </label>

                        <button id="new-post__button" class="button button--white">Post</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>