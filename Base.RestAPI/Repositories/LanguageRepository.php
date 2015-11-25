<?php
namespace Base\Repositories;
use Base\Models\Language;
use Base\Repositories\Interfaces\ILanguageRepository;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Paginator\Adapter\Model as Paginator;

class LanguageRepository extends BaseRepository implements ILanguageRepository
{
	/**
	 * Define used model
	 */
	public static function Model(){
		return new Language();
	}

	public function getViewModelName() {
        return '\Base\Models\Language';
    }
}