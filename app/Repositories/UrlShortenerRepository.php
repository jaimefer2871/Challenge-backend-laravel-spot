<?php

namespace App\Repositories;

use App\Models\UrlShortenerModel;

class UrlShortenerRepository
{

    public function findById(int $id)
    {
        return UrlShortenerModel::find($id);
    }

    public function update(int $id, array $data)
    {
        $model = UrlShortenerModel::find($id);

        $model->fill($data);

        return $model->save();
    }

    public function destroy(int $id)
    {
        return UrlShortenerModel::destroy($id);
    }

    public function save(array $data)
    {
        $output = false;
        $model = new UrlShortenerModel($data);

        if ($model->save()) {
            $output = $model->toArray();
        }

        return $output;
    }

    public function findByConditions(array $conditions = [])
    {
        $model = new UrlShortenerModel();

        foreach ($conditions as $condition) {
            $model = $model->where($condition['field'], $condition['operator'], $condition['value']);
        }


        return $model->get();
    }
}
