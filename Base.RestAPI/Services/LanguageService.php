<?php
namespace Base\Services;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Framework\Messages\Message;
use Base\Framework\Responses\Response;
use Base\Repositories\LanguageRepository;
use Base\Resources\Common\CommonResources;
use Base\Resources\Dictionary\DictionaryResources;
use Base\Services\Interfaces\ILanguageService;
use Base\Framework\Exceptions\CustomException;

/**
* Language service
*/
class LanguageService implements ILanguageService
{
    public function __construct() {
    }

    /**
    * @return the collection of word
    */
    public function getAll() {
        $response = new Response();
        $response->model = LanguageRepository::getAll();
        return $response;
    }
    /**
    * @param  criteria
    * @return the collection of word
    */
    public function search($criteria) {
        $response = new Response();
        $repository = new LanguageRepository();
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
        $result = LanguageRepository::getById($id);
        
        if ($result) {
            $response->model = $result;
        }
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound') , DictionaryResources::getMessage('Language')));
            throw new CustomException($response->messages, Constants::errorCode() ['NotFound']);
        }
        return $response;
    }
    
    /**
    * @param  entity
    * @return the messages
    */
    public function create($entity){
        $response = new Response();
        $entity['skip_attributes'] = array();
        $errMsg = LanguageRepository::create($entity);

        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);

        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated') , DictionaryResources::getMessage('Language') , $entity['name']));
        }

        return $response;
    }
    /**
    * @param  entity
    * @return the messages
    */
    public function update($entity){
        $response = new Response();
        $entity['skip_attributes'] = array('created_at');
        $errMsg = LanguageRepository::update($entity);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated') , DictionaryResources::getMessage('Language') , $entity['name']));
        }
        return $response;
    }
    /**
    * @param  identfier
    * @return the messages
    */
    public function delete($id) {
        $response = new Response();
        $entity = LanguageRepository::getById($id);
        $errMsg = LanguageRepository::delete($id);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted') , DictionaryResources::getMessage('Language') , $entity->name));
        }
        
        return $response;
    }
}