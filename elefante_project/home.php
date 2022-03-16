<?php

    include_once("templates/header.php");

?>

    <div class="container">
        <?php if(isset($printMsg) && $printMsg != ''): ?>
            <p id='msg'><?= $printMsg ?></p>
        <?php endif; ?>

        <?php if(isset($printErrorMsg) && $printErrorMsg != ''): ?>
            <p id='errormsg'><?= $printErrorMsg ?></p>
        <?php endif; ?>

        <?php if(count($bills) > 0): ?>

            <h1 id="month"><?= monthWord($month); ?></h1>

            <?php $already_used = array(); ?>

            <?php foreach($bills as $bill): ?>
                <?php if(!in_array($bill["type"], $already_used)): ?>
                <h1 id="main-title"> <?= $bill["type"] ?> </h1>

                <div class="table-responsive">
                    <table class="table table-hover" id="bills-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <?php $already_used[] = $bill["type"]; ?>
                        
                        <tbody>
                            <?php foreach($bills as $bill2): ?>
                                <?php if($bill2["type"] == $bill["type"]): ?>
                                    <tr>
                                            <?php if($bill2["payed"] === "P"): ?>
                                                <th scope="row"><em class="fa-solid fa-circle payed-icon"></em></th>
                                            <?php elseif($bill2["payed"] === "W"): ?>
                                                <th scope="row"><em class="fa-solid fa-circle wait-icon"></em></th>
                                            <?php elseif($bill2["payed"] === "N"): ?>
                                                <th scope="row"><em class="fa-solid fa-circle not-icon"></em></th>
                                            <?php endif; ?>
                                            
                                            <?php if(!is_null($bill2["name"]) && mb_strlen($bill2["name"], 'UTF-8') > 13): ?>
                                                <td class="col-id" id="name-mobile"><?= substr($bill2["name"], 0, 12) . "..." ?></td>
                                            <?php else: ?>
                                                <td class="col-id" id="name-mobile"><?= $bill2["name"] ?></td>
                                            <?php endif; ?>                                           
                                                                                        
                                            <td class="col-id" id="name-normal"><?= $bill2["name"] ?></td> 

                                            <td><?= $bill2["description"] ?></td>
                                            <td class="actions">
                                                <a href="<?= $BASE_URL ?>show.php?id=1&payid=<?= $bill2["pay_id"] ?>"><i class="fas fa-eye check-icon" id="show_home"></i></a>
                                                <a href="<?= $BASE_URL ?>edit.php?id=1&payid=<?= $bill2["pay_id"] ?>"><i class="fas fa-edit edit-icon" id="edit_home"></i></a>
                                                <form class="delete-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
                                                    <input type="hidden" name="type" value="delete">
                                                    <input type="hidden" name="pay_id" value="<?= $bill2["pay_id"] ?>">
                                                    <button type="submit" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar esta conta?')"><i class="fas fa-times delete-icon"></i></button>
                                                </form> 
                                            </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
              
        <?php else: ?>
            <p id="empty-list-text">Não há contatos cadastrados em sua agenda, <a href="<?= $BASE_URL ?>pre_create.php">
            clique aqui para adicionar</a>.</p>
        <?php endif; ?>

    </div>
                 
<?php

    include_once("templates/footer.php");

?>

