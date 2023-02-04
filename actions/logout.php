<?php
require_once '../data/bootstrap.php';

authLogout();

header('Location: ../index.php?s=login');