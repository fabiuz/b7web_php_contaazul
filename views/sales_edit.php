<h1>Vendas - Editar</h1>

<strong>Nome do Cliente</strong>
<?php echo $sales_info['info']['client_name']; ?><br/><br/>

<strong>Data da venda</strong>
<?php echo date('d/m/Y', strtotime($sales_info['info']['date_sale'])); ?><br/><br/>

<strong>Total da venda</strong>
R$ <?php echo number_format($sales_info['info']['total_price'], 2, ',', '.'); ?>
<br/><br/>

<strong>Status da venda</strong><br/>

<?php if($permission_edit): ?>
    <form method="POST">
        <select name="status">
            <?php foreach($statuses as $statusKey => $statusValue): ?>
                <option value="<?php echo $statusKey;?>"
                        <?php echo($statusKey==$sales_info['info']['status']) ?'selected="selected"':''; ?>
                >
                    <?php echo $statusValue; ?>
                </option>
            <?php endforeach; ?>
        </select><br/><br/>
        <input type="submit" value="Salvar"/>
    </form>

<?php else: ?>
    <?php echo $statuses[$sales_info['info']['status']]; ?>
<?php endif; ?>
<br/><br/>


<hr/>
<table border="0" width="100%">
    <tr>
        <th>Nome do produto</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Preço total</th>
    </tr>
    <?php foreach($sales_info['products'] as $productitem): ?>
        <tr align="center">
            <td><?php echo $productitem['name']; ?></td>
            <td><?php echo $productitem['quant']; ?></td>
            <td>
                R$ <?php echo number_format($productitem['sale_price'], 2, ',', '.'); ?>
            </td>
            <td>
                R$ <?php echo number_format($productitem['sale_price'] * $productitem['quant'] , 2, ',', '.'); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
