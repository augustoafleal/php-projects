<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Book.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/BookDAO.php");

$message = new Message("$BASE_URL");
$userDao = new UserDAO($conn, $BASE_URL);
$bookDao = new BookDAO($conn, $BASE_URL);

// Resgata tipo de formulário
$type = filter_input(INPUT_POST, "type");

// Resgata dados do usuário
$userData = $userDao->verifyToken();

if ($type === "create") {

    //Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $author = filter_input(INPUT_POST, "author");
    $description = filter_input(INPUT_POST, "description");
    $critics = filter_input(INPUT_POST, "critics");
    $genre = filter_input(INPUT_POST, "genre");
    $pages = filter_input(INPUT_POST, "pages");

    $book = new Book();

    // Validação de dados
    if (!empty($title) && !empty($author) && !empty($description) && !empty($genre)) {

        $book->title = $title;
        $book->author = $author;
        $book->description = $description;
        $book->critics = $critics;
        $book->genre = $genre;
        $book->pages = $pages;
        $book->users_id = $userData->id;

        // Upload de imagem
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            //Verifica tipo de imagem

            if (in_array($image["type"], $imageTypes)) {

                // Verifica se imagem é jpg
                if (in_array($image["type"], $jpgArray)) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {

                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                // Gera nome da imagem
                $imageName = $book->imageGenerateName();

                imagejpeg($imageFile, "./img/books/" . $imageName, 100);

                $book->image = $imageName;
            } else {

                $message->setMessage("Tipo inválido de imagem. Formatos aceitos: JPEG e PNG.", "error", "back");
            }
        }

        $bookDao->create($book);
    } else {

        $message->setMessage("Adicione ao menos título, autor, descrição e gênero.", "error", "back");
    }
} else if ($type == "delete") {

    // Recebe os dados do form
    $id = filter_input(INPUT_POST, "id");

    $book = $bookDao->findById($id);

    if ($book) {

        // Verifica se o livro é do usuário

        if ($book->users_id === $userData->id) {

            $bookDao->destroy($book->id);
        }
    } else {

        $message->setMessage("Informações inválidas.", "error", "index.php");
    }
} else if ($type === "update") {

    //Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $author = filter_input(INPUT_POST, "author");
    $description = filter_input(INPUT_POST, "description");
    $critics = filter_input(INPUT_POST, "critics");
    $genre = filter_input(INPUT_POST, "genre");
    $pages = filter_input(INPUT_POST, "pages");
    $id = filter_input(INPUT_POST, "id");

    $bookData = $bookDao->findById($id);

    // Verifica se livro foi encontrado
    if ($bookData) {

        // Verifica se o livro é do usuário
        if ($bookData->users_id === $userData->id) {

            // Validação de dados
            if (!empty($title) && !empty($author) && !empty($description) && !empty($genre)) {

                // Editar o livro
                $bookData->title = $title;
                $bookData->author = $author;
                $bookData->description = $description;
                $bookData->critics = $critics;
                $bookData->genre = $genre;
                $bookData->pages = $pages;
                $bookData->id = $id;

                // Upload de imagem
                if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                    $jpgArray = ["image/jpeg", "image/jpg"];

                    //Verifica tipo de imagem
                    if (in_array($image["type"], $imageTypes)) {

                        // Verifica se imagem é jpg
                        if (in_array($image["type"], $jpgArray)) {

                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } else {

                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }

                        // Gera nome da imagem
                        $imageName = $bookData->imageGenerateName();

                        imagejpeg($imageFile, "./img/books/" . $imageName, 100);

                        $bookData->image = $imageName;
                    } else {

                        $message->setMessage("Tipo inválido de imagem. Formatos aceitos: JPEG e PNG.", "error", "back");
                    }
                }

                $bookDao->update($bookData);
            } else {

                $message->setMessage("Adicione ao menos título, autor, descrição e gênero.", "error", "back");
            }
        }
    } else {

        $message->setMessage("Informações inválidas.", "error", "index.php");
    }
} else {

    $message->setMessage("Informações inválidas.", "error", "index.php");
}
