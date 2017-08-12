<?php
/**
 * Created by PhpStorm.
 * User: fabiuz
 * Date: 17/07/17
 * Time: 18:27
 */
class Companies extends model {

    private $companyInfo;

    public function __construct($id){
        parent::__construct();

        $sql = $this->db->prepare("Select * from companies where id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount()> 0){
            $this->companyInfo = $sql->fetch();
        }
    }

    public function getName() {
        if(isset($this->companyInfo['name'])){
            return $this->companyInfo['name'];
        }else{
            return '';
        }
    }
}