<?php
namespace Base\Services;
use Base\Services\Interfaces\IUserService;
use Base\Framework\Responses\Response;
use Base\Framework\Messages\Message;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Resources\Common\CommonResources;
use Base\Repositories\UserRepository;
use Base\Framework\Exceptions\CustomException;

/**
 * User service
 */
class UserService implements IUserService
{
    
    /**
     * @param  string
     * @return the user
     */
    public function getByUsernameOrEmail($userOrEmail) {
        $response = new Response();
        $errMsg = UserRepository::getByUsernameOrEmail($userOrEmail);
        if ($errMsg) {
            $response->model = $errMsg;
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound'), CommonResources::getMessage('User')));
        }
        return $response;
    }
    
    /**
     * @return the collection of user
     */
    public function getAll() {
        $response = new Response();
        $response->model = UserRepository::getAll();
        return $response;
    }
    
    /**
     * @param  criteria
     * @return the collection of user
     */
    public function search($criteria) {
        $response = new Response();
        $repository = new UserRepository();
        $response->model = $repository->search($criteria);
        return $response;
    }
    
    /**
     * @param  identifier
     * @return the user
     */
    public function getById($id) {
        $response = new Response();
        $result = UserRepository::getById($id);
        if ($result) {
            $response->model = $result;
            return $response;
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound'), CommonResources::getMessage('User')));
            throw new CustomException($response->messages, Constants::errorCode() ['NotFound']);
        }
    }
    
    /**
     * @param  entity
     * @return the messages
     */
    public function create($entity) {
        $response = new Response();
        $errMsg = UserRepository::create($entity);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated'), CommonResources::getMessage('User'), $entity['name']));
        }
        return $response;
    }
    
    /**
     * @param  entity
     * @return the messages
     */
    public function update($entity) {
        $response = new Response();
        $entity['skip_attributes'] = array('password', 'created_at');
        $errMsg = UserRepository::update($entity);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated'), CommonResources::getMessage('User'), $entity['name']));
        }
        return $response;
    }
    
    /**
     * @param  identfier
     * @return the messages
     */
    public function delete($id) {
        $response = new Response();
        $entity = UserRepository::getById($id);
        $errMsg = UserRepository::delete($id);
        if ($errMsg) {
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted'), CommonResources::getMessage('User'), $entity->name));
        }
        
        return $response;
    }
}
