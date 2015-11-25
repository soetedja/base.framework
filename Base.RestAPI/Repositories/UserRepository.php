<?php
namespace Base\Repositories;
use Base\Models\User;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Base\Repositories\Interfaces\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{

	/**
     * Constructor
     */
    public function __construct() {
       
    }

	/**
	 * Define used model
	 */
	public static function Model(){
		return new User();
	}

	public function getViewModelName() {
        return '\Base\Models\User';
    }

    ### Additional method

    /**
     * 
     */
	public static function getByUsernameOrEmail($userOrEmail){
		return User::findFirst(array("(username = '$userOrEmail' OR email = '$userOrEmail')"));
	}


}