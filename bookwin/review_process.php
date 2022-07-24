<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Book.php");
require_once("models/Review.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/BookDAO.php");
require_once("dao/ReviewDAO.php");

$message = new Message("$BASE_URL");
$userDao = new UserDAO($conn, $BASE_URL);
$bookDao = new BookDAO($conn, $BASE_URL); 
$reviewDao = new ReviewDAO($conn, $BASE_URL); 

// Recebe o tipo de formulário 
$type = filter_input(INPUT_POST, "type");

// Verifica os dados do usuário
$userData = $userDao->verifyToken();

if($type === "create") {

    // Recebe dados do POST
    $rating = filter_input(INPUT_POST, "rating");
    $review = filter_input(INPUT_POST, "review");
    $books_id = filter_input(INPUT_POST, "books_id");
    $users_id = $userData->id;

    $reviewObject = new Review();

    $bookData = $bookDao->findById($books_id);
   
    // Valida se filme existe
    if($bookData) {

        // Verificar dados mínimos
        if(!empty($rating) && !empty($review)  && !empty($books_id)) {

            $reviewObject->rating = $rating;
            $reviewObject->review = $review;
            $reviewObject->books_id = $books_id;
            $reviewObject->users_id = $users_id;
            
            $reviewDao->create($reviewObject);

        } else {

            $message->setMessage("É necessário informar a nota e o comentário.", "error", "back");

        }

   

    } else {

        $message->setMessage("Informações inválidas.", "error", "index.php");
    
    }


} else {

    $message->setMessage("Informações inválidas.", "error", "index.php");

}