<?php
namespace Base\Controllers\Dictionary;
use Base\Services\WordService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class WordController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->wordService = new WordService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->wordService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->wordService->getById($id);
        return $this->sendRespond($response);
    }
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->wordService->create($entity);
        return $this->sendRespond($response);
    }
    
    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->wordService->update($entity);
        
        return $response;
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->wordService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function search() {
        $response = $this->wordService->search($this->request->getPost());
        return $response;
    }
}
