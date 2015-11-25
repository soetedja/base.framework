<?php
namespace Base\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Base\Framework\Messages\Message;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Resources\Common\CommonResources;
use Base\Resources\Configuration\ConfigurationResources;

/**
 * Word class
 */
class Word extends BaseModel
{
    
    /**
     * language identifier
     * @var int
     */
    public $language_id;
    
    /**
     * word
     * @var string
     */
    public $word;
    
    /**
     * status id
     * @var string
     */
    public $status_id;
    
    /**
     * is on dictionary
     * @var bool
     */
    public $is_on_dictionary;
    
    /**
     * kind of word identifier
     * @var int
     */
    public $word_type_id;
    
    public $description;
    
    /**
     * This model is mapped to the table users
     */
    public function getSource() {
        return 'word';
    }
    
    /**
     * initial table relationship
     */
    public function initialize() {
        $this->belongsTo('language_id', 'Language', 'id');
        $this->belongsTo('status_id', 'Status', 'id');
        $this->belongsTo('word_type_id', 'WordType', 'id');
    }
    
    /**
     * @return boolean
     */
    public function validation() {
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
    
    public function getMessages() {
        $messages = array();
        foreach (parent::getMessages() as $message) {
            switch ($message->getType()) {
                case 'PresenceOf':
                    $messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('Msg_PresenceOf'), ConfigurationResources::getMessage($message->getField())));
                    break;

                default:
                    $messages[] = new Message(null, Constants::getMessageType() ['Error'], $message->getMessage());
                    break;
            }
        }
        return $messages;
    }
}
