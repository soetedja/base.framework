<?php
namespace Base\Repositories\Interfaces;

interface IUserRepository extends IBaseRepository  
{
    public static function getByUsernameOrEmail($userOrEmail);
}