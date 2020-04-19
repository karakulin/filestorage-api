<?php

declare(strict_types=1);

namespace App\Controller\Files;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Delete extends Base
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $this->getFilesService()->delete((int) $args['id']);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(204);
    }
}
