<?php
$oldData = sessionGetFlashValue('old_data', []);
?>

<section>
    <div class="section__header">
        <h1>Recupera tu cuenta</h1>
    </div>

    <div class="section__content section__content--centered">
        <form class="card login" action="actions/password-reset.php" method="POST">
            <h2>Recupera tu cuenta</h2>

            <p class="login__caption">Introduce el correo electrónico asociado a tu cuenta para cambiar tu contraseña.</p>

            <div class="login__form-group">
                <label for="email">Email</label>
                <input class="login__input" type="email" id="email" name="email" placeholder="Email" value="<?= $oldData['email'] ?? ''; ?>">
            </div>

            <button class="button button--white button--form">Continuar</button>
        </form>
    </div>
</section>