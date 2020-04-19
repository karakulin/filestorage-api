<?php

declare(strict_types=1);

$app->get('/', 'App\Controller\Base\BaseController:getHelp');
$app->get('/status', 'App\Controller\Base\BaseController:getStatus');

$app->get("/files", 'App\Controller\Files\GetAll');
$app->get("/files/{id}/full", 'App\Controller\Files\GetOne:fullOne');
$app->get("/files/[{id}]", 'App\Controller\Files\GetOne:contentOne');
$app->post("/files", 'App\Controller\Files\Create');
$app->put("/files/[{id}]", 'App\Controller\Files\Update');
$app->delete("/files/[{id}]", 'App\Controller\Files\Delete');
