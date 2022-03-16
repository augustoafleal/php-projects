<?php
    include_once("config/url.php");
    session_start();
    if(isset($_SESSION['errormsg'])) {
        $printErrorMsg = $_SESSION['errormsg'];
        $_SESSION['errormsg'] = '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elefante</title>
    <link rel="icon" type="image/x-icon" href="<?= $BASE_URL ?>img/elephant.svg">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.min.css" integrity="sha512-T584yQ/tdRR5QwOpfvDfVQUidzfgc2339Lc8uBDtcp/wYu80d7jwBgAxbyMh0a9YM9F8N3tdErpFI8iaGx6x5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>css/styles.css?v=<?php echo time(); ?>">

</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="<?= $BASE_URL ?>index.php">
                <img src="<?= $BASE_URL ?>img/elephant.svg" alt="Elefante">
            </a>
    </nav>
    </header>

    <div class="container-fluid vh-100">

        <?php if(isset($printErrorMsg) && $printErrorMsg != ''): ?>
            <p id='errormsg'><?= $printErrorMsg ?></p>
        <?php endif; ?>
    
            <div class="login">
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-5 col-sm-12 shadow-lg p-5 bg-light">
                        <div class="text-center">
                            <h3 class="text-primary">Entrar</h3>
                        </div>
                        <form action="<?= $BASE_URL ?>config/ope.php" method="POST">
                            <div class="p-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary">
                                        <em class="fa-solid fa-user" id="icon-login"></em></span>
                                    <input type="text" name="user" class="form-control" placeholder="Usuário" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary">
                                        <em class="fa-solid fa-key" id="icon-login"></em></span>
                                    <input type="password" name="pwd" class="form-control" placeholder="Senha" required>
                                </div>
                                <button class="btn btn-primary text-center mt-2" type="submit">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

<?php

    include_once("templates/footer.php");

?>

