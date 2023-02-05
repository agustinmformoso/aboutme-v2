<?php
?>

<section>
    <div class="section__header">
        <h1>Registrarse</h1>
    </div>

    <div class="section__content section__content--centered">
        <form class="card login" action="" method="POST">
            <h2>Registrarse</h2>

            <div class="login__form-group">
                <label for="email">Email</label>
                <input class="login__input" type="email" id="email" name="email" placeholder="Email" value="<?= $oldData['email'] ?? ''; ?>">
                <?php
                if (isset($errors['email'])) : ?>
                    <div class="login__error" id="error-email"><?= $errors['email']; ?></div>
                <?php
                endif; ?>
            </div>

            <div class="login__form-group">
                <label for="password">Contraseña</label>
                <input class="login__input" type="password" id="password" name="password" placeholder="Contraseña">
            </div>

            <button class="button login__button">Iniciar sesión</button>

            <p>¿Ya tienes una cuenta? <a href="index.php?s=login">Iniciar sesión</a></p>

        </form>
    </div>
</section>