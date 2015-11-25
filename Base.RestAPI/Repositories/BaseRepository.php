<?php
namespace Base\Repositories;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Base\Framework\Exceptions\CustomException;
use Base\Framework\Constants;

abstract class BaseRepository extends \Phalcon\DI\Injectable
{
    
    /**
     * @return string model name
     */
    abstract public function getViewModelName();
    
    /**
     * @param int
     */
    public static function getById($id) {
        $model = self::getModel();
        return $model::findFirstById($id);
    }
    
    /**
     * @return collection of model
     */
    public static function getAll() {
        $model = self::getModel();
        return $model::find();
    }
    
    /**
     * @param entity
     * @return model
     */
    public static function create($entity) {
        try {
            $manager = new TransactionManager();
            $transaction = $manager->get();
            $model = self::getModel();
            $model->setTransaction($transaction);
            
            if (isset($entity['skip_attributes'])) {
                $model->skip_attributes = $entity['skip_attributes'];
            }
            
            if ($model->save($entity) == false) {
                $transaction->rollback("Can't save");
            }
            $transaction->commit();
            return $model->getMessages();
        }
        catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
            throw new CustomException($model->getMessages(), Constants::errorCode() ['InternalServerError']);
        }
        catch(\Exception $e) {
            if (!empty($model->getMessages())) {
                throw new CustomException($model->getMessages(), Constants::errorCode() ['InternalServerError']);
            } 
            else {
                var_dump($e->getMessage());
                throw $e;
            }
        }
    }
    
    /**
     * @param entity
     */
    public static function update($entity) {
        try {
            $manager = new TransactionManager();
            $transaction = $manager->get();
            $model = self::getModel();
            $model->setTransaction($transaction);
            if (isset($entity['skip_attributes'])) {
                $model->skip_attributes = $entity['skip_attributes'];
            }
            if ($model->save($entity) == false) {
                $transaction->rollback("Can't save entity");
            }
            
            $transaction->commit();
            return $model->getMessages();
        }
        catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
            throw new CustomException($model->getMessages(), Constants::errorCode() ['InternalServerError']);
        }
        catch(\Exception $e) {
            if (!empty($model->getMessages())) {
                throw new CustomException($model->getMessages(), Constants::errorCode() ['InternalServerError']);
            } 
            else {
                var_dump($e->getMessage());
                throw $e;
            }
        }
    }
    
    /**
     * @param id
     */
    public static function delete($id) {
        try {
            $manager = new TransactionManager();
            $transaction = $manager->get();
            
            $model = self::getModel();
            $entity = $model::findFirst($id);
            $entity->setTransaction($transaction);
            if ($entity->delete() == false) {
                $transaction->rollback($entity->getMessages()[0]->message);
            }
            
            $transaction->commit();
            return $entity->getMessages();
        }
        catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
            throw new CustomException($model->getMessages(), Constants::errorCode() ['InternalServerError']);
        }
        catch(\Exception $e) {
            if (!empty($entity->getMessages())) {
                throw new CustomException($entity->getMessages(), Constants::errorCode() ['InternalServerError']);
            } 
            else {
                var_dump($e->getMessage());
                throw $e;
            }
        }
    }
    
    public function search($criteria) {
        
        $filter = array();
        $sorting = array();
        $count = 10;
        $currentPage = 1;
        try {
            if (isset($criteria['filter'])) {
                $filter = $criteria['filter'];
            }
            if (isset($criteria['sorting'])) {
                $sorting = $criteria['sorting'];
            }
            if (isset($criteria['count'])) {
                $count = $criteria['count'];
            }
            if (isset($criteria['page'])) {
                $currentPage = $criteria['page'];
            }
            
            $query = Criteria::fromInput($this->getDi(), $this->getViewModelName(), $filter);
            $searchParams = $query->getParams();
            $parameters = array();
            if ($searchParams) {
                $parameters = $searchParams;
            }
            
            $parameters['order'] = key($sorting) . " " . $sorting[key($sorting) ];
            
            $type = $this->getViewModelName();
            
            $model = new $type;
            $result = $model::find($parameters);
            $paginator = new Paginator(array("data" => $result, "limit" => $count, "page" => $currentPage));
            
            return $paginator->getPaginate();
        }
        catch(\Exception $e) {
            if (!empty($model->getMessages())) {
                return $model->getMessages();
            } 
            else {
                var_dump($e->getMessage());
                throw $e;
            }
        }
    }
    
    /**
     * @return model
     */
    private static function getModel() {
        return static ::Model();
    }
}
