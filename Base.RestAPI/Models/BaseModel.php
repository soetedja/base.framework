<?php
namespace Base\Models;

use Phalcon\Mvc\Model;

/**
 * BaseModel class
 */
class BaseModel extends Model
{
    
    /**
     * identifier
     * @var int
     */
    public $id;
    
    /**
     * created at
     * @var datetime
     */
    public $created_at;
    
    /**
     * modified
     * @var datetime
     */
    public $modified_at;
    
    /**
     * Additional attribute
     */
    public $skip_attributes = array();

    
    public function beforeValidationOnCreate() {
        $this->created_at = gmdate('Y-m-d H:i:s');
        $this->modified_at = gmdate('Y-m-d H:i:s');
    }
    
    public function beforeUpdate() {
        $this->modified_at = gmdate('Y-m-d H:i:s');
        $this->skipAttributesOnUpdate($this->skip_attributes);
    }
}
