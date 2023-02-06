<?php
require 'data/bootstrap.php';
require 'data/routes.php';

$section = $_GET['s'] ?? "home";

if (!isset($sections[$section])) {
    $section = 404;
}

if ($environmentState === ENVIRONMENT_MAINTENANCE) {
    $section = "maintenance";
}

$title = $sections[$section]['title'];

$statusSuccess  = sessionGetFlashValue('status_success');
$statusError    = sessionGetFlashValue('status_error');
$statusInfo     = sessionGetFlashValue('status_info');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title; ?></title>

    <link rel="stylesheet" href="css/styles.css">

    <script src="https://kit.fontawesome.com/9939576bbf.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar">
        <ul class="navbar__ul">
            <li class="navbar__li"><a href="index.php?s=home"><i class="fa-solid fa-house fa-xl navbar__icon"></i></a></li>

            <?php
            if (authIsAutenticated()) : ?>
                <li class="navbar__li"><a href="index.php?s=profile&id=<?= authGetUser()['id_user']; ?>"><i class="fa-solid fa-user fa-xl navbar__icon"></i></a></li>
                <li class="navbar__li"><a href="actions/logout.php"><i class="fa-solid fa-right-from-bracket fa-xl navbar__icon"></i></a></li>
            <?php endif; ?>
        </ul>

        <?php
        if (!authIsAutenticated()) : ?>
            <div class="navbar__unauthorized">
                <a class="button navbar__button navbar__button--login" href="index.php?s=login">Iniciar Sesión</a>
                <a class="button navbar__button navbar__button--sign-up" href="index.php?s=sign-up">Registrarse</a>
            </div>
        <?php
        else : ?>
            <div class="navbar__profile-picture">
                <?php
                if (authGetUser()['profile_picture']) : ?>
                    <img src="img/<?= authGetUser()['profile_picture']; ?>" alt="<?= authGetUser()['profile_picture_alt']; ?>" />
                <?php
                else : ?>
                <p>no image</p>
                <?php endif; ?>
            </div>
        <?php
        endif; ?>
    </nav>

    <main class="main">
        <?php
        require 'sections/' .  $section . '.php';
        ?>

        <?php
        if ($statusSuccess !== null) : ?>
            <div class="card alerts" role="alert"><?= $statusSuccess; ?></div>
        <?php
        endif; ?>
        <?php
        if ($statusError !== null) : ?>
            <div class="card alerts" role="alert"><?= $statusError; ?></div>
        <?php
        endif; ?>
        <?php
        if ($statusInfo !== null) : ?>
            <div class="card alerts" role="alert"><?= $statusInfo; ?></div>
        <?php
        endif; ?>
    </main>

    <script src="./js/script.js"></script>
</body>

</html>