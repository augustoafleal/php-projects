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

// Atualizr usuário
if($type === "update") {

    // Resgatar dados do usuário 
    $userData = $userDao->verifyToken();
    
    // Receber dados do post
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    // Cria novo usuário
    $user = new User();

    // Preenche os dados do usuário
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        // Verifica tipo de imagem 
        if(in_array($image["type"], $imageTypes)) {

            // Verifica se é jpg
            if(in_array($image["type"], $jpgArray)){
                
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);

            } else {

                $imageFile = imagecreatefrompng($image["tmp_name"]);

            }

            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile, "./img/users/" . $imageName, 100);

            $userData->image = $imageName;

        } else {

            $message->setMessage("Tipo inválido de imagem. Formatos aceitos: JPEG e PNG.", "error", "back");

	}


    }


    $userDao->update($userData);

} else if($type === "changepassword") {

    // Receber dados do post
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    // Resgatar dados do usuário 
    $userData = $userDao->verifyToken();

    $id = $userData->id;
    
    if($password == $confirmpassword){

        $user = new User();

        $finalPassword = $user->generatePassword($password);

        $user->password = $finalPassword;
        $user->id = $id;

        $userDao->changePassword($user);

    } else {

        $message->setMessage("As senhas não são iguais.", "error", "back");


    }




} else {

    $message->setMessage("Informações inválidas.", "error", "index.php");

}
