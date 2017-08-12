<?php
class Clients extends model{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList($offset, $id_company){
        $array = array();
        $sql= $this->db->prepare("Select * from clients where id_company = :id_company Limit $offset, 10");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function add ($id_company, $name, $email = '', $phone = '', $stars = '3',
                    $internal_obs = '', $address_zipcode = '', $address = '', $address_number = '',
                    $address2 = '',  $address_neighb = '', $address_city = '', $address_state = '', $address_country = ''){
        $sql = $this->db->prepare(
            "Insert into clients set 
            id_company = :id_company,
            name = :name,
            phone = :phone,
            email = :email,
            stars = :stars,
            internal_obs = :internal_obs,
            address_zipcode = :address_zipcode,
            address = :address,
            address_number = :address_number,
            address2 = :address2,
            address_neighb = :address_neighb,
            address_city = :address_city,
            address_state = :address_state,
            address_country = :address_country");

        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":phone", $phone);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":stars", $stars);
        $sql->bindValue(":internal_obs", $internal_obs);
        $sql->bindValue(":address_zipcode", $address_zipcode);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":address_number", $address_number);
        $sql->bindValue(":address2", $address2);
        $sql->bindValue(":address_neighb", $address_neighb);
        $sql->bindValue(":address_city", $address_city);
        $sql->bindValue(":address_state", $address_state);
        $sql->bindValue(":address_country", $address_country);

        $sql->execute();

        return $this->db->lastInsertId();
    }

    public function edit ($id, $id_company, $name, $email, $phone, $stars,
                         $internal_obs, $address_zipcode, $address, $address_number,
                         $address2,  $address_neighb, $address_city, $address_state, $address_country){
        $sql = $this->db->prepare(
            "Update clients set 
            id_company = :id_company,
            name = :name,
            phone = :phone,
            email = :email,
            stars = :stars,
            internal_obs = :internal_obs,
            address_zipcode = :address_zipcode,
            address = :address,
            address_number = :address_number,
            address2 = :address2,
            address_neighb = :address_neighb,
            address_city = :address_city,
            address_state = :address_state,
            address_country = :address_country
            where id = :id AND 
            id_company = :id_company2");

        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_company2", $id_company);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":phone", $phone);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":stars", $stars);
        $sql->bindValue(":internal_obs", $internal_obs);
        $sql->bindValue(":address_zipcode", $address_zipcode);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":address_number", $address_number);
        $sql->bindValue(":address2", $address2);
        $sql->bindValue(":address_neighb", $address_neighb);
        $sql->bindValue(":address_city", $address_city);
        $sql->bindValue(":address_state", $address_state);
        $sql->bindValue(":address_country", $address_country);


        $sql->execute();
    }


    public function getInfo($id, $id_company){
        $array = array();

        $sql = $this->db->prepare("Select * from clients where id = :id and id_company = :id_company");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch();
        }
        
        return $array;
            
    }

    public function getCount($id_company){
        $r = 0;

        $sql = $this->db->prepare("Select count(*) as c from clients where id_company = :id_company");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();
        $row = $sql->fetch();
        $r = $row['c'];

        return $r;
    }

    public function searchClientByName($name, $id_company){
        $array = array();

        $sql = $this->db->prepare("Select name, id from clients 
            where id_company = :id_company and name like :name limit 10");
        $sql->bindValue(":name", '%%'.$name.'%');
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }
}