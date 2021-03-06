<?php

require_once("models/Review.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

class ReviewDAO implements ReviewDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildReview($data) {

        $reviewObject = new Review();

        $reviewObject->id = $data["id"];
        $reviewObject->rating = $data["rating"];
        $reviewObject->review = $data["review"];
        $reviewObject->users_id = $data["users_id"];
        $reviewObject->books_id = $data["books_id"];

        return $reviewObject;
    }
    public function create(Review $review) {

        $stmt = $this->conn->prepare("INSERT INTO reviews (
            rating, review, books_id, users_id
            ) VALUES (
            :rating, :review, :books_id, :users_id
        )");


        $stmt->bindParam(":rating", $review->rating);
        $stmt->bindParam(":review", $review->review);
        $stmt->bindParam(":books_id", $review->books_id);
        $stmt->bindParam(":users_id", $review->users_id);

        $stmt->execute();

        //Redireciona para o perfil do usuário
        $this->message->setMessage("Comentário adicionado com sucesso.", "success", "index.php");
    }



    public function getBooksReview($id) {

        $reviews = [];

        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE books_id = :books_id");

        $stmt->bindParam(":books_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $reviewsData = $stmt->fetchAll();

            $userDao = new UserDao($this->conn, $this->url);

            foreach ($reviewsData as $review) {

                $reviewObject = $this->buildReview($review);

                // Chamar dados de usuário
                $user = $userDao->findById($reviewObject->users_id);

                $reviewObject->user = $user;

                $reviews[] = $reviewObject;
            }
        }
        return $reviews;
    }

    public function hasAlreadyReviewed($id, $userId) {

        $stmt = $this->conn->prepare("SELECT * FROM reviews 
                                    WHERE books_id = :books_id 
                                    AND users_id = :users_id");

        $stmt->bindParam(":books_id", $id);
        $stmt->bindParam(":users_id", $userId);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getRatings($id) {

        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE books_id = :books_id");

        $stmt->bindParam(":books_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $rating = 0;

            $reviews = $stmt->fetchAll();
            foreach ($reviews as $review) {
                $rating += $review["rating"];
            }

            $rating = $rating / count($reviews);

        } else {

            $rating = "Não avaliado";
        }

        return $rating;
    }
}
