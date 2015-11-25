<?php
namespace Base\Resources;
use Phalcon\Translate\Adapter\NativeArray;
class Resources
{
    const defaultLanguage = "id-ID";
    
    public static function getMessage($id) {
        $request = new \Phalcon\Http\Request();
        $language = $request->getBestLanguage();
        return static ::initialize($language)->_($id);
    }
    
    public static function getAllMessage() {
        $request = new \Phalcon\Http\Request();
        $language = $request->getBestLanguage();
        return static ::allMessages($language);
    }
    
    public static function allMessages($language) {
        include (__DIR__ . static ::resourceName . '.' . static ::defaultLanguage . '.php');
        $defaultMessages = $messages;
        if ($language != static ::defaultLanguage) {
            if (file_exists(__DIR__ . static ::resourceName . '.' . $language . '.php')) {
                include (__DIR__ . static ::resourceName . '.' . $language . '.php');
                foreach ($messages as $key => $value) {
                    $defaultMessages[$key] = $value;
                }
            }
        }
        return $defaultMessages;
    }
    
    public static function initialize($language) {
        if (file_exists(__DIR__ . static ::resourceName . '.' . $language . '.php')) {
            include (__DIR__ . static ::resourceName . '.' . $language . '.php');
        } 
        else {
            include (__DIR__ . static ::resourceName . '.id-ID.php');
        }
        
        //Return a translation object
        return new NativeArray(array("content" => $messages));
    }
}
