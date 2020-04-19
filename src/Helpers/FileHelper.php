<?php

namespace App\Helpers;

use Pimple\Container;

/**
 * Class FileHelper
 * @package App\Helpers
 */
class FileHelper
{
    /**
     * @var $storage string path to file storage
     */
    private $storage;

    public function __construct(Container $c)
    {
        $this->storage = $c['settings']['storage'];
    }

    /**
     * Create file from string
     * @param string $body
     * @return string|boolean
     * @throws \Exception
     */
    public function createFromString(string $body): string
    {
        $filename = $this->genName();

        if (!file_put_contents($this->storage . $filename, $body))
            return false;

        return $filename;
    }

    /**
     * Replace file content
     * @param string $filename
     * @param string $body
     * @return string
     */
    public function updateFromString(string $filename, string $body): string
    {
        if (!file_exists($this->storage . $filename))
            return false;

        if (!file_put_contents($this->storage . $filename, $body))
            return false;

        return true;
    }

    /**
     * Get file content
     * @param string $filename
     * @return string|boolean
     */
    public function get(string $filename): string
    {
        if (!file_exists($this->storage . $filename))
            return false;

        return file_get_contents($this->storage . $filename);
    }

    /**
     * Get mime type file
     * @param string $filename
     * @return string|boolean
     */
    public function getType(string $filename): string
    {
        if (!file_exists($this->storage . $filename))
            return false;

        return mime_content_type($this->storage . $filename);
    }

    /**
     * Generate file name
     * @return string
     * @throws \Exception
     */
    private function genName(): string
    {
        $filename = RandomHelper::generate();

        //if exist file then regenerate
        if (file_exists($this->storage . $filename))
            return $this->genName();

        return $filename;
    }
}