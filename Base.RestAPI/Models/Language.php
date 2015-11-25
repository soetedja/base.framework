<?php
namespace Base\Models;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Base\Framework\Messages\Message;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Resources\Common\CommonResources;
use Base\Resources\Configuration\ConfigurationResources;

class Language extends BaseModel
{
    /**
     * language code
     * @var string
     */
    public $code;

    /**
     * [$name language]
     * @var [type]
     */
    public $name;

    /**
     * Description
     * @var String
     */
    public $description;

    /**
     * Status identifier
     * @var Int
     */
    public $status_id;
    
    /**
     * This model is mapped to the table language
     */
    public function getSource() {
        return 'language';
    }
    
    /**
     * A Word only has a Language, but a Language have many Words
     */
    public function initialize() {
        $this->hasMany('id', 'Word', 'language_id', array('foreignKey' => array('message' => 'Status cannot be deleted because it\'s used in other entity')));
        $this->belongsTo('status_id', 'Status', 'id');
    }

     /**
     * @return boolean
     */
    public function validation() {
        $this->validate(new UniquenessValidator(array('field' => 'code', 'message' => String::format(CommonResources::getMessage('Msg_Uniqueness'), CommonResources::getMessage('code'), $this->code))));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

    public function getMessages() {
        $messages = array();
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
        return $messages;
    }
}
