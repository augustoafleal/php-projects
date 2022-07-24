<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message("$BASE_URL");
$userDao = new UserDAO($conn, $BASE_URL);

// Resgatar formulário
$type = filter_input(INPUT_POST, "type");

// Veririficar tipo de formulário
if ($type === "register") {

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    // Verificações de dados
    if ($name && $lastname && $email && $password) {

        // Verificar a confirmação de senha
        if ($password === $confirmpassword) {

            // Verificar se o e-mail já está cadastrado no sistema
            if ($userDao->findByEmail($email) === false) {

                $user = new User();

                // Criação de token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
            } else {

                $message->setMessage("E-mail já cadastrado. Por favor, tente outro.", "error", "back");
            }
        } else {

            $message->setMessage("As senhas não são iguais.", "error", "back");
        }
    } else {

        $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
    }
} else if ($type === "login") {

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    // Tenta autenticação
    if ($userDao->authenticateUser($email, $password)) {

        $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

        // Redireciona quando não autenticar
    } else {

        $message->setMessage("Usuário e/ou senha incorretos.", "error", "back");

    }
} else {

    $message->setMessage("Informações inválidas.", "error", "index.php");

}
