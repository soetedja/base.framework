<?php
namespace Base\Framework\Exceptions;
use Base\Resources\Common\CommonResources;

class CustomException extends HTTPException {
	
	function __construct($messages, $code){
		$errorArray =  array('dev' => CommonResources::getMessage('DataNotFound'), 'internalCode' => 'REQ1000', 'more' => '');
		parent::__construct("Service Error", $code, $errorArray, $messages);
	}
}