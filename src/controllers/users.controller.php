<?php
require_once(ROOT_PATH . '/models/users.model.php');

class UsersController
{
    private $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel($GLOBALS['DB']);
    }

    private function getByEmail(string $email)
    {
        $user = $this->usersModel->getByEmail($email);
        include_once(ROOT_PATH . '/views/users/user.php');
    }

    public function getById(int $id)
    {
        $user = $this->usersModel->getOne($id);
        include_once(ROOT_PATH . '/views/users/user.php');
    }

    public function get()
    {
        if (isset($_GET['logout'])) {
            unset($_SESSION['user']);
            unset($_SESSION['candidate']);
            unset($_SESSION['company']);
            return include_once(ROOT_PATH . '/views/users/login.php');
        }
        if (isset($_SESSION['user'])) {
            return include_once(ROOT_PATH . '/views/users/user.php');
        }
        if (isset($_GET['register'])) {
            return include_once(ROOT_PATH . '/views/users/register.php');
        }
        if (isset($_GET['email']) && isset($_GET['password'])) {
            try {
                $user = $this->usersModel->login($_GET['email'], $_GET['password']);
                $_SESSION['user'] = json_encode($user);
                if ($user->userType === UserType::CANDIDATE->value) {
                    $_SESSION['candidate'] = json_encode($this->usersModel->getCandidate($user->id));
                } else {
                    $_SESSION['company'] = json_encode($this->usersModel->getCompany($user->id));
                }
                return include_once(ROOT_PATH . '/views/users/user.php');
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                return include_once(ROOT_PATH . '/views/error.php');
            }
        } else if (isset($_GET['email'])) {
            $this->getByEmail($_GET['email']);
        } else if (isset($_GET['id'])) {
            $this->getById($_GET['id']);
        } else {
            include_once(ROOT_PATH . '/views/users/login.php');
        }
    }

    public function post()
    {
        if (isset($_POST['submit'])) {
            $data = [
                'email' => $_POST['email'],
                'password' => $this->usersModel->hashPassword($_POST['password']),
                'origin' => $_POST['origin'] ? $_POST['origin'] : Origin::LOCAL->value,
                'userType' => $_POST['userType'] === UserType::CANDIDATE->value ? UserType::CANDIDATE->value : UserType::COMPANY->value,
            ];
            if ($data['userType'] === UserType::CANDIDATE->value) {
                $data['firstName'] = $_POST['firstName'];
                $data['lastName'] = $_POST['lastName'];
            } else {
                $data['companyName'] = $_POST['companyName'];
                $data['location'] = $_POST['location'];
                $data['description'] = $_POST['description'];
            }
            var_dump($data);
            try {
                $this->usersModel->addUser($data);
                return include_once(ROOT_PATH . '/views/users/user.php');
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                $_SESSION['error'] = $errorMessage;
                return include_once(ROOT_PATH . '/views/error.php');
            }
        }
        include_once(ROOT_PATH . '/views/users/register.php');
    }

    public function put() {
        if (isset($_POST['submit'])) {
            $data = [
                'id' => $_POST['id'],
                'email' => $_POST['email'],
                'password' => $this->usersModel->hashPassword($_POST['password']),
                'origin' => $_POST['origin'] ? $_POST['origin'] : Origin::LOCAL->value,
                'userType' => $_POST['userType'] === UserType::CANDIDATE->value ? UserType::CANDIDATE->value : UserType::COMPANY->value,
            ];
            $user = new User(...$data);
            if ($data['userType'] === UserType::CANDIDATE->value) {
                $data['firstName'] = $_POST['firstName'];
                $data['lastName'] = $_POST['lastName'];
                // $candidate = new Candidate();
                // $this->usersModel->updateCandidate();
            } else {
                $data['companyName'] = $_POST['companyName'];
                $data['location'] = $_POST['location'];
                $data['description'] = $_POST['description'];
            }
            try {
                $this->usersModel->updateUser($user);
                return include_once(ROOT_PATH . '/views/users/user.php');
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                return include_once(ROOT_PATH . '/views/error.php');
            }
        }
        include_once(ROOT_PATH . '/views/users/register.php');
    }
}