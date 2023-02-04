<?php
?>

<section>
    <div class="section__header">
        <h1>Recupera tu cuenta</h1>
    </div>

    <div class="section__content section__content--centered">
        <form class="card login" action="actions/password-reset.php" method="POST">
            <h2>Recupera tu cuenta</h2>

            <p>Introduce el correo electrónico asociado a tu cuenta para cambiar tu contraseña.</p>

            <div class="login__form-group">
                <label for="email">Email</label>
                <input class="login__input" type="email" id="email" name="email" placeholder="Email" value="<?= $oldData['email'] ?? ''; ?>">
                <?php
                if (isset($errors['email'])) : ?>
                    <div class="login__error" id="error-email"><?= $errors['email']; ?></div>
                <?php
                endif; ?>
            </div>

            <button class="button login__button">Continuar</button>
        </form>
    </div>
</section>