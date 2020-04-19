<?php

declare(strict_types=1);

namespace App\Controller\Files;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Create extends Base
{
    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     * @throws \App\Exception\FilesException
     */
    public function __invoke(Request $request, Response $response)
    {
        $input = $request->getParsedBody();
        $files = $this->getFilesService()->create($input);

        $payload = json_encode($files);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
