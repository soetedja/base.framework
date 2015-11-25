<?php
namespace Base\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Base\Framework\Messages\Message;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Resources\Common\CommonResources;
use Base\Resources\Dictionary\DictionaryResources;

/**
 * WordType class
 */
class WordType extends BaseModel
{
    
    /**
     * name
     * @var string
     */
    public $name;
    
    /**
     * description
     * @var string
     */
    public $description;
    
    /**
     * phone
     * @var string
     */
    public $status_id;
    
    /**
     * This model is mapped to the table kind of word
     */
    public function getSource() {
        return 'word_type';
    }
    
    /**
     * A Word only has a WordType, but a WordType have many Word
     */
    public function initialize() {
        $this->hasMany('id', 'Base\Models\Word', 'word_type_id', array('foreignKey' => array('message' => 'WordType cannot be deleted because it\'s used in Word')));
        $this->belongsTo('status_id', 'Status', 'id');
    }
    
    /**
     * @return boolean
     */
    public function validation() {
        $this->validate(new UniquenessValidator(array('field' => 'name', 'message' => String::format(CommonResources::getMessage('Msg_Uniqueness'), DictionaryResources::getMessage('name'), $this->name))));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
    
    public function getMessages() {
        $messages = array();
        if (parent::getMessages()) {
            foreach (parent::getMessages() as $message) {
                switch ($message->getType()) {
                    case 'PresenceOf':
                        $messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('Msg_PresenceOf'), DictionaryResources::getMessage($message->getField())));
                        break;

                    default:
                        $messages[] = new Message(null, Constants::getMessageType() ['Error'], $message->getMessage());
                        break;
                }
            }
        }
        
        return $messages;
    }
}
