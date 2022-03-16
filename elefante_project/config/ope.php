<?php

    include_once("config/url.php");
    session_start();

    // RECEBE VALORES
    $login = $_POST["user"];
    $pwd = $_POST["pwd"];

    // CONECTA COM O BANCO
    $host = "";
    $dbname = "";
    $user = "";
    $pass = "";

    try {

        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

        // Ativar o modo de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {

        // Erro de conexão
        $error = $e->getMessage();
        echo "Erro: $error";
        
    }

    // PESQUISA VALORES NO BANCO
    $query = "SELECT * 
            FROM users  
            WHERE username = :login
            AND password = :pwd";    
        
            $stmt = $conn->prepare($query);
            
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":pwd", $pwd);
            $stmt->execute();
            $result = $stmt->fetchAll();

    // VERIFICA SE O LOGIN ESTÁ CORRETO
    if(is_countable($result) && (count($result) === 1)){
        $_SESSION["login"] = $login;
        $_SESSION["pwd"] = $pwd;

        
        $query2 = "SELECT * 
            FROM users  
            WHERE username = :login
            AND password = :pwd";    
        
            $stmt = $conn->prepare($query2);
            
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":pwd", $pwd);
            $stmt->execute();
            $result2 = $stmt->fetch();

            $_SESSION["id"] = $result2["id"];

        header("Location:" .$BASE_URL . "../home.php");

    } else {
        unset($_SESSION["login"]);
        unset($_SESSION["pwd"]);
        $_SESSION['errormsg'] = "Login ou senha inválido.";
        header("Location:" .$BASE_URL . "../index.php");
    }