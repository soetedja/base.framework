<?php
namespace Base\Repositories;
use Base\Models\Donation;
use Base\Models\vw_Donation;
use Base\Repositories\Interfaces\IDonationRepository;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DonationRepository extends BaseRepository implements IDonationRepository
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
		return new Donation();
	}

	public function getViewModelName() {
        return '\Base\Models\vw_Donation';
    }
}