<h1>Produtos - Editar</h1>

<?php if(isset($error_msg) && !empty($error_msg)): ?>
    <div class="warn"><?php echo $error_msg ?></div>
<?php endif; ?>

<form method="POST">

    <label for="name" >Nome</label><br/>
    <input type="text" name="name" required
        value="<?php echo $inventory_info['name']; ?>"
    /><br/><br/>

    <label for="price" >Preço</label><br/>
    <input type="text" name="price"
           value="<?php echo number_format($inventory_info['price'], 2); ?>"
           required/><br/><br/>

    <label for="quant" >Quantidade em estoque</label><br/>
    <input type="number" name="quant"
           value="<?php echo $inventory_info['quant']; ?>"
           required /><br/><br/>

    <label for="min_quant" >Quantidade mínima em estoque em estoque</label><br/>
    <input type="number" name="min_quant"
           value="<?php echo $inventory_info['min_quant']; ?>"
           required /><br/><br/>



    <input type="submit" value="Salvar">
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script_inventory_add.js"></script>
