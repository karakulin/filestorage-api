<?php

declare(strict_types=1);

namespace App\Controller\Files;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GetAll extends Base
{
    /**
     * Get all files
     * @todo add limit and offset
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function __invoke(Request $request, Response $response)
    {
        $files = $this->getFilesService()->getAll();

        $payload = json_encode($files);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
