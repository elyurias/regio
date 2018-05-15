<?php
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/dao/db/sql.class.php';
    class db{
        private $msql;
        public  $msg        = array();
        public  $err        = array();
        private $_host      = '127.0.0.1';
        private $_port      = 3306;
        private $_user      = 'root';
        private $_pass      = '';
        private $__dsn      = 'mysql';
        private $_dbname    = 'regio';
        private $_DSN       = '';
        function __construct(){
            $this->_DSN = $this->__dsn.':dbname='.$this->_dbname.';host='.$this->_host.';port='.$this->_port;
            //Configuracion necesaria para insertar imagenes - mysqld --max_allowed_packet=16M
            //                                               - modificar el post-size(no recuerdo...) de la pagina
        }
        function connect(){
            try{
                $PDO_U = new PDO(
                    $this->_DSN,
                    $this->_user,
                    $this->_pass, 
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                    )
                );
                $PDO_U->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $PDO_U;
            }catch(PDOException $e){
                $this->err[] = 1; //error_database
                return false;
            }
        }
        function objResultSet($sql,$arrayParam){
            $con = $this->connect();
            if(!$this->isConnectStatus($con)){
                return $this->err[] = 2; /** @param err is not null, the error is connect to database */
            }else{
                $pP = $con->prepare($sql);
                $pP->execute($arrayParam);
                $RS = array();
                while($resultSet = $pP->fetchObject())
                    $RS[] = $resultSet;
                return $RS;
            }
        }
        function allResultSet($sql,$arrayParam){ 
            $con = $this->connect();
            if(!$this->isConnectStatus($con)){
                return $this->err[] = 2; /** @param err is not null, the error is connect to database */
            }else{
                    $pP = $con->prepare($sql);
                    $pP->execute($arrayParam);
                    $resultSet = $pP->fetchAll();
                    return $resultSet;
            }
        }
        function isConnectStatus($con){
            return $con == false ? false : true;
        }
        function callSQLQuery($SQL, $ARRAY): Array{
            return $this->allResultSet($SQL,$ARRAY);
        }
        function executeLine($SQL, $ARRAY): bool{
            $con = $this->connect();
            if(!$this->isConnectStatus($con)){
                return False; /** @param err is not null, the error is connect to database */
            }else{
                $pP = $con->prepare($SQL);
                return $pP->execute($ARRAY);     
            }
        }
        function getForcedObjectPDO(){
            return $this->connect();
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