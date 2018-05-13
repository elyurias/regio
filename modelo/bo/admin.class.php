<?php
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/admin.php';
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/obj/obj.php';
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'vista/vistashtml/admin_v.php';
    class boadmin extends getV_administrator{
        var $dao = null;
        function __construct(){
            $this->dao = new dao_admin();
        }
        function getRSAll_BO($class): String{
            $data = $this->dao->getAllRS($class);
            return $this->get_All_data_cc($data,"RS");
        }
        function getRDAll_BO($class): String{
            $data = $this->dao->getAllRD($class);
            return $this->get_All_data_cc($data,"RD");
        }
        function getDataTableSC(){
            $data = $this->dao->getSCDataAll();
            return $this->get_All_data_cc($data,"SC");
        }
        function ChangeStatusUser($obj): int{
            $data = $this->dao->changeStatusUser($obj->id_usuario);
            return $data;
        }
        function DeleteUser($obj){
            $data = $this->dao->DeleteUser($obj->id_usuario);
            return $data;
        }
        function InsertUserForm($obj){
            $dataRS = $this->dao->getAllRS();
            return $this->getFormRegistroGeneric($obj->tipo,array(),1,$dataRS);
        }
        function insertUser($objGeneral,$objCaracteristicas){
            $data = $this->dao->InsertUsuario(
               array(
                    $objGeneral->nombre,
                    $objGeneral->paterno,
                    $objGeneral->username,
                    password_hash($objGeneral->contraseña, PASSWORD_DEFAULT),
                    $objGeneral->correo,
                    $objGeneral->tipo_usuario
               )
            );//data es el id del usuario que acabamos de insertar
              //si no esta bien la operacion, retornara -2
            if($data != -2){
                if($objGeneral->tipo_usuario == 3){
                    foreach($objCaracteristicas->extras as $row){
                        $this->dao->InsertRDRS(array($data,$row));
                    }
                }
                return 1;
            }else{
                return -1; // Mensaje de Error, en mi caso, lo manejo desde javascript
            }
        }
    }
?>