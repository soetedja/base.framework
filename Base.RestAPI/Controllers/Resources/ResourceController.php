<?php
namespace Base\Controllers\Resources;
use \Base\Services\ResourceService;

class ResourceController extends \Base\Controllers\ApiController
{
	/**
	 * Service initialization	
	 * @var null
	 */
	protected $resourceService = null;
	
	/**
	 * Constructor
	 */
    public function __construct(){
		$this->resourceService = new ResourceService();
	}

    public function get() {
        $response = $this->resourceService->getAll();
        return $response;
    }
    
}
