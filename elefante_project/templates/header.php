<?php

    include_once("config/url.php");
    include_once("config/process.php");

    // Limpar mensagem
    if(isset($_SESSION['msg'])) {
        $printMsg = $_SESSION['msg'];
        $_SESSION['msg'] = '';
    }
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
            <a class="navbar-brand" href="<?= $BASE_URL ?>home.php">
                <img src="<?= $BASE_URL ?>img/elephant.svg" alt="Elefante">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= $BASE_URL ?>home.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>pre_create.php">Adicionar conta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE_URL ?>pre_manager.php">Gerenciar categorias</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mês de referência 
                        </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=1" ?>">Janeiro</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=2" ?>">Fevereiro</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=3" ?>">Março</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=4" ?>">Abril</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=5" ?>">Maio</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=6" ?>">Junho</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=7" ?>">Julho</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=8" ?>">Agosto</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=9" ?>">Setembro</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=10" ?>">Outubro</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=11" ?>">Novembro</a>
                                <a class="dropdown-item" href="<?= forYear($BASE_URL, $year) . "&month=12" ?>">Dezembro</a>
                            </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $year ?> 
                        </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php $years = range(2020, date("Y", time())); foreach ($years as $yearrange): ?>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>home.php?year=<?= $yearrange ?>"> <?= $yearrange ?></a>
                                <?php endforeach; ?>
                            </div>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto" id">
                    <li>
                        <a class="nav-link"  href="<?= $BASE_URL ?>logout.php" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
