<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function getAll($model);
    public function getById($id, $model);
    public function delete($id, $model);
    public function create(array $data, $model);
    public function update($id, array $data, $model);

    // Только для проектов
    public function getFulfilled(array $data);
}
