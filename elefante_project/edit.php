<?php

    include_once("templates/header.php");

?>

<div class="container">

    <div class="back-only">
        <?php include_once("templates/backbtn.php"); ?>
    </div>

    <h1 id="main-title">Editar conta</h1>
        <form id="edit-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="edit">
            <input type="hidden" name="pay_id" value="<?= $bill["pay_id"] ?>">
            <div class="form-group">
                <label for="name"> Nome da conta: </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome" value="<?= $bill["name"] ?>" required>
            </div>
            <div class="form-group">
                <label for="situation"> Escolha a situação: </label>
                    <select class="form-control" name="situation" id="situation">
                        <option value="N">Não pago</option>
                        <option value="P">Pago</option>
                        <option value="W">Suspenso</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="observations"> Descrição: </label>
                <textarea type="text" class="form-control" id="description" name="description" rows="3"><?= $bill["description"] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        
        </form>

</div>
    
<?php

    include_once("templates/footer.php");

?>

