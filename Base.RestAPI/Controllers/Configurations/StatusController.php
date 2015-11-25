<?php
namespace Base\Controllers\Configurations;
use Base\Services\StatusService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class StatusController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->statusService = new StatusService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->statusService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->statusService->getById($id);
        return $this->sendRespond($response);
    }
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->statusService->create($entity);
        return $this->sendRespond($response);
    }

    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->statusService->update($entity);
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->statusService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function search() {
        $response = $this->statusService->search($this->request->getPost());
        return $response;
    }
}
