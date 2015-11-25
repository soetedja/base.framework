<?php
namespace Base\Services;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Framework\Messages\Message;
use Base\Framework\Responses\Response;
use Base\Repositories\WordTypeRepository;
use Base\Resources\Common\CommonResources;
use Base\Resources\Dictionary\DictionaryResources;
use Base\Services\Interfaces\IWordTypeService;
use Base\Framework\Exceptions\CustomException;

/**
 * WordType service
 */
class WordTypeService implements IWordTypeService
{
    public function __construct() {
    }
    
    /**
     * @return the collection of word
     */
    public function getAll() {
        $response = new Response();
        $response->model = WordTypeRepository::getAll();
        return $response;
    }
    
    /**
     * @param  criteria
     * @return the collection of word
     */
    public function search($criteria) {
        $response = new Response();
        $repository = new WordTypeRepository();
        $result = $repository->search($criteria);
        $response->model = $result;
        return $response;
    }
    
    /**
     * @param  identifier
     * @return the word
     */
    public function getById($id) {
        $response = new Response();
        $result = WordTypeRepository::getById($id);
        
        if ($result) {
            $response->model = $result;
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound'), CommonResources::getMessage('WordType')));
            throw new CustomException($response->messages, Constants::errorCode() ['NotFound']);
        }
        return $response;
    }
    
    /**
     * @param  entity
     * @return the messages
     */
    public function create($entity) {
        $response = new Response();
        $entity['skip_attributes'] = array();
        $errMsg = WordTypeRepository::create($entity);
        
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated'), DictionaryResources::getMessage('WordType'), $entity['name']));
        }
        
        return $response;
    }
    
    /**
     * @param  entity
     * @return the messages
     */
    public function update($entity) {
        $response = new Response();
        $entity['skip_attributes'] = array('created_at');
        $errMsg = WordTypeRepository::update($entity);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated'), DictionaryResources::getMessage('WordType'), $entity['name']));
        }
        
        return $response;
    }
    
    /**
     * @param  identfier
     * @return the messages
     */
    public function delete($id) {
        $response = new Response();
        $entity = WordTypeRepository::getById($id);
        $errMsg = WordTypeRepository::delete($id);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted'), DictionaryResources::getMessage('WordType'), $entity->name));
        }
        return $response;
    }
}
