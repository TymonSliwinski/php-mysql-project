<?php
require_once(ROOT_PATH . '/models/offers.model.php');

class OffersController
{
    private $offersModel;
    private $offersView;

    public function __construct()
    {
        $this->offersModel = new OffersModel($GLOBALS['DB']);
    }

    private function getAll(): array
    {
        return $this->offersModel->getAll();
        
    }

    private function getOne($id): Offer
    {
        return $this->offersModel->getOne($id);
    }

    public function get(array $params = [])
    {
        if (count($params) == 0) {
            $offers = $this->getAll();
            include_once(ROOT_PATH . '/views/offers/offers.php');
        } else {
            $this->offersView->renderOne($this->getOne($params[0]));
        }
    }

    public function post()
    {
        if (isset($_POST['submit'])) {
            // ?????????????
            $this->offersModel->addOffer();
        } else {
            include_once(ROOT_PATH . '/views/offers/createOffer.view.php');
        }
    }

    public function put()
    {
        if (isset($_POST['submit'])) {
            $this->offersModel->updateOffer($_POST['offer']);
        } else {
            include_once(ROOT_PATH . '/views/offers/createOffer.view.php');
        }
    }

    public function delete(int $id)
    {
        $this->offersModel->deleteOffer($id);
    }
}
?>