<?php
require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/rd.php';
require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/obj/obj.php';
require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'vista/vistashtml/rd_v.php';
class bord extends getV_rd{
    var $dao = null;
    function __construct(){
        $this->dao = new dao_rd();
    }
    function getMyAllRs($param){
        $nval = $this->dao->getAllRsToRd(array($param));
        return $this->getTableRs($nval);
    }
    function getFormActivity($obj){                 //1 es a registrar, 2 es a actualizar
        return $this->getFormRegistroGeneric(array(), 1,array(),$obj->id);
    }
    function getActivitysValues($obj,$username){
        $values = $this->dao->getAllActivitys_Rs($obj->id);
        return $this->get_All_data_cc($values,$username);
    }
    function insertActividad($obj){
        $values = $this->dao->insertActividad(array(
            $obj->descripcion,
            $obj->fecha,
            $obj->lugar,
            $obj->status,
            $obj->id_user_user
        ));
        if($values > 0){
            return 1;
        }
    }
    function eliminarActividad($obj){
        $values = $this->dao->eliminarActividad($obj->id_actividad);
        if($values){
            return 1;
        }
        return 0;
    }
}