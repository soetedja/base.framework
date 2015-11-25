<?php
namespace Base\Models;

use Phalcon\Mvc\Model;

/**
 * Donation class
 */
class vw_Donation extends BaseModel
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
     * This model is mapped to the table users
     */
    public function getSource() {
        return 'vw_donation';
    }
    
}
