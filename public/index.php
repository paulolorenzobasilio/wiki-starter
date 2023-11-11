<?php

use App\Controller\WikiController;
use DI\Bridge\Slim\Bridge;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;

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

$app->get('/', WikiController::class . ':get');

$app->run();



