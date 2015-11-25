<?php
namespace Base\Services\Interfaces;

interface IDonorService extends IBaseService{
    public function getByEmail($email);
}
