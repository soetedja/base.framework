<?php
namespace Base\Controllers\Configurations;
use Base\Services\LanguageService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class LanguageController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->languageService = new LanguageService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->languageService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->languageService->getById($id);
        return $this->sendRespond($response);
    }
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->languageService->create($entity);
        return $this->sendRespond($response);
    }

    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->languageService->update($entity);
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->languageService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function search() {
        $response = $this->languageService->search($this->request->getPost());
        return $response;
    }
}
