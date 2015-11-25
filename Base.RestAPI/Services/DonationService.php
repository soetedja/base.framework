<?php
namespace Base\Services;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Framework\Messages\Message;
use Base\Framework\Responses\Response;
use Base\Repositories\DonationRepository;
use Base\Resources\Common\CommonResources;
use Base\Services\Interfaces\IDonationService;
use Base\Framework\Exceptions\CustomException;
/**
* Donation service
*/
class DonationService implements IDonationService
{
    /**
    * @return the collection of word
    */
    public function getAll() {
        $response = new Response();
        $response->model = DonationRepository::getAll();
        return $response;
    }
    /**
    * @param  criteria
    * @return the collection of word
    */
    public function search($criteria) {
        $response = new Response();
        $repository = new DonationRepository();
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
        $result = DonationRepository::getById($id);
        
        if ($result) {
            $response->model = $result;
        }
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound') , CommonResources::getMessage('Donation')));
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
        $entity['skip_attributes'] = array('donor_name');
        $errMsg = DonationRepository::create($entity);

        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);

        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated') , CommonResources::getMessage('Donation') , $entity['donor_name']));
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
        $errMsg = DonationRepository::update($entity);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated') , CommonResources::getMessage('Donation') , $entity['donor_name']));
        }
        return $response;
    }
    /**
    * @param  identfier
    * @return the messages
    */
    public function delete($id) {
        $response = new Response();
        $entity = DonationRepository::getById($id);
        $errMsg = DonationRepository::delete($id);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted') , CommonResources::getMessage('Donation') , $entity->donor_name));
        }
        
        return $response;
    }
}