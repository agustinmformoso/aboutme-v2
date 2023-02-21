<?php
require './libraries/posts.php';
require './libraries/comments.php';
require './libraries/followers.php';
require './libraries/likes.php';

$id = $_GET['id'];

if (authIsAutenticated()) {
    $id_user = authGetUser()['id_user'];
    $is_following = isFollowing($db, authGetUser()['id_user'], $id);
}

$posts = getPostById($db, $id);
$user = getUserById($db, $id);

$followers = count(getFollowersById($db, $id)) ? count(getFollowersById($db, $id)) : '0';
$following = count(getFollowingById($db, $id)) ? count(getFollowingById($db, $id)) : '0';
$likes = count(getUserLikedPosts($db, $id)) ? count(getUserLikedPosts($db, $id)) : '0';

$birthdate = new DateTime($user['birthdate']);
$creation_date = new DateTime($user['creation_date']);
?>

<section>
    <div class="section__header">
        <h1><?= $user['name']; ?></h1>
    </div>

    <div class="section__content">
        <div class="card profile">
            <div class="profile__header" style="background-image: url(img/<?= $user['banner_picture']; ?>)">
            </div>

            <div class="profile__body">
                <div class="profile__stats">
                    <div class="profile__profile-picture">
                        <img src="img/<?= $user['profile_picture'] ?>" alt="<?= $user['profile_picture_alt']; ?>">
                    </div>

                    <div class="profile__account">
                        <p><?= $user['name']; ?></p>
                        <span>@<?= $user['username']; ?></span>
                    </div>

                    <div class="profile__stats__container">
                        <a href="index.php?s=follow-list&id=<?= $id ?>&active=followers">
                            <div class="profile__stats__stat">
                                <span><?= $followers ?></span>
                                <p>Seguidores</p>
                            </div>
                        </a>

                        <a href="index.php?s=follow-list&id=<?= $id ?>&active=following">
                            <div class="profile__stats__stat">
                                <span><?= $following ?></span>
                                <p>Siguiendo</p>
                            </div>
                        </a>

                        <a href="index.php?s=liked-posts&id=<?= $id ?>">
                            <div class="profile__stats__stat">
                                <span><?= $likes ?></span>
                                <p>Me gusta</p>
                            </div>
                        </a>

                        <div class="profile__stats__actions">
                            <?php if (authIsAutenticated()) : if ($id_user === $id) : ?>
                                    <a href="index.php?s=edit-profile" class="button button--white">Editar</a>
                                <?php elseif ($is_following) : ?>
                                    <a href="actions/unfollow.php?id_follower=<?= $id_user ?>&id_user=<?= $id ?>" class="button button--black">Dejar de seguir</a>
                                <?php else : ?>
                                    <a href="actions/follow.php?id_follower=<?= $id_user ?>&id_user=<?= $id ?>" class="button button--white">Seguir</a>
                            <?php endif;
                            endif; ?>
                        </div>
                    </div>
                </div>

                <div class="profile__biography">
                    <p><?= $user['biography']; ?></p>
                </div>

                <div class="profile__user-data">
                    <p><i class="fa-solid fa-location-pin"></i> <?= $user['location']; ?></p>
                    <p><i class="fa-solid fa-cake-candles"></i> Fecha de nacimiento: <?= $birthdate->format('d') . ' de ' ?><?= translateMonth($birthdate->format('F')) . ' de ' . $birthdate->format('Y') ?></p>
                    <p><i class="fa-solid fa-calendar-days"></i> Se unió en <?= translateMonth($creation_date->format('F')) . ' de ' . $creation_date->format('Y') ?></p>
                </div>
            </div>
        </div>

        <?php
        if (authIsAutenticated() && authGetUser()['id_user'] === $id) : ?>
            <form class="card new-post" action="actions/post-create.php?id_user=<?= $id ?>&s=profile" method="POST">
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
                            <select name="type" id="" class="new-post__select">
                                <option value="Film">Film</option>
                                <option value="Serie">Serie</option>
                                <option value="Book">Book</option>
                                <option value="Game">Game</option>
                            </select>
                        </div>

                        <fieldset class="new-post__star-rating">
                            <input type="radio" value="5" id="stars-star5" name="rating">
                            <label for="stars-star5" title="5 Stars"></label>
                            <input type="radio" value="4" id="stars-star4" name="rating">
                            <label for="stars-star4" title="4 Stars"></label>
                            <input type="radio" value="3" id="stars-star3" name="rating">
                            <label for="stars-star3" title="3 Stars"></label>
                            <input type="radio" value="2" id="stars-star2" name="rating">
                            <label for="stars-star2" title="2 Stars"></label>
                            <input type="radio" value="1" id="stars-star1" name="rating">
                            <label for="stars-star1" title="1 Stars"></label>
                        </fieldset>
                    </div>

                    <input id="new-post__title" class="new-post__title" type="text" name="title" placeholder="Title" />

                    <textarea id="new-post__content" name="content" class="new-post__post-box" rows="4" placeholder="Post something..."></textarea>

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
            foreach (array_reverse($posts) as $post) :
            ?>
                <div class="card post">
                    <div class="post__content">
                        <div class="post__content__post-data">
                            <a href="index.php?s=profile&id=<?= $id ?>">
                                <div class="profile-picture">
                                    <img src="img/<?= $user['profile_picture'] ?>" alt="<?= htmlspecialchars($user['profile_picture_alt']); ?>">
                                </div>
                            </a>

                            <div class="post__likes">
                                <span class="post__likes__number <?= isLiked($db, $id_user, $post['id_post']) ? 'post__likes__number--is-liked' : '' ?>"><?= count(likesGetById($db, $post['id_post'])) ?></span>

                                <div class="post__likes__icon-wrapper">
                                    <?php
                                    if (authIsAutenticated()) : if (isLiked($db, $id_user, $post['id_post'])) : ?>
                                            <a href="actions/remove-like.php?id_like=<?= isLiked($db, $id_user, $post['id_post'])['id_like'] ?>&id_user=<?= $id_user ?>&s=profile">
                                                <i class="fa-solid fa-heart fa-heart--is-liked"></i>
                                            </a>
                                        <?php else : ?>
                                            <a href="actions/like.php?id_post=<?= $post['id_post'] ?>&id_user=<?= $id_user ?>&s=profile">
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
                                    <p><?= $user['name'] ?></p>
                                </a>
                                <span>@<?= $user['username'] ?></span>
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
                                        <a href="actions/post-delete.php?id=<?= $post['id_post']; ?>&id_user=<?= $id_user ?>&s=profile"><i class="fa-solid fa-trash"></i></a>
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

                                    <?php
                                    if (authIsAutenticated() && $id_user === $comment['id_user']) : ?>
                                        <a class="comment__delete" href="actions/delete-comment.php?id_user=<?= $id_user ?>&id_comment=<?= $comment['id_comment'] ?>&id=<?= $id ?>&s=profile">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>

                    <form class="comment" action="actions/create-comment.php?id_user=<?= $id_user ?>&id_post=<?= $post['id_post'] ?>&s=profile&id=<?= $id ?>" method="POST">
                        <div class="login__form-group login__form-group--comment">
                            <label for="comment">Comentario</label>
                            <input class="login__input" type="text" id="comment" name="comment" placeholder="Añade un comentario...">
                        </div>
                    </form>
                </div>
            <?php
            endforeach;
            ?>
        <?php
        endif; ?>
    </div>
</section>