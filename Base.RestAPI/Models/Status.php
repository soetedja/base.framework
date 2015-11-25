<?php
namespace Base\Models;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Base\Framework\Messages\Message;
use Base\Framework\Constants;
use Base\Framework\Library\String;
use Base\Resources\Common\CommonResources;
use Base\Resources\Configuration\ConfigurationResources;

class Status extends BaseModel
{
    /**
     * Name
     * @var String
     */
    public $name;
    
    /**
     * Description
     * @var String
     */
    public $description;
    
    /**
     * This model is mapped to the table sample_cars
     */
    public function getSource() {
        return 'status';
    }
    
    /**
     * table relationship
     */
    public function initialize() {
        $this->hasMany('id', 'User', 'status_id', array('foreignKey' => array('message' => 'Status cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'Word', 'status_id', array('foreignKey' => array('message' => 'Status cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'TranslationLanguage', 'status_id', array('foreignKey' => array('message' => 'Status cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'Language', 'status_id', array('foreignKey' => array('message' => 'Status cannot be deleted because it\'s used in other entity')));
        $this->hasMany('id', 'Translation', 'status_id', array('foreignKey' => array('message' => 'Status cannot be deleted because it\'s used in other entity')));
    }
    
    /**
     * @return boolean
     */
    public function validation() {
        $this->validate(new UniquenessValidator(array('field' => 'name', 'message' => String::format(CommonResources::getMessage('Msg_Uniqueness'), ConfigurationResources::getMessage('status'), $this->name))));
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
