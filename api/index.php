<?php
require_once  __DIR__ . '/../src/vendor/autoload.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \lbs\control\Categoriescontroller as Categoriescontroller;

$settings = [
    'settings'=>[
        'displayErrorDetails'=>true
    ]
];
$errors = require_once  __DIR__ . '/error.php';
$app_config = array_merge($settings,$errors);

$db = new Illuminate\Database\Capsule\Manager();
$conf = parse_ini_file("../src/conf/lbs.db.conf.ini");
$db->addConnection( $conf );
$db->setAsGlobal();
$db->bootEloquent();


$app = new \Slim\App( new \Slim\Container($app_config));
$app->get('/categories[/]', Categoriescontroller::class . ':getCategories');
$app->get('/categories/{id}[/]', Categoriescontroller::class . ':getCategorie')->setName('categorie');
$app->post('/categories[/]',Categoriescontroller::class.':addCategorie');


$app->run();