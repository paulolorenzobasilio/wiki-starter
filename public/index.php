<?php

use App\Controller\WikiController;
use App\Middleware\WikiValidatorMiddleware;
use DI\Bridge\Slim\Bridge;
use Doctrine\ORM\EntityManager;
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

$app->add(new WhoopsMiddleware([], [new JsonResponseHandler()]));

$app->get('/', WikiController::class . ':get');
$app->post('/', WikiController::class . ':post')->add(new WikiValidatorMiddleware());

$app->run();



