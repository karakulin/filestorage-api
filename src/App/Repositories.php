<?php

declare(strict_types=1);

$container["files_repository"] = function ($container): App\Repository\FilesRepository {
    return new App\Repository\FilesRepository($container["db"]);
};
