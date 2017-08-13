<?php
class inventory extends model {

    public function __construct()
    {
        parent::__construct();
    }


    public function getList($offset, $id_company){
        $array = array();

        $sql = $this->db->prepare("Select * from inventory where id_company = :id_company limit $offset, 10");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() >0){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function getInfo($id, $id_company) {
        $array = array();

        $sql = $this->db->prepare("Select * from inventory where id = :id and id_company = :id_company");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch();
        }
        return $array;
    }

    public function add($name, $price, $quant, $min_quant, $id_company, $id_user){

        $sql = $this->db->prepare("Insert into inventory 
            set name = :name, 
            price = :price, 
            quant = :quant, 
            min_quant = :min_quant, 
            id_company = :id_company");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":price", $price);
        $sql->bindValue(":quant", $quant);
        $sql->bindValue(":min_quant", $min_quant);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $id_product = $this->db->lastInsertId();

        $this->setLog($id_product, $id_company, $id_user, 'add');

        /*

        $sql = $this->db->prepare("Insert into inventory_history 
          set 
          id_product =:id_product, 
          id_user = :id_user, 
          action = :action,
          id_company = :id_company, 
          date_action = Now()");
        $sql->bindValue(":id_product", $id_product);
        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":action", "add");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();
        */
    }

    public function edit($id_product, $name, $price, $quant, $min_quant, $id_company, $id_user){

        $sql = $this->db->prepare("Update inventory 
            set name = :name, 
            price = :price, 
            quant = :quant, 
            min_quant = :min_quant
            where id = :id and id_company = :id_company");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":price", $price);
        $sql->bindValue(":quant", $quant);
        $sql->bindValue(":min_quant", $min_quant);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id", $id_user);
        $sql->execute();

        $this->setLog($id_product, $id_company, $id_user, 'edt');

    }

    public function delete($id_product, $id_company, $id_user){
        $sql = $this->db->prepare("Delete from inventory where id = :id and id_company = :id_company");
        $sql->bindValue(":id", $id_product);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $this->setLog($id_product, $id_company, $id_user, 'del');
    }

    public function setLog($id_product, $id_company, $id_user, $action){
        $sql = $this->db->prepare("Insert into inventory_history 
          set 
          id_product =:id_product, 
          id_user = :id_user, 
          action = :action,
          id_company = :id_company, 
          date_action = Now()");
        $sql->bindValue(":id_product", $id_product);
        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":action", $action);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();
    }

    public function searchProductsByName($name, $id_company){
        $array = array();

        $sql = $this->db->prepare("Select name, price, id from inventory 
            where id_company = :id_company and name like :name limit 10");
        $sql->bindValue(":name", '%%'.$name.'%');
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function decrease($id_produto, $id_company, $quant_prod, $id_user){
        $sql = $this->db->prepare("Update inventory set quant = quant - $quant_prod where id = :id and id_company = :id_company");
        $sql->bindValue(":id", $id_produto);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $this->setLog($id_produto, $id_company, $id_user, 'dwn');

    }

    public function getInventoryFiltered($id_company){
        $array = array();

        $sql = $this->db->prepare("Select *, (min_quant - quant) as diferenca from inventory where quant < min_quant and id_company = :id_company order by diferenca desc");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }
}