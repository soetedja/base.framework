<?php
namespace Base\Repositories\Interfaces;

interface IBaseRepository
{
    public static function create($entity);
    public static function delete($id);
    public static function getAll();
    public static function getById($id);
    public static function update($entity);
    public function search($criteria);
}