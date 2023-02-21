<?php
$errors = sessionGetFlashValue('errors', []);
$oldData = sessionGetFlashValue('old_data', []);
?>

<section>
    <div class="section__header">
        <h1>Registrarse</h1>
    </div>

    <div class="section__content section__content--centered">
        <form class="card login" action="actions/sign-up.php" method="POST">
            <h2>Registrarse</h2>

            <div class="login__form-group login__form-group--sign-up">
                <label for="name">Nombre</label>
                <input class="login__input" type="text" id="name" name="name" placeholder="Nombre" value="<?= $oldData['name'] ?? ''; ?>">
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
                <input class="login__input" type="text" id="username" name="username" placeholder="Usuario" value="<?= $oldData['username'] ?? ''; ?>">
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
                <label for="email">Email</label>
                <input class="login__input" type="email" id="email" name="email" placeholder="Email" value="<?= $oldData['email'] ?? ''; ?>">
                <div class="login__input-error">
                    <?php
                    if (isset($errors['email'])) :
                    ?>
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div class="login__input-error-tooltip">
                            <span><?= $errors['email'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="login__form-group login__form-group--sign-up">
                <label for="password">Contraseña</label>
                <input class="login__input" type="password" id="password" name="password" placeholder="Contraseña">
                <div class="login__input-error">
                    <?php
                    if (isset($errors['password'])) :
                    ?>
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div class="login__input-error-tooltip">
                            <span><?= $errors['password'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="login__form-group login__form-group--sign-up">
                <label for="birthdate">Fecha de nacimiento</label>
                <input class="login__input" type="date" id="birthdate" name="birthdate">
                <div class="login__input-error">
                    <?php
                    if (isset($errors['birthdate'])) :
                    ?>
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div class="login__input-error-tooltip">
                            <span><?= $errors['birthdate'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="login__form-group login__form-group--sign-up">
                <label for="location">Ubicación</label>
                <input class="login__input" type="text" id="location" name="location" placeholder="Ubicación" value="<?= $oldData['location'] ?? ''; ?>">
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
                <textarea class="login__input-textarea" name="biography" id="biography" placeholder="Biografía"><?= $oldData['biography'] ?? ''; ?></textarea>
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

            <button class="button button--white button--form">Registrarse</button>

            <p>¿Ya tienes una cuenta? <a href="index.php?s=login">Iniciar sesión</a></p>

        </form>
    </div>
</section>