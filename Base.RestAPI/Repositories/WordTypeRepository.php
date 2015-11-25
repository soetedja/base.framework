<?php
namespace Base\Repositories;
use Base\Models\WordType;
use Base\Repositories\Interfaces\IWordTypeRepository;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Paginator\Adapter\Model as Paginator;

class WordTypeRepository extends BaseRepository implements IWordTypeRepository
{
	/**
	 * Define used model
	 */
	public static function Model(){
		return new WordType();
	}

	public function getViewModelName() {
        return '\Base\Models\WordType';
    }
}