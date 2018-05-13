<?php
    class session{
        static $id;
        static $tipo;
        static $status;
        static $key_session_variable_id     = 'user_id';
        static $key_session_variable_tipo   = 'user_type';
        static $key_session_variable_status = 'user_login_status';
        function __construct(){
            //inicio de session
            session_start();
            //asignacion de variables
        }
        static function isSession(): Bool{
            return isset($_SESSION[self::$key_session_variable_id]) 
                && isset($_SESSION[self::$key_session_variable_tipo])
                && isset($_SESSION[self::$key_session_variable_status]);
        }
        static function dlSession(): Void{
            session_destroy();
        }
        //Getters and Setters, sin caracteristicas de PHP > 5.6
        static function setUser($id_user): Void{
            self::$id = $id_user;
            $_SESSION[self::$key_session_variable_id] = self::$id;
        }
        static function setTipo($tp_user): Void{
            self::$tipo = $tp_user;
            $_SESSION[self::$key_session_variable_tipo] = self::$tipo;
        }
        static function setStatus($tp_status): Void{
            self::$tipo = $tp_status;
            $_SESSION[self::$key_session_variable_status] = self::$status;
        }
        //Getters
        static function getUser(): Int{
            return $_SESSION[self::$key_session_variable_id];
        }
        static function getTipo(): Int{
            return $_SESSION[self::$key_session_variable_tipo];
        }
        static function getStatus(): Int{
            return $_SESSION[self::$key_session_variable_status];
        }
    }
?>