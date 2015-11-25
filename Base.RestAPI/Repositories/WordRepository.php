<?php
namespace Base\Repositories;
use Base\Models\Word;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Base\Repositories\Interfaces\IWordRepository;

class WordRepository extends BaseRepository implements IWordRepository
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
		return new Word();
	}

	public function getViewModelName() {
        return '\Base\Models\vw_Word';
    }
}