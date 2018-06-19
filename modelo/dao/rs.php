<?php
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/db/db.class.php';
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/db/sql.class.php';
    class dao_rs extends db{
        function __construct(){
            parent::__construct();
        }
        function getAllMyRd($id){
            return $this->allResultSet(sql::getAllMyRd(), array($id));
        }
        function getAllMyActivities($id){
            return $this->allResultSet(sql::getMyRsActivitys(), array($id));
        }
        function getMyActivity($id){
            return $this->allResultSet(sql::getMyActivity(), array($id));
        }
        function updActividad($obj,$mine1, $mine2, $id_actividad,$IStatus_actividad){
            $blob1 = $obj->foto1;
            $blob2 = $obj->foto2;
            $sql = sql::uptActividad();
            try{
                $con = $this->getForcedObjectPDO();
                $stmt = $con->prepare($sql);
                $normbre_uno_original = "do".$id_actividad.".".$mine1;
                $normbre_dos_original = "du".$id_actividad.".".$mine2;
                $result = $stmt->execute([
                    $mine1,
                    $mine2,
                    $normbre_uno_original,
                    $normbre_dos_original,
                    $IStatus_actividad,
                    $id_actividad,
                ]);
                move_uploaded_file($blob1, "files/".$normbre_uno_original);
                move_uploaded_file($blob2, "files/".$normbre_dos_original);
                return $result;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }