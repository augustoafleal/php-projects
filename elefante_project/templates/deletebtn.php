<div id="back-link-container"> 
    
    <form class="delete-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
            <input type="hidden" name="type" value="delete">
            <input type="hidden" name="condition" value="del-button">
            <input type="hidden" name="pay_id" value="<?= $bill["pay_id"] ?>">
            <button type="submit" class="btn btn-danger btn-sm" id="btn-del" onclick="return confirm('Tem certeza que deseja deletar esta conta?')">Deletar</button>
    </form> 
</div>