<?php

require_once("models/Book.php");
require_once("models/Message.php");

// Review DAO
require_once("dao/ReviewDAO.php");

class BookDAO implements BookDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildBook($data) {
        $book = new Book();

        $book->id = $data["id"];
        $book->title = $data["title"];
        $book->author = $data["author"];
        $book->description = $data["description"];
        $book->image = $data["image"];
        $book->critics = $data["critics"];
        $book->genre = $data["genre"];
        $book->pages = $data["pages"];
        $book->users_id = $data["users_id"];

        // Recebe as ratings do livro
        $reviewDao = new ReviewDao($this->conn, $this->url);

        $rating = $reviewDao->getRatings($book->id);

        $book->rating = $rating;

        return $book;

    }

    public function getLatestBooks() {

        $books = [];

        $stmt = $this->conn->query("SELECT * FROM books ORDER BY id DESC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $booksArray = $stmt->fetchAll();

            foreach ($booksArray as $book) {
                $books[] = $this->buildBook($book);
            }
        }

        return $books;
    }

    public function getBooksByCategory($genre) {

        $books = [];

        $stmt = $this->conn->prepare("SELECT * FROM books 
                                WHERE genre = :genre 
                                ORDER BY id DESC");

        $stmt->bindParam(":genre", $genre);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $booksArray = $stmt->fetchAll();

            foreach ($booksArray as $book) {
                $books[] = $this->buildBook($book);
            }
        }

        return $books;
    }

    public function getBooksByUserId($id) {

        $books = [];

        $stmt = $this->conn->prepare("SELECT * FROM books 
                                WHERE users_id = :users_id");

        $stmt->bindParam(":users_id", $id);


        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $booksArray = $stmt->fetchAll();

            foreach ($booksArray as $book) {
                $books[] = $this->buildBook($book);
            }
        }

        return $books;
    }

    public function findById($id) {

        $books = [];

        $stmt = $this->conn->prepare("SELECT * FROM books 
                                WHERE id = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $bookData = $stmt->fetch();

            $book = $this->buildBook($bookData);

            return $book;
        } else {

            return false;
        }
    }

    public function findByTitle($title) {

        $books = [];

        $stmt = $this->conn->prepare("SELECT * FROM books 
                                WHERE title LIKE :title");

        $stmt->bindValue(":title", '%'.$title.'%');

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $booksArray = $stmt->fetchAll();

            foreach ($booksArray as $book) {
                $books[] = $this->buildBook($book);
            }
        }

        return $books;
    }
    public function create(Book $book) {

        $stmt = $this->conn->prepare("INSERT INTO books (
            title, author, description, image, critics, genre, pages, users_id
            ) VALUES (
            :title, :author, :description, :image, :critics, :genre, :pages, :users_id
        )");

        $stmt->bindParam(":title", $book->title);
        $stmt->bindParam(":author", $book->author);
        $stmt->bindParam(":description", $book->description);
        $stmt->bindParam(":image", $book->image);
        $stmt->bindParam(":critics", $book->critics);
        $stmt->bindParam(":genre", $book->genre);
        $stmt->bindParam(":pages", $book->pages);
        $stmt->bindParam(":users_id", $book->users_id);

        $stmt->execute();

        //Redireciona para o perfil do usuário
        $this->message->setMessage("Livro adicionado com sucesso.", "success", "index.php");
    }

    public function update(Book $book) {

        $stmt = $this->conn->prepare("UPDATE books SET
        title = :title,
        author = :author,
        description = :description,
        critics = :critics,
        genre = :genre,
        pages = :pages,
        image = :image
        WHERE id = :id");

        $stmt->bindParam(":title", $book->title);
        $stmt->bindParam(":author", $book->author);
        $stmt->bindParam(":description", $book->description);
        $stmt->bindParam(":critics", $book->critics);
        $stmt->bindParam(":genre", $book->genre);
        $stmt->bindParam(":pages", $book->pages);
        $stmt->bindParam(":image", $book->image);
        $stmt->bindParam(":id", $book->id);

        $stmt->execute();

        //Redireciona para o dashboard
        $this->message->setMessage("Livro alterado com sucesso.", "success", "dashboard.php");
    }

    public function destroy($id) {

        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        //Redireciona para o dashboard
        $this->message->setMessage("Livro removido com sucesso.", "success", "dashboard.php");
    }
}
