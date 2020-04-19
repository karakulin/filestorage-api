<?php

declare(strict_types=1);

namespace App\Controller\Base;

use Pimple\Psr11\Container;
use Slim\Psr7\Response;

class BaseController
{
    const API_NAME = 'filestorage-api';

    const API_VERSION = '0.0.1';

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getHelp($request, Response $response)
    {
        $message = [
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];
        $payload = json_encode($message);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getStatus($request, Response $response)
    {
        $this->container->get('db');
        $status = [
            'status' => [
                'database' => 'OK',
            ],
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];
        $payload = json_encode($status);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
