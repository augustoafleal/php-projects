<?php

require_once("templates/header.php");

require_once("dao/BookDAO.php");

//DAO livros
$bookDao = new BookDAO($conn, $BASE_URL);

$latestBooks = $bookDao->getLatestBooks();

$fictionBooks = $bookDao->getBooksByCategory("Ficção Científica");
$romanceBooks = $bookDao->getBooksByCategory("Romance");
?>

<div id="main-container" class="container-fluid">

    <h2 class="section-title">Livros novos</h2>
    <p class="section-description">Veja as críticas dos últimos livros adicionados no BookWin</p>
    <div class="books-container">
        <?php foreach ($latestBooks as $book) : ?>
            <?php require("templates/book_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($latestBooks) === 0) : ?>
            <p class="empty-list">Ainda não há livros cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 class="section-title">Ficção Científica</h2>
    <p class="section-description">O que há de melhor em ficção científica</p>
    <div class="books-container">
        <?php foreach ($fictionBooks as $book) : ?>
            <?php require("templates/book_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($fictionBooks) === 0) : ?>
            <p class="empty-list">Ainda não há livros de fição científica cadastrados.</p>
        <?php endif; ?>
    </div>

    <h2 class="section-title">Romance</h2>
    <p class="section-description">Os mais novos romances</p>
    <div class="books-container">
        <?php foreach ($romanceBooks as $book) : ?>
            <?php require("templates/book_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($romanceBooks) === 0) : ?>
            <p class="empty-list">Ainda não há romances cadastrados.</p>
        <?php endif; ?>

    </div>


</div>

<?php

require_once("templates/footer.php");

?>