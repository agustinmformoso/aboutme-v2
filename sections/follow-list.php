<?php
require './libraries/followers.php';

$id = $_GET['id'];
$section = $_GET['s'];
$active = $_GET['active'];

$user = getUserById($db, $id);

if ($active === 'followers') {
    $userList = getFollowersById($db, $id);
    $userId = 'id_follower';
} else {
    $userList = getFollowingById($db, $id);
    $userId = 'id_user';
}

?>

<section>
    <div class="section__header">
        <h1><?= $user['name']; ?></h1>
    </div>

    <div class="section__content section__content--centered">
        <div class="card follow-list">
            <div class="follow-list__header">
                <a class="follow-list__link" href="index.php?s=follow-list&id=<?= $id ?>&active=followers">
                    <div class="follow-list__heading <?= $active === 'followers' ? 'follow-list__heading--active' : '' ?>">
                        <h2>Seguidores</h2>
                    </div>
                </a>

                <a class="follow-list__link" href="index.php?s=follow-list&id=<?= $id ?>&active=following">
                    <div class="follow-list__heading <?= $active === 'following' ? 'follow-list__heading--active' : '' ?>">
                        <h2>Siguiendo</h2>
                    </div>
                </a>
            </div>
            <div class="follow-list__body">
                <?php
                if ($userList) {
                    foreach ($userList as $follower) :
                ?>
                        <a class="follow-list__link" href="index.php?s=profile&id=<?= $follower[$userId]; ?>">
                            <div class="follow-list__user">
                                <div class="navbar__profile-picture follow-list__user__image">
                                    <img src="img/<?= getUserById($db, $follower[$userId])['profile_picture']; ?>" alt="<?= getUserById($db, $follower[$userId])['profile_picture_alt']; ?>" />
                                </div>
                                <div>
                                    <p class="follow-list__user__username"><?= htmlspecialchars(getUserById($db, $follower[$userId])['username']); ?></p>
                                    <p class="follow-list__user__biography"><?= htmlspecialchars(getUserById($db, $follower[$userId])['biography']); ?></p>
                                </div>
                            </div>
                        </a>
                    <?php
                    endforeach;
                } else { ?>
                    <div class="no-follow-list">
                        <i class="far fa-frown-open fa-5x"></i>

                        <?php if ($active === 'followers') { ?>
                            <h3>No se encontraron seguidores</h3>
                            <p>Cuando alguien siga esta cuenta, aparecerá aquí. Postear e interactuar con otros ayuda a aplicarle un boost al número de seguidores.</p>
                        <?php } else { ?>
                            <h3><?= $user['name']; ?> no sigue a nadie</h3>
                            <p>Cuando siga alguna cuenta, la cuenta aparecerá aquí.</p>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>