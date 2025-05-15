<?php

define('APP_STARTED', true);

require_once '../config/paths.php';

require_once CLASSES_PATH . '/Session.php';
require_once CLASSES_PATH . '/Auth.php';

Session::start();

require_once CORE_PATH . '/AuthMiddleware.php';
require_once CORE_PATH . '/View.php';
require_once CORE_PATH . '/Router.php';

$router = new Router();

// Učitavanje ruta
require_once ROUTES_PATH . '/web.php';
require_once ROUTES_PATH . '/admin.php';

// Pokretanje rutera
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];
// 2. Bazna putanja do aplikacije (koliko foldera ispred "public")
$basePath = '/CMS/public';

// 3. Ukloni basePath iz URI-ja ako postoji
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
$router->dispatch($uri, $method);