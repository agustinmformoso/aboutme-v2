<?php
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');
setlocale(LC_ALL, 'es_VE.UTF-8', 'es_ES');

const PATH_IMG = __DIR__ . "../../img/";

const ENVIRONMENT_DEV = 0;
const ENVIRONMENT_PROD = 1;
const ENVIRONMENT_MAINTENANCE = 2;

$environmentState = ENVIRONMENT_DEV;

require_once __DIR__ . '/../libraries/sessions.php';
require_once __DIR__ . '/../libraries/auth.php';
require_once __DIR__ . '/../libraries/users.php';

require_once __DIR__ . '/../utils/index.php';
require_once __DIR__ . '/../utils/translations.php';

require __DIR__ . '/conection.php';
