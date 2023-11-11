<?php

use App\Controller\WikiController;
use App\Middleware\WikiValidatorMiddleware;
use DI\Bridge\Slim\Bridge;
use Doctrine\ORM\EntityManager;
use Slim\Exception\HttpNotFoundException;
use Symfony\Component\Serializer\Serializer;
use Whoops\Handler\JsonResponseHandler;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

require __DIR__ .'/../vendor/autoload.php';
$cnt = require __DIR__ . '/../bootstrap.php';

$definitions = [
    WikiController::class => DI\create()->constructor(
        $cnt->get(EntityManager::class),
        $cnt->get(Serializer::class))
];
$builder = new DI\ContainerBuilder();
$builder->addDefinitions($definitions);
$container = $builder->build();

$app = Bridge::create($container);

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->add(new WhoopsMiddleware([], [new JsonResponseHandler()]));


$app->get('/', WikiController::class . ':get');
$app->post('/', WikiController::class . ':post')->add(new WikiValidatorMiddleware());

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$app->run();



