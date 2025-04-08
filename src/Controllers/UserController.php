<?php


class UserController
{
    private User $user;

    public function __construct() {
        require_once '../Model/User.php';
        $this->user = new User();
    }

    public function getRegistrate()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION["userId"])) {
            header('Location: /catalog');
        }

        require_once '../Views/registration_form.php';
    }

    private function validateRegistration(array $data)
    {
        $errors = [];

        if (isset($data['name'])) {
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'name must be more than 3 characters';
            }
        } else {
            $errors['name'] = 'name is required';
        }

        if (isset($data['email'])) {
            if (strlen($data['email']) < 2) {
                $errors['email'] = 'email must be more than 2 characters';
            } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email must have an @';
            }
        } else {
            $errors['email'] = 'email is required';
        }

        if (isset($data['psw'])) {
            if (strlen($data['psw']) < 4) {
                $errors['password'] = 'password must be at least 4 characters';
            } elseif (isset($data['psw-repeat'])) {

                if ($data['psw'] !== $data['psw-repeat']) {
                    $errors['passwordRep'] = 'passwords do not match';
                }
            } else {
                $errors['passwordRep'] = 'password is required';
            }
        } else {
            $errors['password'] = 'password is required';
        }

        if (empty($errors)) {
            $data1 = $this->user->getByEmail($data['email']);

            if (!empty($data1)) {
                $errors['email'] = 'email already registered';
            }
        }
        return $errors;
    }

    public function registrate()
    {

        $errors = $this->validateRegistration($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $photo = $_POST['photo'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->user->insertNameEmailPassword($name, $email, $password);

            $data1 = $this->user->getByEmail($email);

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $_SESSION['userId'] = $data1['id'];

            header('Location: /catalog');
        }

        print_r($errors);

        require_once '../Views/registration_form.php';
    }

    private function validateEditProfile(array $data)
    {
        $errors = [];

        if (isset($data['name'])) {
            if (strlen($data['name']) < 3) {
                $errors['name'] = "Name is too short";
            }
        } else {
            $errors['name'] = "Name is required";
        }

        if (isset($data['email'])) {
            if (strlen($data['email']) < 2) {
                $errors['email'] = 'email must be more than 2 characters';
            } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email must have an @';
            }
        } else {
            $errors['email'] = 'email is required';
        }

        return $errors;
    }

    public function getProfile()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {
            $user = $this->user->getById($_SESSION['userId']);

            require_once '../Views/profile.php';
        } else {
            header('Location: /login');
            exit;
        }
    }

    public function editProfile()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $errors = $this->validateEditProfile($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];

            if (isset($_SESSION['userId'])) {

                $userId = $_SESSION['userId'];

                $users = $this->user->getById($userId);

                if ($users['name'] !== $name) {
                    $this->user->updateNameById($name, $userId);

                    echo "New name: " . $name;
                }

                if ($users['email'] !== $email) {
                    $this->user->updateEmailById($email, $userId);

                    echo "New email: " . $email;
                }
            } else {
                echo 'NO';
            }
        }

        $this->getEditProfileForm();
    }

    public function getEditProfileForm()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];

            $user = $this->user->getById($_SESSION['userId']);
        } else {
            header('Location: /login');
            exit;
        }

        require_once '../Views/edit_profile_form.php';
    }

    private function validateLogin($user, $password)
    {
        $errors = [];

        if ($user === false) {
            $errors['username'] = 'Username or password incorrect';
        } else {
            $passwordDb = $user['password'];

            if (!password_verify($password, $passwordDb)) {
                $errors['password'] = "Username or password incorrect";
            } else {
                session_start();
                $_SESSION['userId'] = $user['id'];
                $_SESSION['userName'] = $user['name'];

                header("Location: ./catalog");
            }
        }

        return $errors;
    }

    public function getLoginForm()
    {
        require_once "../Views/login_form.php";
    }

    public function login()
    {
        $password = $_POST["password"];
        $username = $_POST["username"];

        $user = $this->user->getByEmail($username);

        $errors = $this->validateLogin($user, $password);

        print_r($errors);

        $this->getLoginForm();
    }

    public function logout() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_destroy();
        session_set_cookie_params(-1);
        header("Location: /login");
        exit;
    }
}