<?php
?>

<section>
    <div class="section__header">
        <h1>Nueva contraseña</h1>
    </div>

    <div class="section__content section__content--centered">
        <form class="card login" action="actions/new-password.php" method="POST">
            <h2>Nueva contraseña</h2>

            <p class="login__caption">Asegúrate de que tu contraseña tenga 8 caracteres o más. Intenta que incluya números, letras y signos de puntuación para que sea una contraseña segura. </p>

            <input type="hidden" name="token" value="<?= $_GET['token']; ?>">
            <input type="hidden" name="email" value="<?= $_GET['email']; ?>">

            <div class="login__form-group">
                <label for="password">Contraseña</label>
                <input class="login__input" type="password" id="password" name="password" placeholder="Contraseña">
            </div>

            <button class="button login__button">Continuar</button>
        </form>
    </div>
</section>