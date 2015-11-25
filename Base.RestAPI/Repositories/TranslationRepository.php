<?php
namespace Base\Repositories;
use Base\Models\Translation;
use Base\Models\vw_ManageTranslation;
use Base\Repositories\Interfaces\ITranslationRepository;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TranslationRepository extends BaseRepository implements ITranslationRepository
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
		return new Translation();
	}

	public function getViewModelName() {
        return '\Base\Models\vw_ManageTranslation';
    }
}