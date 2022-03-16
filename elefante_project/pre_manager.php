<?php

    include_once("templates/header.php");

?>

    <div class="container">

        <div class="back-only">
            <?php include_once("templates/backbtn.php"); ?>
        </div>

    <div class="form-group">
    
    <h1 id="main-title">Escolha uma opção:</h1>
    
        <form id="pre-create-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="pre-manager">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios" id="createmonthly" value="createtype" checked>
                                <label class="form-check-label" for="gridRadios1">
                                    Mensal
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios" id="createyearly" value="createtypeyearly">
                                <label class="form-check-label" for="gridRadios2">
                                Anual
                            </label>
                        </div>
                    </div>
                </div>
            <div class="form-group row" >
                <div class="col-sm-10">
                    <button type="submit" id="btn-submit" class="btn btn-primary">Próximo</button>
                </div>
            </div>
        </form>
    </div>
    </div>
   
<?php

    include_once("templates/footer.php");

?>

