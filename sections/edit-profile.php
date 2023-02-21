<?php
$id_user = authGetUser()['id_user'];
$user = getUserById($db, $id_user);
?>

<section>
    <div class="section__header">
        <h1><?= $user['name']; ?></h1>
    </div>

    <div class="section__content">
        <form class="card profile profile--edit" action="actions/edit-profile.php?id_user=<?= $id_user ?>" method="POST">
            <div class="profile__header profile__header--edit" style="background-image: url(img/<?= $user['banner_picture']; ?>)">
                <label class="profile__edit-file">
                    <input type="file" />
                    <i class="fa-solid fa-image"></i>
                </label>
            </div>

            <div class="profile__body profile__body--edit">
                <div class="profile__stats">
                    <div class="profile__profile-picture profile__profile-picture--edit" style="background-image: url(img/<?= $user['profile_picture']; ?>)">
                        <label class="profile__edit-file">
                            <input type="file" />
                            <i class="fa-solid fa-image"></i>
                        </label>
                    </div>
                </div>

                <div class="login__form-group login__form-group--sign-up">
                    <label for="name">Nombre</label>
                    <input class="login__input" type="text" id="name" name="name" placeholder="Nombre" value="<?= $user['name'] ?? ''; ?>">
                    <div class="login__input-error">
                        <?php
                        if (isset($errors['name'])) :
                        ?>
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <div class="login__input-error-tooltip">
                                <span><?= $errors['name'] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="login__form-group login__form-group--sign-up">
                    <label for="username">Usuario</label>
                    <input class="login__input" type="text" id="username" name="username" placeholder="Usuario" value="<?= $user['username'] ?? ''; ?>">
                    <div class="login__input-error">
                        <?php
                        if (isset($errors['username'])) :
                        ?>
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <div class="login__input-error-tooltip">
                                <span><?= $errors['username'] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="login__form-group login__form-group--sign-up">
                    <label for="location">Ubicación</label>
                    <input class="login__input" type="text" id="location" name="location" placeholder="Ubicación" value="<?= $user['location'] ?? ''; ?>">
                    <div class="login__input-error">
                        <?php
                        if (isset($errors['location'])) :
                        ?>
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <div class="login__input-error-tooltip">
                                <span><?= $errors['location'] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="login__form-group">
                    <label for="biography">Biografía</label>
                    <textarea class="login__input-textarea" name="biography" id="biography" placeholder="Biografía"><?= $user['biography'] ?? ''; ?></textarea>
                    <div class="login__input-error">
                        <?php
                        if (isset($errors['biography'])) :
                        ?>
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <div class="login__input-error-tooltip">
                                <span><?= $errors['biography'] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <button class="button button--black button--form">Editar</button>
            </div>
        </form>
    </div>
</section>