<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\FilesException;
use App\Helpers\FileHelper;
use App\Repository\FilesRepository;

class FilesService extends BaseService
{
    protected $filesRepository;

    protected $helper;

    public function __construct(FilesRepository $filesRepository, FileHelper $helper)
    {
        $this->filesRepository = $filesRepository;
        $this->helper = $helper;
    }

    protected function checkAndGet(int $filesId)
    {
        return $this->filesRepository->checkAndGet($filesId);
    }

    /**
     * hide unnecessary columns
     * @param $obj
     * @return mixed
     */
    protected function hideRows($obj)
    {
        foreach (FilesRepository::HIDDEN_ROWS as $row) {
            if (isset($obj->{$row}) || is_null($obj->{$row}))
                unset($obj->{$row});
        }
        return $obj;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->filesRepository->getAll();
    }

    /**
     * File info
     * @param int $filesId
     * @return mixed
     */
    public function getOneInfo(int $filesId)
    {
        $file = $this->checkAndGet($filesId);
        $file->content = base64_encode($this->helper->get($file->real_location));
        return $this->hideRows($file);
    }

    /**
     * File info with meta
     * @param int $filesId
     * @return object
     */
    public function getOne(int $filesId)
    {
        $file = $this->checkAndGet($filesId);
        $file->content = $this->helper->get($file->real_location);
        $file->type = $this->helper->getType($file->real_location);
        return $this->hideRows($file);
    }

    /**
     * @param $input array
     * @return mixed
     * @throws FilesException
     */
    public function create($input)
    {
        $files = json_decode(json_encode($input), false);
        if (!$files->name)
            throw new FilesException("File name is empty", 422);

        if (!$files->content)
            throw new FilesException("File content is empty", 422);

        $files->real_location = $this->helper->createFromString($files->content);

        return $this->hideRows($this->filesRepository->create($files));
    }

    /**
     * @param array $input
     * @param int $filesId
     * @return mixed
     * @throws FilesException
     */
    public function update(array $input, int $filesId)
    {
        $files = $this->checkAndGet($filesId);
        $data = json_decode(json_encode($input), false);

        if (!$data->content)
            throw new FilesException("File content is empty", 422);

        if (!$this->helper->updateFromString($files->real_location, $data->content))
            throw new FilesException("File cant save...", 500);

        return $this->hideRows($this->filesRepository->update($files, $data));
    }

    /**
     * @param int $filesId
     */
    public function delete(int $filesId)
    {
        $this->checkAndGet($filesId);
        $this->filesRepository->delete($filesId);
    }
}
