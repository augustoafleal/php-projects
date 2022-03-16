<?php

    include_once("templates/header.php");

?>


    <div class="container" id="view-contact-container">

        <div class="back-edit">
            <?php include_once("templates/backbtn.php"); ?> 
            <?php include_once("templates/editbtn.html"); ?>
        </div>

        <h1 id="main-title"><?= $bill["name"] ?></h1>
        <p class="bold"> Tipo de conta: </p>
        <p><?= $bill["type"]?></p>
        <p class="bold"> Situação </p>

        <?php if($bill["payed"] == "P"): ?>
            <p><em class="fa-solid fa-circle payed-icon"></em> Pago</p>
        
        <?php elseif($bill["payed"] == "W"): ?>
            <p><em class="fa-solid fa-circle wait-icon"></em> Suspenso</p>
        
        <?php elseif($bill["payed"] == "N"): ?>
            <p><em class="fa-solid fa-circle not-icon"></em> Não pago</p>
        
        <?php endif; ?>
        
        <p class="bold"> Ano: </p>
        <p><?= $bill["year"]?></p>
        <?php if($bill["month"] != 0): ?>
        <p class="bold"> Mês: </p>
        <p><?php echo ucfirst(strtolower(monthBox()[$bill["month"] - 1])); ?></p>
        <?php endif; ?>       
        <p class="bold"> Descrição: </p>
        <p><?= $bill["description"] ?></p>
        
        <div class="del-only">
        <?php include_once("templates/deletebtn.php"); ?>
        </div>
                     
    </div>

<?php

    include_once("templates/footer.php");

?>

