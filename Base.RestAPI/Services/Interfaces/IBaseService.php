<?php
namespace Base\Services\Interfaces;

interface IBaseService {
    public function create($entity);
    public function delete($entity);
    public function getAll();
    public function getById($id);
    public function search($criteria);
    public function update($entity);
}
