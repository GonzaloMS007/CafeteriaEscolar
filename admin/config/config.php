<?php

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$basePath = dirname($path, 2);

session_name('admin_sesion');
session_start();

define("ADMIN_URL", "http://localhost/CafeteriaEscolar/admin/");

