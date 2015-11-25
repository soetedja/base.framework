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
 * Donation class
 */
class Donation extends BaseModel
{
    /**
     * username
     * @var int
     */
    public $donor_id;
    
    /**
     * password
     * @var string
     */
    public $method;
    
    /**
     * name
     * @var string
     */
    public $amount;
    
    /**
     * description
     * @var string
     */
    public $description;
    
    // Additional field 
    public $donor_name;
  
    /**
     * A car only has a Brand, but a Brand have many Cars
     */
    public function initialize() {
        $this->belongsTo('donor_id', 'Base\Models\Donor', 'id', array(
            'reusable' => true
        ));
    }

    public function getDonor()
    {
        return $this->getRelated('Base\Models\Donor');
    }

    public function afterFetch()
    {
        $this->donor_name = $this->getDonor()->name;
    }
    
    /**
     * @return boolean
     */
    public function validation() {
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
