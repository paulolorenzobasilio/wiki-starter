<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Serializer;

class WikiController
{
    public function __construct(private readonly EntityManager $em, private readonly Serializer $serializer)
    {
    }

    public function get(ResponseInterface $response): ResponseInterface
    {
        $result = $this->em->createQuery('SELECT w FROM App\Entity\Wiki w')->getResult();
        $data = $this->serializer->serialize($result, 'json');

        $response->getBody()->write($data);

        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
