<?php
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/db/db.class.php';
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/db/sql.class.php';
    class dao_rd extends db{
        function __construct(){
            parent::__construct();
        }
        function getAllRsToRd($array){
            $result = $this->callSQLQuery(sql::getMyRsAll(), $array);
            return $result;
        }
        function getAllActivitys_Rs($id){
            $result = $this->callSQLQuery(sql::getMyRsActivitys(), array($id));
            return $result;
        }
        function insertActividad($arr){
            $result = $this->callSQLQuery(sql::insertActivity(), $arr);
            return $result[0][0];
        }
        function eliminarActividad($id){
            return $result = $this->executeLine(sql::delete_actividad(),array($id));
        }
    }