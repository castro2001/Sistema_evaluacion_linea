<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../App/config/app.php';
session_start();
use Core\Routes;

$routte = new Routes();
