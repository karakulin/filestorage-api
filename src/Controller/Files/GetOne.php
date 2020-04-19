<?php

declare(strict_types=1);

namespace App\Controller\Files;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GetOne extends Base
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    public function fullOne(Request $request, Response $response, array $args)
    {
        $file = $this->getFilesService()->getOneInfo((int) $args['id']);

        $payload = json_encode($file);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    public function contentOne(Request $request, Response $response, array $args)
    {
        $file = $this->getFilesService()->getOne((int) $args['id']);

        $response->getBody()->write($file->content);
        return $response
            ->withHeader('Content-Type', $file->type)
            ->withHeader('Content-Disposition', 'attachment; filename="' . $file->name . '"')
            ->withStatus(200);
    }
}
