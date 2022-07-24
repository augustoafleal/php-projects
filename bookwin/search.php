<?php

require_once("templates/header.php");

require_once("dao/BookDAO.php");

//DAO livros
$bookDao = new BookDAO($conn, $BASE_URL);

// Resgata busca do usuário

$q = filter_input(INPUT_GET, "q");

$books = $bookDao->findByTitle($q);

?>

<div id="main-container" class="container-fluid">

    <h2 class="section-title" id="search-title">Buscando por: <span id="search-result"><?= $q ?></span></h2>
    <p class="section-description">Resultados da busca com base em sua pesquisa:</p>
    <div class="books-container">
        <?php foreach ($books as $book): ?>
            <?php require("templates/book_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($books) === 0) : ?>
            <p class="empty-list">Não há livros para esta busca, <a href="<?= $BASE_URL ?>" class="back-link">voltar</a>.</p>
        <?php endif; ?>
    </div>

</div>

<?php

require_once("templates/footer.php");

?>