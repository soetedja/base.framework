<?php
namespace Base\Services;
use \Base\Services\Interfaces\IResourceService;
use \Base\Framework\Responses\Response;
use \Base\Framework\Messages\Message;
use \Base\Framework\Constants;
use \Base\Framework\Library\String;
use \Base\Resources\Common\CommonResources;
use \Base\Resources\Configuration\ConfigurationResources;
use \Base\Resources\Menu\MenuResources;
use \Base\Resources\Dictionary\DictionaryResources;
use \Base\Repositories\UserRepository;
use Base\Framework\Exceptions\CustomException;

/**
 * Resource service class
 */
class ResourceService implements IResourceService
{
	/**
	 * @return response
	 */
    public function getAll() {
        $response = new Response();
        $messages = (object) null;

        $messages->CommonResources = CommonResources::getAllMessage();
        $messages->MenuResources = MenuResources::getAllMessage();
        $messages->ConfigurationResources = ConfigurationResources::getAllMessage();
        $messages->DictionaryResources = DictionaryResources::getAllMessage();

        $response->model = $messages;
        return $response;
    }
}
