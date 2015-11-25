<?php
namespace Base\Controllers\Donation;
use Base\Services\DonationService;
use Base\Services\DonorService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Base\Models\Products;
use Base\Models\ProductTypes;
class DonationController extends \Base\Controllers\ApiController
{
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->donationService = new DonationService();
        $this->donorService = new DonorService();
        $this->request = new Request();
    }
    
    public function get() {
        $response = $this->donationService->getAll();
        return $this->sendRespond($response);
    }
    
    public function getOne($id) {
        $response = $this->donationService->getById($id);
        return $this->sendRespond($response);
    }
    
    public function create() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->donationService->create($entity);
        return $this->sendRespond($response);
    }

    public function confirm() {
        $entity = $this->validateEntity($this->request->getPost());
        $donor = $this->donorService->getByEmail($entity['email']);
        $entity['donor_id'] = $donor->model->id;
        $entity['donor_name'] = $donor->model->name;
        $response = $this->donationService->create($entity);
        return $response;
        return $this->sendRespond($response);
    }

    public function update() {
        $entity = $this->validateEntity($this->request->getPost());
        $response = $this->donationService->update($entity);
        return $this->sendRespond($response);
    }
    
    public function delete($id) {
        $response = $this->donationService->delete($id);
        return $this->sendRespond($response);
    }
    
    public function search() {
        $response = $this->donationService->search($this->request->getPost());
        return $response;
    }
}
