<?php
  if(!empty($_SERVER['HTTP_REFERER'])){
    $url = "#";
  }
  else{
    $url =  $BASE_URL . "home.php";
  }
?>

<div id="back-link-container"> 
    
    <a href="<?= $url ?>" id="back-link" onclick="history.go(-1)"> Voltar </a>

</div>