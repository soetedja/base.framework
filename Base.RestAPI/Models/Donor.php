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
 * Donor class
 */
class Donor extends BaseModel
{
    
    /**
     * name
     * @var string
     */
    public $name;
    
    /**
     * email
     * @var string
     */
    public $email;
    
    /**
     * phone
     * @var string
     */
    public $phone;

    /**
     * note
     * @var note
     */
    public $note;
    
    /**
     * A Donation only has a Donor, but a Donor have many Donantion
     */
    public function initialize() {
        $this->hasMany('id', 'Base\Models\Donation', 'donor_id', array(
            'foreignKey' => array(
                'message' => 'Donor cannot be deleted because it\'s used in Donation'
            )
        ));
    }
    
    /**
     * @return boolean
     */
    public function validation() {
        $this->validate(new EmailValidator(array('field' => 'email', 'message' => String::format(CommonResources::getMessage('Msg_InvalidEmail'), ConfigurationResources::getMessage('email')))));
        $this->validate(new UniquenessValidator(array('field' => 'email', 'message' => String::format(CommonResources::getMessage('Msg_Uniqueness'), ConfigurationResources::getMessage('email'), $this->email))));
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
