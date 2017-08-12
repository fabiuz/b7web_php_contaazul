<?php
/**
 * Created by PhpStorm.
 * User: fabiuz
 * Date: 17/07/17
 * Time: 16:33
 */
class Users extends model {

    private $userInfo;
    private $permissions;

    public function isLogged () {
        if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
            return true;
        }else {
            return false;
        }
    }

    public function doLogin($email, $password){
        $sql = $this->db->prepare("Select * from users where email = :email and password = :password");
        //print_r($sql->errorInfo());
        $sql->bindValue(":email", $email);
        $sql->bindValue(":password", md5($password));
        $sql->execute();

        if($sql->rowCount()>0){
            $row = $sql->fetch();
            $_SESSION['ccUser'] = $row['id'];

            return true;
        }else{
            return false;
        }
    }

    public function logout() {
        unset($_SESSION['ccUser']);
    }

    public function hasPermission($name) {
        return $this->permissions->hasPermission($name);
    }



    public function getCompany(){
        if (isset($this->userInfo['id_company'])) {
            return $this->userInfo['id_company'];
        }else{
            return 0;
        }
    }

    public function setLoggedUser() {
        if($_SESSION['ccUser'] && !empty($_SESSION['ccUser'])){
            $id = $_SESSION['ccUser'];

            $sql = $this->db->prepare("Select * from users where id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();

            if($sql->rowCount()>0){
                $this->userInfo = $sql->fetch();
                $this->permissions = new Permissions();
                $this->permissions->setGroup($this->userInfo['id_group'], $this->userInfo['id_company']);
            }
        }
    }

    public function getEmail(){
        if (isset($this->userInfo['email'])) {
            //echo $this->userInfo['email'];
            return $this->userInfo['email'];
        }else{
            return '';
        }
    }

    public function getInfo($id, $id_company) {
        $array = array();

        $sql = $this->db->prepare("
          Select * from users 
          where id=:id and id_company=:id_company");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }

        return $array;
    }

    public function findUsersInGroup($id){

        //echo 'id='.$id;exit;

        $sql = $this->db->prepare("Select count(*)  as c from users where id_group = :group");
        $sql->bindValue(":group", $id);
        $sql->execute();
        $row = $sql->fetch();

        if($row['c'] == '0'){
            return false;
        }else{
            return true;
        }
    }

    public function getList($id_company){
        $array = array();

        $sql = $this->db->prepare(
            "Select users.id, 
        users.email, 
        permission_groups.name
        from users left join permission_groups 
         on permission_groups.id = users.id_group 
         where users.id_company = :id_company");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function add($email, $pass, $group, $id_company){
        $sql = $this->db->prepare("Select count(*) as c from users where email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
        $row = $sql->fetch();

        if($row['c'] == '0'){

            $sql = $this->db->prepare("Insert into users set email = :email, password= :password, id_group = :id_group, id_company =:id_company");
            $sql->bindValue(":email", $email);
            $sql->bindValue(":password", md5($pass));
            $sql->bindValue(":id_group", $group);
            $sql->bindValue(":id_company", $id_company);
            $sql->execute();

            return '1';
        }else{
            return '0';
        }
    }

    public function edit($pass, $group, $id, $id_company){
        $sql = $this->db->prepare("Update users set id_group = :id_group where id=:id and id_company=:id_company");
        $sql->bindValue(":id_group", $group);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if(!empty($pass)){
            $sql= $this->db->prepare("Update users set password = :password where id = :id and id_company = :id_company");
            $sql->bindValue(":password", md5($pass));
            $sql->bindValue(":id", $id);
            $sql->bindValue(":id_company", $id_company);
            $sql->execute();
        }
    }

    public function delete($id, $id_company){
        $sql = $this->db->prepare("Delete from users where id = :id and id_company = :id_company");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();
    }

    public function getId(){
        if (isset($this->userInfo['id'])) {
            return $this->userInfo['id'];
        }else{
            return '';
        }
    }
}