<?php
require_once(ROOT_PATH . '/models/offers.model.php');

class OffersController
{
    private $offersModel;

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

    public function get()
    {
        if (isset($_GET['id'])) {
            $offer = $this->getOne($_GET['id']);
            include_once(ROOT_PATH . '/views/offers/offer.php');
        } else {
            $offers = $this->getAll();
            include_once(ROOT_PATH . '/views/offers/offers.php');
        }
    }

    public function post()
    {
        if (isset($_POST['submit']) && isset($_SESSION['company'])) {
            $companyId = json_decode($_SESSION['company'])->id;
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'category' => $_POST['category'],
                'requirements' => $_POST['requirements'],
                'location' => $_POST['location'],
                'salaryLower' => $_POST['salaryLower'],
                'salaryUpper' => $_POST['salaryUpper'],
                'companyId' => $companyId
            ];
            try {
                $this->offersModel->addOffer(...$data);
                echo 'Offer added';
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                include_once(ROOT_PATH . '/views/error.php');
            }
        }
        include_once(ROOT_PATH . '/views/offers/createOffer.php');
    }

    public function put()
    {
        if (isset($_POST['submit'])) {
            $offer = new Offer(
                $_POST['id'],
                $_POST['title'],
                $_POST['description'],
                $_POST['category'],
                $_POST['requirements'],
                $_POST['location'],
                $_POST['salaryLower'],
                $_POST['salaryUpper'],
                $_POST['created_at'],
                $_POST['companyId']
            );
            try {
                $this->offersModel->updateOffer($offer);
                echo 'Offer updated';
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                include_once(ROOT_PATH . '/views/error.php');
            }
        }
        include_once(ROOT_PATH . '/views/offers/createOffer.php');
    }

    public function delete(int $id)
    {
        try {
            $this->offersModel->deleteOffer($id);
            echo 'Offer deleted';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            include_once(ROOT_PATH . '/views/error.php');
        }
    }
}
?>