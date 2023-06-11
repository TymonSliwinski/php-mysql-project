<?php
require_once(ROOT_PATH . '/models/applications.model.php');

class ApplicationsController
{
    private $applicationsModel;

    public function __construct()
    {
        $this->applicationsModel = new ApplicationsModel($GLOBALS['DB']);
    }

    private function getOne($id): Application
    {
        $application = $this->applicationsModel->getOne($id);
        return new Application(
            $application->id,
            $application->description,
            $application->candidateId,
            $application->offerId,
            $application->createdAt
        );
    }

    private function getAll()
    {
        return $this->applicationsModel->getAll();
    }

    public function get()
    {
        if (isset($_SESSION['user'])) {
            if (isset($_SESSION['candidate'])) {
                if (isset($_GET['apply']) && isset($_GET['offerId'])) {
                    return include_once(ROOT_PATH . '/views/applications/apply.php');
                }
                $applications = $this->applicationsModel->getAllByCandidateId(json_decode($_SESSION['candidate'])->id);
                if (!$applications) {
                    $_SESSION['error'] = 'No applications found';
                    return include_once(ROOT_PATH . '/views/error.php');
                }
                return include_once(ROOT_PATH . '/views/applications/applications.candidate.php');
            } else if (isset($_SESSION['company'])) {
                $applications = $this->applicationsModel->getAllByCompanyId(json_decode($_SESSION['company'])->id);
                if (!$applications) {
                    $_SESSION['error'] = 'No applications found';
                    return include_once(ROOT_PATH . '/views/error.php');
                }
                return include_once(ROOT_PATH . '/views/applications/applications.company.php');
            }
        }
    }

    public function post() {
        if (isset($_POST['submit'])) {
            if (!isset($_SESSION['user']) || !isset($_SESSION['candidate'])) {
                $_SESSION['error'] = 'You must be logged in to apply';
                return include_once(ROOT_PATH . '/views/error.php');
            }
            try {
                $this->applicationsModel->addApplication(
                    $_POST['description'],
                    json_decode($_SESSION['candidate'])->id,
                    $_POST['offerId']
                );
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                return include_once(ROOT_PATH . '/views/error.php');
            }
        }
    }
}
?>