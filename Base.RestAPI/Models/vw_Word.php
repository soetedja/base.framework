<?php
namespace Base\Models;

use Phalcon\Mvc\Model;

/**
 * Word class
 */
class vw_Word extends BaseModel
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


    // Additional field 

    public $language;

    public $language_code;

    public $word_type;

    public $description;
    
    /**
     * This model is mapped to the table users
     */
    public function getSource() {
        return 'vw_word';
    }
    
}
