<h1>Vendas - Editar</h1>

<strong>Nome do Cliente</strong>
<?php echo $sales_info['info']['client_name']; ?><br/><br/>

<strong>Data da venda</strong>
<?php echo date('d/m/Y', strtotime($sales_info['info']['date_sale'])); ?><br/><br/>

<strong>Total da venda</strong>
R$ <?php echo number_format($sales_info['info']['total_price'], 2, ',', '.'); ?>
<br/><br/>

<strong>Status da venda</strong><br/>
<hr/>
