<?php

require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/BookDAO.php");


// Verifica se usuário está autenticado
$user = new User();

$userDao = new UserDao($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

$bookDao = new BookDAO($conn, $BASE_URL);

$id = filter_input(INPUT_GET, "id");

if (empty($id)) {

    $message->setMessage("Livro não encontrado.", "error", "index.php");
} else {

    $book = $bookDao->findById($id);

    if (!$book) {

        $message->setMessage("Livro não encontrado.", "error", "index.php");
    }
}

// Verifica se o filme tem imagem 
if (empty($book->image)) {
    $book->image = "book_cover.png";
}

?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $book->title ?></h1>
                <p class="page-description">Altere os dados do livro abaixo</p>
                <form id="edit-book-form" action="<?= $BASE_URL ?>book_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $book->id ?>">
                    <div class="form-group">
                        <label for="title">Título:</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Digite o título do livro" value="<?= $book->title ?>">
                    </div>
                    <div class="form-group">
                        <label for="author">Autor:</label>
                        <input type="text" class="form-control" name="author" id="author" placeholder="Digite o nome do autor" value="<?= $book->author ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem:</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <label for="pages">Páginas:</label>
                        <input type="text" class="form-control" name="pages" id="pages" placeholder="Digite o número de páginas do livro" value="<?= $book->pages ?>">
                    </div>
                    <div class="form-group">
                        <label for="genre">Gênero:</label>
                        <select name="genre" id="category" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Aventura" <?= $book->genre === "Aventura" ? "selected" : "" ?>>Aventura</option>
                            <option value="Ficção Científica" <?= $book->genre === "Ficção Científica" ? "selected" : "" ?>>Ficção Científica</option>
                            <option value="Novela" <?= $book->genre === "Novela" ? "selected" : "" ?>>Novela</option>
                            <option value="Romance" <?= $book->genre === "Romance" ? "selected" : "" ?>>Romance</option>
                            <option value="Suspense" <?= $book->genre === "Suspense" ? "selected" : "" ?>>Suspense</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="critics">Crítica:</label>
                        <input type="text" class="form-control" name="critics" id="critics" placeholder="Insira o link da crítica" value="<?= $book->critics ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição:</label>
                        <textarea name="description" id="description" rows="10" class="form-control" placeholder="Adicione alguma descrição sobre o livro"><?= $book->description ?></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Editar livro">
                </form>
            </div>
            <div class="col-md-3">
                <div class="book-image-container" style="background-image: url('<?= $BASE_URL ?>img/books/<?= $book->image ?>')"></div>
            </div>
        </div>
    </div>
</div>






<?php

require_once("templates/footer.php");

?>