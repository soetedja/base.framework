<?php
namespace Base\Controllers\Dictionary;
use Base\Services\WordTypeService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class WordTypeController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->wordTypeService = new WordTypeService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->wordTypeService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->wordTypeService->getById($id);
        return $this->sendRespond($response);
    }
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->wordTypeService->create($entity);
        return $this->sendRespond($response);
    }

    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->wordTypeService->update($entity);
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->wordTypeService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function search() {
        $response = $this->wordTypeService->search($this->request->getPost());
        return $response;
    }
}
