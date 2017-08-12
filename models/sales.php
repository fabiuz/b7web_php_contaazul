<?php
class Sales extends model{

    public function getList($offset, $id_company){
        $array = array();

        $sql = $this->db->prepare(
            "Select sales.id, 
                          sales.date_sale, 
                          sales.total_price,
                          sales.status,
                          clients.name
                      from sales left join clients on clients.id = sales.id_client
                        where sales.id_company = :id_company 
                      order by sales.date_sale desc limit $offset, 10");
        $sql->bindValue("id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function addSale($id_company, $id_client, $id_user, $quant, $status){
        $i = new inventory();



        $sql = $this->db->prepare("Insert into sales set id_company = :id_company, id_client = :id_client, id_user = :id_user, date_sale = Now(), total_price = :total_price, status = :status");
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_client", $id_client);
        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":total_price", '0');
        $sql->bindValue(":status", $status);
        $sql->execute();

        $id_sale = $this->db->lastInsertId();

        $total_price = 0;
        foreach($quant as $id_produto => $quant_prod){

            $sql = $this->db->prepare("Select price from inventory where id = :id and id_company = :id_company");
            $sql->bindValue(":id", $id_produto);
            $sql->bindValue(":id_company", $id_company);
            $sql->execute();

            if($sql->execute() > 0){
                $row = $sql->fetch();
                $price = $row['price'];

                $sqlproduto = $this->db->prepare("Insert into sales_products set id_company = :id_company, id_sale = :id_sale, id_product = :id_product, quant = :quant, sale_price = :sale_price");
                $sqlproduto->bindValue(":id_company", $id_company);
                $sqlproduto->bindValue(":id_sale", $id_sale);
                $sqlproduto->bindValue(":id_product", $id_produto);
                $sqlproduto->bindValue(":quant", $quant_prod);
                $sqlproduto->bindValue(":sale_price", $price);
                $sqlproduto->execute();

                $i->decrease($id_produto, $id_company, $quant_prod, $id_user);

                $total_price += $price * $quant_prod;
            }
        }

        $sql = $this->db->prepare("Update sales set total_price = :total_price where id = :id");
        $sql->bindValue(":total_price", $total_price);
        $sql->bindValue(":id", $id_sale);
        $sql->execute();
    }

    public function getInfo($id, $id_company){
        $array = array();
        $sql = $this->db->prepare("Select *, 
            (Select clients.name from clients where clients.id = sales.id_client) as client_name
            from sales 
              where 
                id = :id and 
                id_company = :id_company");

        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->Execute();

        if($sql->rowCount() > 0){
            $array['info'] = $sql->fetch();
        }

        $sql = $this->db->prepare("
          Select sales_products.quant, 
            sales_products.sale_price,
            inventory.name           
           from sales_products left join inventory
          on inventory.id = sales_products.id_product
            where 
              sales_products.id_sale = :id_sale and 
              sales_products.id_company = :id_company");
        $sql->bindValue(":id_sale", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array['products'] = $sql->fetchAll();
        }

        return $array;
    }
}