<?php
    include_once 'encabezado.php';
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/bo/rd.class.php';
    $varUser = new session();
    $obj = new obj();
    if(!isset($_POST['action'])){
        header('Location: ../login.php');
    }else{
        if($varUser->isSession() && $varUser->getTipo()==3){
            $varBoRd = new bord(); 
            switch ($_POST['action']) {
                case 'getMyRsAll':
                    print($varBoRd->getMyAllRs($varUser->getUser()));
                break;
                case 'getFormToActivity':
                    $obj->id = $_POST['id_rd_rs'];
                    print($varBoRd->getFormActivity($obj));
                break;
                case 'getAllActivitys':
                    $obj->id = $_POST['id_rd_rs'];
                    $username = $_POST['username'];
                    print($varBoRd->getActivitysValues($obj,$username));
                break;
                case 'Registrar Actividad':
                    $obj->descripcion   = $_POST['descripcion'];
                    $obj->fecha         = $_POST['fecha'];
                    $obj->id_user_user  = $_POST['id_user_user'];
                    $obj->lugar         = $_POST['lugar'];
                    $obj->status        = 1;
                    print($varBoRd->insertActividad($obj));
                break;
                case 'eliminarActividad':
                    $obj->id_actividad  = $_POST['id_actividad'];
                    print($varBoRd->eliminarActividad($obj));
                break;
                case 'verImagenes':
                    $obj->id_actividad  = $_POST['id_actividad'];
                    print($varBoRd->verActividad($obj));
                break;
                default:
                    print('No Operation_CONTROL');
                break;
            }
        }else{
            print('No Session');
        }   
    }
?>