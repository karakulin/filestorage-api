<?php

declare(strict_types=1);

namespace App\Controller\Files;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Update extends Base
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $files = $this->getFilesService()->update($input, (int) $args['id']);

        $payload = json_encode($files);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
