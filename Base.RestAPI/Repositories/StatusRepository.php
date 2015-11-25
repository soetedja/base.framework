<?php
namespace Base\Repositories;
use Base\Models\Status;
use Base\Repositories\Interfaces\IStatusRepository;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Paginator\Adapter\Model as Paginator;

class StatusRepository extends BaseRepository implements IStatusRepository
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
		return new Status();
	}

	public function getViewModelName() {
        return '\Base\Models\Status';
    }
}