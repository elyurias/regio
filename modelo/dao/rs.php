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
                return $e->getMessage();
                //return False;
            }
        }
        function getImagesToActivity($id){
            try{
                $sql = sql::selectImage();
                $con = $this->getForcedObjectPDO();
                $stmt = $con->prepare($sql);
                $stmt->execute([$id]);
                
                $stmt->bindColumn(1, $foto1, PDO::PARAM_LOB);
                $stmt->bindColumn(2, $tipo1);
                
                $stmt->bindColumn(3, $foto2, PDO::PARAM_LOB);
                $stmt->bindColumn(4, $tipo2);
                
                $stmt->fetch(PDO::FETCH_BOUND);
                
                return [
                    [$foto1, $tipo1],
                    [$foto2, $tipo2],
                    [sql::selectImage(), $id]
                ];
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }