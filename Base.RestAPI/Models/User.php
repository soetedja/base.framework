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
 * User class
 */
class User extends BaseModel
{
    
    /**
     * username
     * @var string
     */
    public $username;
    
    /**
     * password
     * @var string
     */
    public $password;
    
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
     * status id
     * @var int
     */
    public $status_id;


    /**
     * Language identifier
     * @var Int
     */
    public $language_id;
    
    /**
     * This model is mapped to the table users
     */
    public function getSource() {
        return 'users';
    }
    
    /**
     * A car only has a Brand, but a Brand have many Cars
     */
    public function initialize() {
        $this->belongsTo('status_id', 'Status', 'id');
        $this->belongsTo('language_id', 'Language', 'id');
    }
    
    /**
     * @return boolean
     */
    public function validation() {
        $this->validate(new UniquenessValidator(array('field' => 'username', 'message' => String::format(CommonResources::getMessage('Msg_Uniqueness'), ConfigurationResources::getMessage('username'), $this->username))));
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
                    
                    // case 'InvalidCreateAttempt':
                    //     $messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('Msg_InvalidCreateAttempt') , CommonResources::getMessage('User')));
                    //     break;
                    // case 'InvalidUpdateAttempt':
                    //     $messages[] = new Message(null, Constants::getMessageType() ['Error'], String::format(CommonResources::getMessage('Msg_InvalidUpdateAttempt') , CommonResources::getMessage('User')));
                    //     break;
                    
                    
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
