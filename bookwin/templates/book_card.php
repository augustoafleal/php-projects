<?php 

    if(empty($book->image)) {
        $book->image = "book_cover.png";
    }
?>

<div class="card book-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/books/<?= $book->image ?>')"></div>
    <div class="card-body">
        <p class="card-rating">
            <i class="fas fa-star"></i>
            <span class="rating"><?= $book->rating ?></span>
        </p>
        <h5 class="card-title">
            <a href="<?= $BASE_URL ?>book.php?id=<?= $book->id ?>"><?= $book->title ?></a>
        </h5>
    
            <h4 class="card-author"><?= $book->author ?></h4>
        
        <a href="<?= $BASE_URL ?>book.php?id=<?= $book->id ?>" class="btn btn-primary rate-btn">Avaliar</a>
        <a href="<?= $BASE_URL ?>book.php?id=<?= $book->id ?>" class="btn btn-primary card2-btn">Conhecer</a>
    </div>
</div>