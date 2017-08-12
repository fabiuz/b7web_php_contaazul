<?php
/**
 * Created by PhpStorm.
 * User: fabiuz
 * Date: 18/07/17
 * Time: 16:32
 */
class Permissions extends model {

    private $group;
    private $permissions;

    public function __construct(){
        parent::__construct();
    }

    public function setGroup($id, $id_company){
        $this->group = $id;
        $this->permissions = array();

        $sql = $this->db->prepare("Select params from permission_groups where id = :id and id_company = :id_company");
        $sql->bindValue(":id", $id);
        $sql->bindValue("id_company", $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $row = $sql->fetch();

            if(empty($row['params'])){
                $row['params'] = '0';
            }

            $params = $row['params'];

            $sql = $this->db->prepare("Select name 
                from permission_params where id in ($params) and id_company = :id_company");

            $sql->bindValue("id_company", $id_company);
            $sql->execute();

            if($sql->rowCount() > 0){
                foreach($sql->fetchAll() as $item){
                  $this->permissions[] = $item['name'];
                }
            }
        }
        //print_r($this->permissions);
        //exit;
    }

    public function hasPermission($name) {

        if(in_array($name, $this->permissions)){
            return true;
        }else {
            return false;
        }
    }

    public function getList($id_company) {

        $array = array();

        $sql = $this->db->prepare("Select * from permission_params where id_company = :id_company");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }


        return $array;
    }

    public function getGroupList($id_company){
        $array = array();

        $sql = $this->db->prepare("Select * from permission_groups where id_company = :id_company");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function getGroup($id, $id_company) {

        $array = array();

        $sql = $this->db->prepare("Select * from permission_groups 
        where id = :id and id_company = :id_company");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch();
            $array['params'] = explode(',', $array['params']);
        }

        return $array;

    }

    public function add($name, $id_company){

        $sql = $this->db->prepare("Insert into permission_params set name = :name, 
        id_company = :id_company");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

    }

    public function addGroup($name, $plist, $id_company) {
        $params = implode(',', $plist);

        $sql = $this->db->prepare("Insert into permission_groups set name = :name, 
        id_company = :id_company, params = :params");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":params", $params);
        $sql->execute();

    }

    public function delete($id){

        $sql = $this->db->prepare("delete from permission_params where id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function deleteGroup($id){
        $u= new Users();

        if($u->findUsersInGroup($id) == false) {
            $sql = $this->db->prepare("delete from permission_groups where id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        }
    }

    public function editGroup($name, $plist, $id, $id_company) {
        $params = implode(',', $plist);

        $sql = $this->db->prepare("Update permission_groups set
        name = :name, id_company = :id_company, params = :params
        where id = :id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":params", $params);
        $sql->bindValue(":id", $id);

        $sql->execute();

    }
}