<?php
namespace Base\Controllers\Dictionary;
use Base\Services\TranslationService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class TranslationController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->translationService = new TranslationService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->translationService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->translationService->getById($id);
        return $this->sendRespond($response);
    }
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->translationService->create($entity);
        return $this->sendRespond($response);
    }
    
    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->translationService->update($entity);
        
        return $response;
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->translationService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function search() {
        $response = $this->translationService->search($this->request->getPost());
        return $response;
    }
}
