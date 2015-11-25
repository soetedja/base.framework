<?php
namespace Base\Services;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Framework\Messages\Message;
use Base\Framework\Responses\Response;
use Base\Repositories\DonorRepository;
use Base\Resources\Common\CommonResources;
use Base\Services\Interfaces\IDonorService;
use Base\Framework\Exceptions\DomainException;
use Base\Framework\Exceptions\CustomException;

/**
 * Donor service
 */
class DonorService implements IDonorService
{
    
    /**
     * @param  string
     * @return the word
     */
    public function getByEmail($email) {
        $response = new Response();
        $result = DonorRepository::getByEmail($email);
        if ($result) {
            $response->model = $result;
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound'), CommonResources::getMessage('Donor')));
            throw new CustomException($response->messages, Constants::errorCode() ['NotFound']);
        }
        return $response;
    }
    
    /**
     * @return the collection of word
     */
    public function getAll() {
        $response = new Response();
        $response->model = DonorRepository::getAll();
        return $response;
    }
    
    /**
     * @param  criteria
     * @return the collection of word
     */
    public function search($criteria) {
        $response = new Response();
        $repository = new DonorRepository();
        $response->model = $repository->search($criteria);
        return $response;
    }
    
    /**
     * @param  identifier
     * @return the word
     */
    public function getById($id) {
        $response = new Response();
        $result = DonorRepository::getById($id);
        if ($result) {
            $response->model = $result;
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound'), CommonResources::getMessage('Donor')));
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
        $errMsg = DonorRepository::create($entity);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated'), CommonResources::getMessage('Donor'), $entity['name']));
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
        $errMsg = DonorRepository::update($entity);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated'), CommonResources::getMessage('Donor'), $entity['name']));
        }
        return $response;
    }
    
    /**
     * @param  identfier
     * @return the messages
     */
    public function delete($id) {
        $response = new Response();
        $entity = DonorRepository::getById($id);
        $errMsg = DonorRepository::delete($id);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted'), CommonResources::getMessage('Donor'), $entity->name));
        }
        
        return $response;
    }
}
