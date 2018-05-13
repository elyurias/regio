<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/db/db.class.php';
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/db/sql.class.php';
    class dao_admin extends db{
        function __construct(){
            parent::__construct();
        }
        function getSCDataAll(){
            return $this->callSQLQuery(sql::get_data_allSC(), array());
        }
        function getAllRD(){
            $data = $this->callSQLQuery(sql::getRD_RSUsers(), array(3));
            return $data;
        }
        function getAllRS(){
            $data = $this->callSQLQuery(sql::getRD_RSUsers(), array(4));
            return $data;
        }
        function changeStatusUser($id){
            $data = $this->callSQLQuery(sql::change_status_user(), array($id));
            if($data){
                return $data[0]['statusNew'];
            }else{
                return -1;
            }
        }
        function DeleteUser($id){
            $data = $this->callSQLQuery(sql::delete_user(), array($id));
            if($data){
                return True;
            }else{
                return False;
            }
        }
        function InsertUsuario($obj){
            $pp = $this->callSQLQuery(sql::insert_user(), $obj);
            return $pp[0][0];
        }
        function InsertRDRS($arr){
            $app = $this->callSQLQuery(sql::insertsRD_RSrows(), $arr);
            return $app;
        }
    }
?>