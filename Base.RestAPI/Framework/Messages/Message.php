<?php
namespace Base\Framework\Messages;

class Message
{
    
    public function __construct($id = null, $type = null, $message = null) {
        $this->id = $id;
        $this->type = $type;
        $this->message = $message;
    }
    
    /**
     * model
     * @var string
     */
    public $id;
    
    /**
     * $message
     * @var int
     */
    public $type;
    
    /**
     * message
     * @var string
     */
    public $message;
}
