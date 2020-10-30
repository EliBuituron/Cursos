<?php
require dirname(__FILE__) . '/../vendor/autoload.php';

session_start();

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = dirname(__FILE__) . $url['path'];
    if (is_file($file)) return false;
}

$container = \Cursos\ContainerFactory::create();

$app = \DI\Bridge\Slim\Bridge::create($container);

$app->get('/', [\Cursos\Controllers\HomeController::class, 'index']);
$app->get('/cursos[/]', [\Cursos\Controllers\CursosController::class, 'view']);
$app->get('/cursos/add[/]', [\Cursos\Controllers\CursosController::class, 'form']);
$app->get('/cursos/edit/{idCurso}[/]', [\Cursos\Controllers\CursosController::class, 'edit']);
$app->post('/cursos/process[/]', [\Cursos\Controllers\CursosController::class, 'formSubmit']);

$app->run();