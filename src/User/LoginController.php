<?php

namespace App\User;

use App\Core\Controller;

class LoginController extends Controller
{
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function login()
    {
        $error = null;

        if (!empty($_POST["username"]) AND !empty($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $user = $this->usersRepository->findByUserName($username);

            if (!empty($user)) {
                if ($user->password === $password) {
                    echo "Login erfolgreich!";
                    die();
                } else {
                    $error = "Passwörter stimmen nicht überein.";
                }
            } else {
                $error = "Der Nutzer konnte nicht gefunden werden.";
            }
        }

        $this->render("user/login", [
            "error" => $error
        ]);
    }
}