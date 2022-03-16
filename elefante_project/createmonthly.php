<?php

    include_once("templates/header.php");

?>
    
<div class="container">
    
    <div class="back-only">
    <?php include_once("templates/backbtn.php"); ?>
    </div>

    <h1 id="main-title">Inserir conta mensal</h1>

        <form id="createmonthly-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="createmonthly">
            <div class="form-group">
                <label for="name"> Nome da conta: </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome" required>
            </div>
            <div class="form-group">
                <label for="bill-type"> Escolha o tipo de conta: </label>
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
            <div class="form-group">
                <label for="year"> Escolha o ano: </label>
                    <select class="form-control" name="year" id="year">
                        <?php $years = range(2020, date("Y", time())); foreach ($years as $yearrange): ?>
                            <option value="<?= $yearrange ?>"><?= $yearrange ?></option>
                        <?php endforeach; ?>
            </select>
            </div>
            <div class="form-group">
            Escolha os meses:
            </div>
            <div class="form-row">
                <?php $counter = 0 ?>
                <?php foreach(monthBox() as $months): ?>
                    <div class="col-3">
                        <label class="form-check-label" for="gridCheck">
                        <input class="form-check-input" type="checkbox" name="checkbox[]" id="gridCheck" value="gridCheck<?= $counter ?>" checked>
                        <?php echo ucfirst(strtolower((monthBox()[$counter]))); $counter += 1; ?>
                        <?php ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
                <button type="submit" class="btn btn-primary" id="btn-submit">Cadastrar</button>
        </form>

</div>
    

<?php

    include_once("templates/footer.php");

?>

