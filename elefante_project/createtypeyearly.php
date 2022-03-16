<?php

    include_once("templates/header.php");

?>

 
<div class="container">
    <?php if(isset($printErrorMsg) && $printErrorMsg != ''): ?>
        <p id='errormsg'><?= $printErrorMsg ?></p>
    <?php endif; ?>

    <div class="back-only">
    <?php include_once("templates/backbtn.php"); ?>
    </div>
    
    <h1 id="main-title">Inserir categoria</h1>

        <form id="createtype-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="createtypeyearly">
            <div class="form-group">
                <label for="name"> Nome da categoria: </label>
                <input type="text" class="form-control" id="type" name="category" placeholder="Digite a categoria" required>
            </div>
           
                <button type="submit" class="btn btn-primary" id="btn-submit">Cadastrar</button>
        </form>
                        
        <h1 id="main-title">Deletar categoria</h1>
        
        <form id="deletetype-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="deletetypeyearly">
        <div class="form-group">
            <label for="name">Escolha a categoria para ser apagada:</label>
            <select class="form-control" name="bill-type" id="bill-type">
                    <?php $already_used = array(); $counter = 0 ?>
                        <?php foreach($billsForSelect as $bill): ?>
                            <?php if(!in_array($bill["type"], $already_used)): ?>
                                <option value="<?= $bill["type"] ?>"><?= $bill["type"] ?></option>
                                <?php $already_used[] = $bill["type"]; $counter += 1; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
            </select>
        </div>
        
            <button type="submit" class="btn btn-danger" id="btn-submit">Deletar</button>
        </form> 

</div>
    

<?php

    include_once("templates/footer.php");

?>

