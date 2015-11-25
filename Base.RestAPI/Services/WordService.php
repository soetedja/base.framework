<?php
namespace Base\Services;
use Base\Services\Interfaces\IWordService;
use Base\Framework\Responses\Response;
use Base\Framework\Messages\Message;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Resources\Common\CommonResources;
use Base\Resources\Dictionary\DictionaryResources;
use Base\Repositories\WordRepository;
use Base\Framework\Exceptions\CustomException;

/**
 * Word service
 */
class WordService implements IWordService
{
    /**
     * @return the collection of word
     */
    public function getAll() {
        $response = new Response();
        $response->model = WordRepository::getAll();
        return $response;
    }

    /**
     * @param  criteria
     * @return the collection of word
     */
    public function search($criteria) {
        $response = new Response();
        $repository = new WordRepository();
        $response->model = $repository->search($criteria);
        return $response;
    }
    
    /**
     * @param  identifier
     * @return the word
     */
    public function getById($id) {
        $response = new Response();
        $result = WordRepository::getById($id);
        if ($result) {
            $response->model = $result;
            return $response;
        } 
        else {
            $response->messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('NotFound'), DictionaryResources::getMessage('Word')));
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
        $errMsg = WordRepository::create($entity);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyCreated') , DictionaryResources::getMessage('Word') , $entity['word']));
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
        $errMsg = WordRepository::update($entity);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyUpdated') , DictionaryResources::getMessage('Word') , $entity['word']));
        }
        return $response;
    }

    /**
     * @param  identfier
     * @return the messages
     */
    public function delete($id) {
        $response = new Response();
        $entity = WordRepository::getById($id);
        $errMsg = WordRepository::delete($id);
        if($errMsg){
            throw new CustomException($errMsg, Constants::errorCode() ['BadRequest']);
        }else{
            $response->messages[] = new Message(null, Constants::getMessageType() ['Success'], String::format(CommonResources::getMessage('Msg_SuccessfullyDeleted') , DictionaryResources::getMessage('Word') , $entity->word));
        }
        
        return $response;
    }
}
