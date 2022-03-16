<?php

    session_start();

    if((!isset($_SESSION["login"])) && (!isset($_SESSION["pwd"]))){
        header("Location:" . $BASE_URL . "index.php");
    }
    
    include_once("url.php");
    include_once("connection.php");


    $data = $_POST;
    $id = $_SESSION["id"];
    
    if(!empty($data)) {

        if($data["type"] === "pre-create"){
            header("Location:" .$BASE_URL . "../" . $data["gridRadios"] . ".php");
        
        } else if($data["type"] === "pre-manager"){
            header("Location:" .$BASE_URL . "../" . $data["gridRadios"] . ".php");
        
        } else if($data["type"] === "edit") {
        
            $name = $data["name"];
            $payed = $data["situation"];
            $description = $data["description"];
            $pay_id = $data["pay_id"];

            $query = "UPDATE pay_table  
                    SET name = :name, payed = :payed, description = :description
                    WHERE users_id = :id
                    AND pay_id = :pay_id";
    
            $stmt = $conn->prepare($query);
    
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":payed", $payed);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":pay_id", $pay_id);
        
            try {
                
                $stmt->execute();
                $_SESSION["msg"] = "Conta alterada com sucesso.";
        
            } catch(PDOException $e) {
        
                // Erro de conexão
                $error = $e->getMessage();
                echo "Erro: $error";
                
            }

            header("Location:" .$BASE_URL . "../home.php");
        
        }  else if ($_POST["type"] == "createmonthly"){

            $name = $data["name"];
            $type = $data["bill-type"];
            $year = $data["year"];
            $checkbox = $data["checkbox"];
            $j = 1;

            for($i = 0; $i <= 11; $i++){
                if(in_array("gridCheck" . $i, $checkbox)){
                
                $query = "INSERT INTO pay_table (name, type, month, users_id, year, payed) 
                        VALUES (:name, :type, :month, :id, :year, 'N')";

                $stmt = $conn->prepare($query);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":type", $type);
                $stmt->bindParam(":month", $j);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":year", $year);

                    
                    try {
            
                        $stmt->execute();
    
                    } catch(PDOException $e) {
    
                        // Erro de conexão
                        $error = $e->getMessage();
                        echo "Erro: $error";
            
                    }

                }
                $j += 1;
            }

            $_SESSION["msg"] = "Conta criada com sucesso.";
            header("Location:" .$BASE_URL . "../home.php?year=" . $year);

            }  else if ($_POST["type"] === "createyearly"){

                $name = $data["name"];
                $type = $data["bill-type"];
                $year = $data["year"];
                    
                $query = "INSERT INTO pay_table (name, type, month, users_id, year, payed) 
                        VALUES (:name, :type, 0, :id, :year, 'N')";
    
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(":name", $name);
                    $stmt->bindParam(":type", $type);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":year", $year);
    
                        
                    try {
                 
                        $stmt->execute();
                 
                    } catch(PDOException $e) {
                 
                        // Erro de conexão
                        $error = $e->getMessage();
                        echo "Erro: $error";
                 
                    }
                 
                $_SESSION["msg"] = "Conta criada com sucesso.";
                header("Location:" .$BASE_URL . "../home.php?year=" . $year);

        } else if($_POST["type"] === "createtype"){

            $type = $data["category"];

            // CHECAR SE JÁ EXISTE CATEGORIA CADASTRADA 

            $query1 = "SELECT * 
                        FROM pay_table  
                        INNER JOIN users
                        ON id = :id
                        WHERE type = :type
                        AND month != 0";    

            $stmt = $conn->prepare($query1);
        
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":type", $type);
            $stmt->execute();
            $category = $stmt->fetchAll();

            if((is_countable($category)) && (count($category) >= 1)){

                $_SESSION["errormsg"] = "Essa categoria já existe.";
                header("Location:" .$_SERVER['HTTP_REFERER']);
                //header("Location:" .$BASE_URL . "../home.php");
            
            } else {

                $query2 = "INSERT INTO pay_table (type, users_id, month) 
                        VALUES (:type, :id, 13)";

                $stmt = $conn->prepare($query2);
                $stmt->bindParam(":type", $type);
                $stmt->bindParam(":id", $id);

                try {
            
                    $stmt->execute();

                } catch(PDOException $e) {

                    // Erro de conexão
                    $error = $e->getMessage();
                    echo "Erro: $error";
        
                }
            
            $_SESSION["msg"] = "Categoria criada com sucesso.";
            header("Location:" .$BASE_URL . "../home.php");

            }
            
        } else if ($_POST["type"] == "deletetype"){

            $type = $data["bill-type"];

            // CHECAR SE JÁ EXISTE CATEGORIA CADASTRADA 

            $query1 = "SELECT * 
                        FROM pay_table  
                        INNER JOIN users
                        ON id = :id
                        WHERE type = :type
                        AND month != 0";    

            $stmt = $conn->prepare($query1);
        
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":type", $type);
            $stmt->execute();
            $category = $stmt->fetchAll();

            if((is_countable($category)) && (count($category) > 1)){

                $_SESSION["errormsg"] = "Essa categoria não pode ser deletada porque possui cadastros inseridos.";
                header("Location:" .$_SERVER['HTTP_REFERER']);
                //header("Location:" .$BASE_URL . "../home.php")

            } else {
    
                    $query2 = "DELETE FROM pay_table 
                            WHERE users_id = :id
                            AND type = :type
                            AND month != 0";
    
                    $stmt = $conn->prepare($query2);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":type", $type);
    
                    try {
                
                        $stmt->execute();
    
                    } catch(PDOException $e) {
    
                        // Erro de conexão
                        $error = $e->getMessage();
                        echo "Erro: $error";
            
                    }
                
                $_SESSION["msg"] = "Categoria deletada com sucesso.";
                header("Location:" .$BASE_URL . "../home.php");
    
                }

            } else if ($_POST["type"] == "deletetypeyearly"){

                $type = $data["bill-type"];
    
                // CHECAR SE JÁ EXISTE CATEGORIA CADASTRADA 
    
                $query1 = "SELECT * 
                            FROM pay_table  
                            INNER JOIN users
                            ON id = :id
                            WHERE type = :type
                            AND month = 0";    
    
                $stmt = $conn->prepare($query1);
            
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":type", $type);
                $stmt->execute();
                $category = $stmt->fetchAll();
    
                if((is_countable($category)) && (count($category) > 1)){
    
                    $_SESSION["errormsg"] = "Essa categoria não pode ser deletada porque possui cadastros inseridos.";
                    header("Location:" .$_SERVER['HTTP_REFERER']);
                    //header("Location:" .$BASE_URL . "../home.php")
    
                } else {
        
                    $query2 = "DELETE FROM pay_table 
                            WHERE users_id = :id
                            AND type = :type
                            AND month = 0";
   
                    $stmt = $conn->prepare($query2);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":type", $type);
   
                    try {
               
                        $stmt->execute();
   
                    } catch(PDOException $e) {
   
                        // Erro de conexão
                        $error = $e->getMessage();
                        echo "Erro: $error";
           
                    }
                    
                    $_SESSION["msg"] = "Categoria deletada com sucesso.";
                    header("Location:" .$BASE_URL . "../home.php");
        
                    }

            } else if ($_POST["type"] === "createtypeyearly"){
            
                $type = $data["category"];
            
                // CHECAR SE JÁ EXISTE CATEGORIA CADASTRADA 
            
                $query1 = "SELECT * 
                            FROM pay_table  
                            INNER JOIN users
                            ON id = :id
                            WHERE type = :type
                            AND month = 0";    
        
                $stmt = $conn->prepare($query1);
            
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":type", $type);
                $stmt->execute();
                $category = $stmt->fetchAll();
                
                if((is_countable($category)) && (count($category) >= 1)){
                
                    $_SESSION["errormsg"] = "Essa categoria já existe.";
                    header("Location:" .$_SERVER['HTTP_REFERER']);
                    //header("Location:" .$BASE_URL . "../home.php");
                
                } else {
                
                    $query2 = "INSERT INTO pay_table (type, users_id, month) 
                            VALUES (:type, :id, 0)";
        
                    $stmt = $conn->prepare($query2);
                    $stmt->bindParam(":type", $type);
                    $stmt->bindParam(":id", $id);
                
                    try {
                    
                        $stmt->execute();
                    
                    } catch(PDOException $e) {
                    
                        // Erro de conexão
                        $error = $e->getMessage();
                        echo "Erro: $error";
                    
                    }
                
                $_SESSION["msg"] = "Categoria criada com sucesso.";
                header("Location:" .$BASE_URL . "../home.php");
                
                }
                
            } else if($data["type"] == "delete") { 

                $pay_id = $data["pay_id"];
        
                $query = "DELETE FROM pay_table 
                        WHERE users_id = :id
                        AND pay_id = :pay_id";
        
                $stmt = $conn->prepare($query);
        
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":pay_id", $pay_id);
        
                try {
                    
                    $stmt->execute();
                    $_SESSION["msg"] = "Contato removido com sucesso.";
                    if($data["condition"] == "del-button"){

                        header("Location:" .$BASE_URL . "../home.php");
                    } else { 
                        header("Location:" . $_SERVER['HTTP_REFERER']);
                    }
            
                } catch(PDOException $e) {
            
                    // Erro de conexão
                    $error = $e->getMessage();
                    echo "Erro: $error";
                 
                }
        
            }
        

    } else {

        
        if(empty($_GET["month"])){
            $month = 1;
        } else {
            $month = $_GET["month"];
        }
        if(empty($_GET["year"])){
            $year = date("Y", time());
        } else {
            $year = $_GET["year"];
        }
       if(empty($_GET["payid"])){
            $payid = "";
       }else{
           $payid = $_GET["payid"];
       }


        function monthWord($month){
            $arrayMonth = array("JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO",
            "NOVEMBRO", "DEZEMBRO");
            return $arrayMonth[$month-1];  
        } 

        function monthBox(){
            return $arrayMonth = array("JANEIRO", "FEVEREIRO", "MARçO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO",
            "NOVEMBRO", "DEZEMBRO");
        } 

        function forYear($BASE_URL, $year){
            if(!empty($_GET["year"])){
                $year = $_GET["year"];
                return "$BASE_URL" . "home.php?year=" . "$year";
            } else {
                return "$BASE_URL" . "home.php?year=" . "$year";
            }
        }

      /*  function forYearMonth($BASE_URL, $id, $year, $month){
            if((!empty($_GET["year"])) && (!empty($GET_["month"]) && (!empty($GET_["id"])))){
                $year = $_GET["year"];
                $month = $_GET["month"];
                $id = 1;
                return "$BASE_URL" . "show.php?id=" . "$id" . "&year=" . "$year" . "&month=" . "$month";
            } else {
                return "$BASE_URL" . "show.php?id=" . "$id" . "&year=" . "$year" . "&month=" . "$month";
            }
        }*/

            if(str_contains($_SERVER['REQUEST_URI'], "createmonthly") || ((str_contains($_SERVER['REQUEST_URI'], "createtype")) && (!str_contains($_SERVER['REQUEST_URI'], "createtypeyearly")))){ 

                $query2 = "SELECT type, month
                FROM pay_table  
                INNER JOIN users
                ON id = :id
                AND month != 0";      

                $stmt = $conn->prepare($query2);
        
                $stmt->bindParam(":id", $id);

                $stmt->execute();
    
                $billsForSelect = $stmt->fetchAll();
            
            } else if(str_contains($_SERVER['REQUEST_URI'], "createyearly") || (str_contains($_SERVER['REQUEST_URI'], "createtypeyearly"))){
                
                $query2 = "SELECT type, month
                FROM pay_table  
                INNER JOIN users
                ON id = :id
                AND month = 0";      

                $stmt = $conn->prepare($query2);
        
                $stmt->bindParam(":id", $id);

                $stmt->execute();
    
                $billsForSelect = $stmt->fetchAll();


            } else if (!empty($payid)){

                $query3 = "SELECT * 
                        FROM pay_table  
                        INNER JOIN users
                        ON users_id = :id
                        WHERE pay_id = :payid";      


                $stmt = $conn->prepare($query3);

                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":payid", $payid);

                $stmt->execute();

                $bill = $stmt->fetch();


            
            } else {

               $bills = "";

               $query = "SELECT name, type, description, users.id, month, year, payed, pay_id
                       FROM pay_table  
                       INNER JOIN users
                       ON users_id = id
                       WHERE id = :id
                       AND (month = :month OR month = 0)
                       AND year = :year
                       AND type IS NOT NULL
                       AND name IS NOT NULL
                       ORDER BY month DESC,
                       type ASC,
                       name ASC";      


               $stmt = $conn->prepare($query);

               $stmt->bindParam(":id", $id);
               $stmt->bindParam(":month", $month);
               $stmt->bindParam(":year", $year);

               $stmt->execute();

               $bills = $stmt->fetchAll();

        
            }
}
/* USAR PARA VALIDAR SE ESTÁ NO LOCAL CERTO 
<?php if(str_contains($_SERVER['REQUEST_URI'], "createmonthly")){
    echo "TESTE";
}
?> */

// FECHAR CONEXÃO

$conn = null;