<h1>Estoque</h1>
<?php if($add_permission==true): ?>
    <a href="<?php echo BASE_URL;?>/inventory/add">
        <div class="button">
            Adicionar Produto
        </div>
    </a>
<?php endif; ?>
<input type="text" name="busca" id="busca" data-type="search_inventory" />
<table border="0" width="100%">
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Quant.</th>
        <th>Quant.Mínima</th>
        <th>Ações</th>
    </tr>

        <?php foreach($inventory_list as $product): ?>
            <tr>
                <td>
                    <?php echo $product['name']; ?>
                </td>
                <td>
                    R$<?php echo number_format($product['price'], 2, ',', '.'); ?>
                </td>
                <td  width="60" style="text-align:center">
                    <?php echo $product['quant']; ?>
                </td>
                <td width="40" style="text-align:center">
                    <?php
                        if($product['min_quant'] > $product['quant']) {
                            echo '<span style="color:red;">' . ($product['min_quant']) . '</span>';
                        }else{
                            echo $product['min_quant'];
                        }
                        ?>
                </td>
                <td width="160">
                    <a href="<?php echo BASE_URL; ?>/inventory/edit/<?php echo $product['id']; ?>">
                        <div class="button button_small">Editar</div>
                    </a>
                    <a href="<?php echo BASE_URL; ?>/inventory/delete/<?php echo $product['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                        <div class="button button_small">Excluir</div>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tr>
</table>
