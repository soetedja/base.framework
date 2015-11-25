<?php
namespace Base\Services\Interfaces;

interface IUserService extends IBaseService{
    public function getByUsernameOrEmail($userOrEmail);
}
