<?php

declare(strict_types=1);

$container["files_service"] = function ($container): App\Service\FilesService {
    $helper = new App\Helpers\FileHelper($container);
    return new App\Service\FilesService($container["files_repository"], $helper);
};