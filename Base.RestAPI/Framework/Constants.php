<?php
namespace Base\Framework;

class Constants
{
    private static $messageTypes = array(
        'Success' => 'success',
        'Warning' => 'warning',
        'Error' => 'error',
        'Info' => 'info',
    );

    public static function getMessageType() {
        return self::$messageTypes;
    }

    private static $errorCodes = array(
    	'BadRequest' => 400,
    	'Unauthorized' => 401,
    	'Forbidden' => 403,
    	'NotFound' => 404,
    	'InternalServerError' => 500,
    );

    public static function errorCode() {
        return self::$errorCodes;
    }
}
