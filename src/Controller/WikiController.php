<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;

class WikiController
{
    public function __construct(private readonly EntityManager $em)
    {
    }

    public function get(ResponseInterface $response){
        $result = $this->em->createQuery('SELECT w FROM App\Entity\Wiki w')->getResult();
        /**
         * TODO: serialize this object into json
         */
        $payload = json_encode($result);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');


    }
}
