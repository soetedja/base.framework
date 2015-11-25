<?php
namespace Base\Services;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Framework\Messages\Message;
use Base\Framework\Responses\Response;
use Base\Repositories\StatusRepository;
use Base\Resources\Common\CommonResources;
use Base\Services\Interfaces\IStatusService;
use Base\Framework\Exceptions\CustomException;

/**
* Status service
*/
class StatusService implements IStatusService
{
    /**
    * @return the collection of related entity
    */
    public function getAll() {
        $response = new Response();
        $response->model = StatusRepository::getAll();
        return $response;
    }
    /**
    * @param  criteria
    * @return the collection of related entity
    */
    public function search($criteria) {
        $response = new Response();
        $repository = new StatusRepository();
        $result = $repository->search($criteria);
        $response->model = $result;
        return $response;
    }
    
    /**
    * @param  identifier
    * @return the related entity
    */
    public function getById($id) {
        $response = new Response();
        $result = StatusRepository::getById($id);
        
        if ($result) {
            $response->model = $result;
        }
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound') , CommonResources::getMessage('Status')));
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
        $errMsg = StatusRepository::create($entity);

        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);

        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated') , CommonResources::getMessage('Status') , $entity['name']));
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
        $errMsg = StatusRepository::update($entity);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated') , CommonResources::getMessage('Status') , $entity['name']));
        }
        return $response;
    }
    /**
    * @param  identfier
    * @return the messages
    */
    public function delete($id) {
        $response = new Response();
        $entity = StatusRepository::getById($id);
        $errMsg = StatusRepository::delete($id);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted') , CommonResources::getMessage('Status') , $entity->name));
        }
        
        return $response;
    }
}