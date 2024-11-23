<?php

namespace App\Services;

use App\Repositories\UrlShortenerRepository;

class UrlShortenerService
{
    protected UrlShortenerRepository $repository;

    public function __construct(UrlShortenerRepository $urlShortenerRepository)
    {
        $this->repository = $urlShortenerRepository;
    }

    public function getList($conditions = [])
    {
        return $this->repository->findByConditions($conditions);
    }

    public function getById($id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        $data['shortened'] = bin2hex(random_bytes(4));

        $result = $this->repository->save($data);

        return $result;
    }

    public function delete($id)
    {
        return $this->repository->destroy($id);
    }
}