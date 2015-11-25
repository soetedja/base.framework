<?php
namespace Base\Controllers\Configurations;
use Base\Services\UserService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class UserController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->userService = new UserService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->userService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->userService->getById($id);
        return $response;
        return $this->sendRespond($response);
    }
    
    public function login() {
        $userOrEmail = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $response = $this->userService->getByUsernameOrEmail($userOrEmail);
        if ($response->model) {
            if ($this->security->checkHash($password, $response->model->password)) {
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
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $entity['password'] = $this->security->hash($entity['password']);
        $response = $this->userService->create($entity);
        return $response;
        return $this->sendRespond($response);
    }
    
    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->userService->update($entity);
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->userService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function put() {
        return array('Put / stub');
    }
    
    public function patch($id) {
        return array('Patch / stub');
    }
    
    public function search() {
        $response = $this->userService->search($this->request->getPost());
        return $response;
    }
    
    private function _registerSession($user) {
        $this->session->set('auth', array('id' => $user->id, 'name' => $user->name));
    }
}
