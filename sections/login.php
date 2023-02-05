<?php
?>

<section>
    <div class="section__header">
        <h1>Iniciar sesión</h1>
    </div>

    <div class="section__content section__content--centered">
        <form class="card login" action="actions/login.php" method="POST">
            <h2>Iniciar sesión</h2>

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

            <p><a href="index.php?s=password-reset">¿Olvidaste tu contraseña?</a>.</p>
            <p>¿No tienes una cuenta? <a href="index.php?s=sign-up">Regístrate!</a></p>
        </form>
    </div>
</section>