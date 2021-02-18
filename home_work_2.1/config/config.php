<?php

define('PUBLIC_DIR', $_SERVER['DOCUMENT_ROOT'] . '/');
define('TEMPLATES_DIR', PUBLIC_DIR . '../templates/');
define('ENGINE_DIR', PUBLIC_DIR . "../engine/");
define('LAYOUTS_DIR', 'layouts/');
define('XDEBUG', true);

include ENGINE_DIR . "functions.php";
include ENGINE_DIR . "log.php";
include ENGINE_DIR . "gallery.php";