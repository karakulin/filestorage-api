<?php

$baseDir = __DIR__ . '/../';
$dotenv = new Dotenv\Dotenv($baseDir);
if (file_exists($baseDir . '.env')) {
    $dotenv->load();
}
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

return [
    "paths" => [
        "migrations" => [
            "%%PHINX_CONFIG_DIR%%/migrations",
        ]
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "dev",
        "dev" => [
            "adapter" => 'mysql',
            "host" => getenv('DB_HOST'),
            "name" => getenv('DB_NAME'),
            "user" => getenv('DB_USER'),
            "pass" => getenv('DB_PASS'),
            "charset" => "utf8"
        ]
    ],
    "version_order" => "creation",
];