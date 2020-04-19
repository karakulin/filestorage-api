<?php

declare(strict_types=1);

namespace App\Controller\Files;

use App\Service\FilesService;

abstract class Base
{
    protected $container;

    protected $filesService;

    public function __construct($container)
    {
        $this->container = $container;
    }

    protected function getFilesService(): FilesService
    {
        return $this->container->get('files_service');
    }
}
