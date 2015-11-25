<?php
namespace Base\Controllers\Donation;
use Base\Services\DonorService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class DonorController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->donorService = new DonorService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->donorService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->donorService->getById($id);
        return $this->sendRespond($response);
    }
    
    public function login() {
        $donorOrEmail = $this->request->getPost('donorname');
        $passdonor = $this->request->getPost('passdonor');
        $response = $this->donorService->getByDonornameOrEmail($donorOrEmail);
        if ($response->model) {
            if ($this->security->checkHash($passdonor, $response->model->passdonor)) {
                $this->_registerSession($response->model);
                return true;
            }
        }
        return false;
    }
    
    public function logout() {
        $this->session->destroy();
        return true;
    }
    
    public function createOrLoad() {
        $entity = $this->validateEntity($this->request->getPost());
        $entity['note'] = $entity['method'];
        $existingEntity = $this->donorService->getByEmail($entity['email']);
        if ($existingEntity->model != null) {
            $entity['id'] = $existingEntity->model->id;
            $entity['created_at'] = $existingEntity->model->created_at;
            $response = $this->donorService->update($entity);
            return $this->sendRespond($existingEntity);
        } 
        else {
            $this->donorService->create($entity);
            $existingEntity = $this->donorService->getByEmail($entity['email']);
            return $this->sendRespond($existingEntity);
        }
    }
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->donorService->create($entity);
        return $this->sendRespond($response);
    }
    
    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->donorService->update($entity);
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->donorService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function search() {
        $response = $this->donorService->search($this->request->getPost());
        return $response;
    }
}
