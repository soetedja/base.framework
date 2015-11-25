<?php
namespace Base\Services;
use Base\Framework\Constants;
use Base\Framework\Exceptions\CustomException;
use Base\Framework\Library\String;
use Base\Framework\Messages\Message;
use Base\Framework\Responses\Response;
use Base\Repositories\TranslationRepository;
use Base\Resources\Common\CommonResources;
use Base\Resources\Dictionary\DictionaryResources;
use Base\Services\DonorService;
use Base\Services\Interfaces\ITranslationService;
/**
* Translation service
*/
class TranslationService implements ITranslationService
{
    /**
    * @return the collection of word
    */
    public function getAll() {
        $response = new Response();
        $response->model = TranslationRepository::getAll();
        return $response;
    }
    /**
    * @param  criteria
    * @return the collection of word
    */
    public function search($criteria) {
        $response = new Response();
        $repository = new TranslationRepository();
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
        $result = TranslationRepository::getById($id);
        
        if ($result) {
            $response->model = $result;
        }
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound') , DictionaryResources::getMessage('Translation')));
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
        $entity['skip_attributes'] = array('');
        $errMsg = TranslationRepository::create($entity);

        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);

        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated') , DictionaryResources::getMessage('Translation') , $entity['donor_name']));
        }

        return $response;
    }

    /**
    * @param  entity
    * @return the messages
    */
    public function update($entity){
        $response = new Response();
        $entity['skip_attributes'] = array('created_at','donor_name');
        $errMsg = TranslationRepository::update($entity);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated') , DictionaryResources::getMessage('Translation') , $entity['donor_name']));
        }
        return $response;
    }
    /**
    * @param  identfier
    * @return the messages
    */
    public function delete($id) {
        $response = new Response();
        $entity = TranslationRepository::getById($id);
        $errMsg = TranslationRepository::delete($id);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted') , DictionaryResources::getMessage('Translation') , $entity->donor_name));
        }
        
        return $response;
    }
}