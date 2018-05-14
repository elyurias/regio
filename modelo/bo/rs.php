<?php
require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/rs.php';
require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/obj/obj.php';
require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'vista/vistashtml/rs_v.php';
class bors extends getV_rs{
    var $dao = null;
    function __construct(){
        $this->dao = new dao_rs();
    }
    function getMyRd($id_user){
        $val = $this->dao->getAllMyRd($id_user);
        return $this->getTableViewAll($val);
    }
    function getMyActivities($obj){
        $val = $this->dao->getAllMyActivities($obj->id_rd_rs);
        return $this->getTableViewAllActividades($val);
    }
    function getMyForm($obj){
        $detalleActividad = $this->dao->getMyActivity($obj->id_actividad_response);
        return $this->getFormResultConsulta($detalleActividad,$obj->id_actividad_response);
    }
    function setEnviarEvidencia($obj){
        $formatos_validos = [
            'gif','jpg','jpe','jpeg','png'
        ];
        /* @var $nameVal1 type */
        $nameVal1 = explode(".", $obj->nombre1);
        $nameVal2 = explode(".", $obj->nombre2);
        $nameVal1 = end($nameVal1);
        $nameVal2 = end($nameVal2);
        if(!in_array($nameVal1, $formatos_validos)){
            return -7; // Primera foto no valida
        }
        if(!in_array($nameVal2, $formatos_validos)){
            return -7; // segunda foto no valida
        }
        $resp = $this->dao->updActividad($obj, $nameVal1, $nameVal2, $obj->id_actividad,2);
        if (!$resp) {
            return -1;
        }else{
            return 1;
        }
        return -1;
    }
    function getImagesAll($id){
        $imagenes = $this->dao->getImagesToActivity($id);
        $response = file_put_contents('files/'.$id.'do.'.$imagenes[0][1],$imagenes[0][0]) && 
                file_put_contents('files/'.$id.'du.'.$imagenes[1][1],$imagenes[1][0]);
        if(!$response){
            return 1;
        }else{
            return $this->getImages([
                'files/'.$id.'do.'.$imagenes[0][1],
                'files/'.$id.'du.'.$imagenes[1][1]
            ]);
        }
    }
}