<?php
namespace Base\Repositories;
use Base\Models\Donor;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Base\Repositories\Interfaces\IDonorRepository;

class DonorRepository extends BaseRepository implements IDonorRepository
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
		return new Donor();
	}

	public function getViewModelName() {
        return '\Base\Models\Donor';
    }

    ### Additional method

    /**
     * 
     */
	public static function getByEmail($email){
		return Donor::findFirst(array("(email = '$email')"));
	}


}