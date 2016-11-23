<?php
require __DIR__ . '/app/autoload.php';

$app = new App\App;

$container = $app->getContainer();

$container['errorHandler'] = function () {
  return function (\App\Response $response) {
      return $response->setBody('Page not found')->withStatus(404);
  };
};

$container['config'] = function () {
    return [
        'db_driver' => 'mysql',
        'db_host' => 'localhost',
        'db_name' => 'suxx',
        'db_user' => 'root',
        'db_pass' => '1234',
    ];
};

$container['db'] = function ($c) {
    return new PDO(
        $c->config['db_driver'] . ':host=' . $c->config['db_host'] . ';dbname=' . $c->config['db_name'],
        $c->config['db_user'],
        $c->config['db_pass']
    );
};

$app->get('/', [new App\Controllers\HomeController, 'execute']);
$app->get('/home', [new App\Controllers\HomeController($container->db), 'home']);
$app->get('/users', [new App\Controllers\UserController($container->db), 'execute']);
$app->post('/test', [\App\Controllers\TestController::class, 'execute']);
$app->map('/test', [\App\Controllers\TestController::class, 'execute'], ['GET', 'POST']);

$app->get('/contact', function ($response) use ($app) {
    return 'Oh hai';
});

$app->run();

