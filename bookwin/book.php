<?php

require_once("templates/header.php");
require_once("models/Book.php");
require_once("dao/BookDAO.php");
require_once("dao/ReviewDAO.php");

// Obtém id do filme
$id = filter_input(INPUT_GET, "id");

$book;

$bookDao = new BookDAO($conn, $BASE_URL);

$reviewDao = new ReviewDAO($conn, $BASE_URL);

if (empty($id)) {

    $message->setMessage("Livro não encontrado.", "error", "index.php");
} else {

    $book = $bookDao->findById($id);

    if (!$book) {

        $message->setMessage("Livro não encontrado.", "error", "index.php");
    }
}

// Verifica se o livro tem imagem

if (empty($book->image)) {
    $book->image = "book_cover.png";
}

// Verifica se o livro é do usuário

$userOwnsBook = false;

if (!empty($userData)) {

    if ($userData->id === $book->users_id) {
        $userOwnsBook = true;
    }

    // Resgatar as reviews do livro
    $alreadyReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);

}

// Resgatar reviews dos filmes
$bookReviews = $reviewDao->getBooksReview($book->id);

?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 book-container">
            <h1 class="page-title"><?= $book->title ?></h1>
            <p class="book-details">
                <span>Páginas: <?= $book->pages ?></span>
                <span class="pipe"></span>
                <span><?= $book->genre ?></span>
                <span class="pipe"></span>
                <span></span><i class="fas fa-star"></i><?= $book->rating ?></span>
            </p>
            <iframe src="<?= $book->critics ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p><?= $book->description ?></p>
        </div>
        <div class="col-md-4">
            <div class="book-image-container" style="background-image: url('<?= $BASE_URL ?>/img/books/<?= $book->image ?>')"></div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações: </h3>
            <!-- Verifica se habilita a review para o usuário -->
            <?php if (!empty($userData) && !$userOwnsBook && !$alreadyReviewed): ?>
                <div class="col-md-12" id="review-form-container">
                    <h4>Envie sua avaliação:</h4>
                    <p class="page-description">Dê uma nota e faça um comentário sobre o livro.</p>
                    <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
                        <input type="hidden" name="type" value="create">
                        <input type="hidden" name="books_id" value="<?= $book->id ?>">
                        <div class="form-group">
                            <label for="rating">Nota do filme:</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Comentário:</label>
                            <textarea name="review" id="review" rows="3" class="form-control" placeholder="Diga o que pensa sobre o livro..."></textarea>
                        </div>
                        <input type="submit" class="brn card-btn" value="Enviar">
                    </form>
                </div>
            <?php endif; ?>
            <!-- Comentários -->
            <?php foreach ($bookReviews as $review) : ?>

                <?php require("templates/user_review.php"); ?>

            <?php endforeach; ?>

            <?php if (count($bookReviews) == 0) : ?>

                <p class="empty-list">Ainda não há comentários.</p>

            <?php endif; ?>

            <!-- Fim dos Comentários -->
        </div>
    </div>
</div>

<?php

require_once("templates/footer.php")

?>