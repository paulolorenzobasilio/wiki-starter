<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Rakit\Validation\Validator;
use Slim\Psr7\Response;

class WikiValidatorMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): Response
    {
        $validator = new Validator;
        $validation = $validator->validate($request->getParsedBody(), [
            'title' => 'required|max:75',
            'description' => 'required'
        ]);

        if($validation->fails()){
            $errors = $validation->errors()->firstOfAll();
            $response = new Response();
            $response->getBody()->write(json_encode($errors));
            return $response->withStatus(400)
                ->withHeader('Content-type', 'application/json');
        }

        return $handler->handle($request);;
    }
}
