<?php
    class sql{
        
        /*
            ADMINISTRADOR SQL, Faltan algunas instrucciones, pero basicamente registra.
        */
        static function getRD_RSUsers(): String{
            return 'SELECT * FROM users u
                                  WHERE u.user_type = ?;';
        }
        static function getAllUsers(): String{
            return 'SELECT * FROM users;';
        }
        static function getDataUsuario($id): String{
            return 'SELECT * FROM usuario WHERE user_id = ?';
        }
        static function getDataCarreras(): String{
            return 'SELECT * FROM especialidad'; // Funcion descontinuada
        }
        static function change_status_user(): String{
            return 'SELECT change_status_user(?) as statusNew';
        }
        static function delete_user(): String{
            return 'SELECT delete_user(?) as statusNew;';
        }
        static function get_data_allSC(): String{
            return "SELECT * from allDataUserSC;";
        }
        static function insert_user(): String{
            return "SELECT insert_user(?,?,?,?,?,?) as resResult;";
        }
        static function insertsRD_RSrows(): String{
            return "SELECT insert_rd_rs(?,?) as resW;";
        }
        /*
         * RD, Construcciones 
         */
        static function getMyRsAll(): String{
            return "select * from getmyrsall where fk_rd = ?;";
        }
        static function getMyRsActivitys(): String{
            return "select * from actividad a "
            . "inner join user_user u on u.id_user_user = a.fk_rd_rs "
            . "inner join estados_actividad aa on a.IStatus_actividad = aa.id_actividad_ss"
            . " WHERE id_user_user = ?"
            . " ORDER BY(a.Dhorayfecha_actividad) ASC;";
        }
        static function insertActivity(): String{
            return "select insertactividad(
                    ?,	-- put the Fdescripcion parameter value instead of 'Fdescripcion' (varchar)
                    ?,	-- put the Ffecha parameter value instead of 'Ffecha' (datetime)
                    ?,	-- put the Flugar parameter value instead of 'Flugar' (varchar)
                    ?,	-- put the Fstatus parameter value instead of 'Fstatus' (int)
                    ? 	-- put the Fid_user_user parameter value instead of 'Fid_user_user' (int)
                ) as ID;
            ";
        }
        static function delete_actividad(): String{
            return "DELETE FROM actividad WHERE id_actividad = ?";
        }
        /* RS, Construcciones  */
        static function getAllMyRd(): String{
            return "SELECT * FROM getmyrd WHERE fk_rs = ?";
        }
        static function getMyActivity(): String{
            return "SELECT id_actividad, Vdescripcion_actividad, "
            . " Dhorayfecha_actividad, VLugar_Direccion, IStatus_actividad, fk_rd_rs"
            . " FROM actividad WHERE id_actividad = ?;";
        }
        static function uptActividad(): String{
            return "UPDATE actividad SET "
                    . " tipo_foto1 = ?,"
                    . " tipo_foto2 = ?,"
                    . " BFoto1_actividad = ?,"
                    . " BFoto2_actividad = ?,"
                    . " IStatus_actividad = ? "
                    . " WHERE id_actividad = ?;"
                    ;
        }
        static function selectImage(){
            return "SELECT BFoto1_actividad, tipo_foto1, BFoto2_actividad, tipo_foto2 FROM actividad"
            . " WHERE id_actividad = ?;";
        }
    }
?>