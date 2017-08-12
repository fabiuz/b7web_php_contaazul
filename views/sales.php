<h1>Vendas</h1>

 <?php //if($edit_permission==true): ?>
    <a href="<?php echo BASE_URL;?>/sales/add">
        <div class="button">
            Adicionar Venda
        </div>
    </a>
<?php //endif; ?>

<table border="0" width="100%">
    <tr>
        <th>
            Cliente
        </th>
        <th>
            Data
        </th>
        <th>
            Status
        </th>
        <th>
            Valor
        </th>
        <th>Ações</th>
    </tr>
    <?php foreach($sales_list as $sale_item): ?>
    <tr align="center">
        <td>
            <?php echo $sale_item['name']; ?>
        </td>
        <td>
            <?php echo date('d/m/Y', strtotime($sale_item['date_sale'])); ?>
        </td>
        <td>
            <?php echo $statuses[$sale_item['status']]; ?>
        </td>
        <td>
            R$<?php echo number_format($sale_item['total_price'], 2, ',', ''); ?>
        </td>
        <td>

        </td>
    </tr>

    <?php endforeach; ?>

</table>