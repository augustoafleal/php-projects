<?php

require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");

// Verifica se usuário está autenticado
$user = new User();

$userDao = new UserDao($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);


?>

    <div id="main-container" class="container-fluid">
        
        <div class="offset-md-4 col-md-4 new-book-container">
            <h1 class="page-title">Adicionar Livro</h1>
            <p class="page-description">Compartilhe sua crítica!</p>
            <form action="<?= $BASE_URL ?>book_process.php" id="add-book-form" method="POST"
            enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Digite o título do livro">
                </div>
                <div class="form-group">
                    <label for="author">Autor:</label>
                    <input type="text" class="form-control" name="author" id="author" placeholder="Digite o nome do autor">
                </div>
                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label for="pages">Páginas:</label>
                    <input type="text" class="form-control" name="pages" id="pages" placeholder="Digite o número de páginas do livro">
                </div>
                <div class="form-group">
                    <label for="genre">Gênero:</label>
                    <select name="genre" id="category" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Aventura">Aventura</option>
                        <option value="Ficção Científica">Ficção Científica</option>
                        <option value="Novela">Novela</option>
                        <option value="Romance">Romance</option>
                        <option value="Suspense">Suspense</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="critics">Crítica:</label>
                    <input type="text" class="form-control" name="critics" id="critics" placeholder="Insira o link da crítica">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" rows="10" class="form-control" placeholder="Adicione alguma descrição sobre o livro"></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar livro">
            </form>
        </div>




    </div>

<?php

require_once("templates/footer.php");

?>
  
