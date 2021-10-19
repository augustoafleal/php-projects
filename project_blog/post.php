<?php 

    include_once("templates/header.php");

    if(isset($_GET['id'])){

        $postId = $_GET['id'];
        $currentPost;

        foreach($posts as $post) {

            if($post['id'] == $postId){

                $currentPost = $post;
            }
        }
    }

?>
    <main id="post-container">
        <div class="contet-container">
            <h1 id="main-title"><?= $currentPost['title'] ?></h1>
            <p id="post-description"><?= $currentPost['description'] ?></p>
            <div class="img-container">
                <img src="<?= $BASE_URL ?>/img/<?= $currentPost['img'] ?>" alt="<?= $currentPost['title'] ?>">
            </div>
            <p class="post-content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime harum optio deserunt consequatur cum magnam, sit voluptates quae quos quisquam laboriosam, voluptatibus sed! Ullam quos sapiente at nisi impedit consequatur.
            Assumenda ut aliquam voluptate eos non explicabo ad illo dolores facilis numquam animi odit possimus quasi rem modi aliquid officiis veniam unde iure, obcaecati deleniti, delectus minus dolor beatae. Aspernatur!
            Delectus culpa tempora enim aspernatur exercitationem excepturi cupiditate! Saepe repellendus id quas voluptatum, nulla quisquam assumenda explicabo atque inventore ratione dignissimos, ad cumque exercitationem itaque vel consequatur, voluptatibus vitae unde.
            Neque illo laudantium aliquam enim aut eaque aspernatur error magni doloremque, officiis, perferendis tempore architecto beatae, minima voluptas dolorum itaque quia eligendi hic quo similique. Accusamus natus quas amet in.
            Tempore saepe sed repellendus, optio aperiam nihil expedita provident reiciendis atque voluptas est error. Corrupti beatae commodi, nobis deserunt molestiae, asperiores repellendus autem maxime, alias quam reprehenderit ullam excepturi.</p>
            <p class="post-content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime harum optio deserunt consequatur cum magnam, sit voluptates quae quos quisquam laboriosam, voluptatibus sed! Ullam quos sapiente at nisi impedit consequatur.
            Assumenda ut aliquam voluptate eos non explicabo ad illo dolores facilis numquam animi odit possimus quasi rem modi aliquid officiis veniam unde iure, obcaecati deleniti, delectus minus dolor beatae. Aspernatur!
            Delectus culpa tempora enim aspernatur exercitationem excepturi cupiditate! Saepe repellendus id quas voluptatum, nulla quisquam assumenda explicabo atque inventore ratione dignissimos, ad cumque exercitationem itaque vel consequatur, voluptatibus vitae unde.
            Neque illo laudantium aliquam enim aut eaque aspernatur error magni doloremque, officiis, perferendis tempore architecto beatae, minima voluptas dolorum itaque quia eligendi hic quo similique. Accusamus natus quas amet in.
            Tempore saepe sed repellendus, optio aperiam nihil expedita provident reiciendis atque voluptas est error. Corrupti beatae commodi, nobis deserunt molestiae, asperiores repellendus autem maxime, alias quam reprehenderit ullam excepturi.</p>
        </div>
        <aside id="nav-container"> 
            <h3 id="tags-title">Tags</h3>
                <ul id="tag-list">
                    <?php foreach($currentPost['tags'] as $tag): ?>
                        <li><a href="#"><?= $tag ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <h3 id="categories-title">Categorias</h3>
                <ul id="categories-list">
                    <?php foreach($categories as $category): ?>
                        <li><a href="#"><?= $category ?></a></li>
                    <?php endforeach; ?>
                </ul>
        </aside>
    </main>

<?php

    include_once("templates/footer.php")

?>