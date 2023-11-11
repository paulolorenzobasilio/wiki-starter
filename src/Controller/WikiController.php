<?php

namespace App\Controller;

use App\Entity\Wiki;
use Doctrine\ORM\EntityManager;;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\RequestInterface;
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function post(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();

        $wiki = new Wiki();
        $wiki->setTitle($body['title']);
        $wiki->setDescription($body['description']);
        $wiki->setUrl($body['title']);

        $this->em->persist($wiki);
        $this->em->flush();

        return $response->withStatus(201, 'Created')
            ->withHeader('Content-type', 'application/json');
    }
}
