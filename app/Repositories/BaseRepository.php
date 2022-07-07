<?php

namespace App\Repositories;

abstract class BaseRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model mysql
     */
    protected $model;


    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getModel()
    {
        return '';
    }

    /**
     * Get All
     */
    public function getAll()
    {
        return $this->model->all();
    }

    public function whereInId(array $id)
    {
        return $this->model->whereIn('id', $id)->get();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * insert
     * @param array $attributes
     * @return mixed
     */
    public function insert(array $attributes)
    {
        return $this->model->insert($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            
            return $result;
        }

        return false;
    }
}