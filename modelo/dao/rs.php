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
                /*$stmt->bindParam(1, $mine1);
                $stmt->bindParam(2, $mine2);//data1
                $stmt->bindParam(3, $blob1, PDO::PARAM_LOB);//data2
                $stmt->bindParam(4, $blob2, PDO::PARAM_LOB);
                $stmt->bindParam(5, $id_actividad);*/
                $result = $stmt->execute([
                    $mine1,
                    $mine2,
                    $blob1,
                    $blob2,
                    $IStatus_actividad,
                    $id_actividad,
                ]);
                return $result;
            }catch(PDOException $e){
                //print($e->getMessage());
                return False;
            }
        }
    }