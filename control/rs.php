<?php
    include_once 'encabezado.php';
    /* @var $_SERVER type  */
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/bo/rs.php';
    $varUser = new session();
    $obj = new obj();
    if(!isset($_POST['action'])){
        header('Location: ../login.php');
    }else{
        if($varUser->isSession() && $varUser->getTipo()==4){
            $varBoRs = new bors(); 
            switch ($_POST['action']) {
                case 'getMyRd':
                    print($varBoRs->getMyRd($varUser->getUser()));
                break;
                case 'get_actividades_rs':
                    $obj->id_rd_rs = $_POST['id_rd_rs'];
                    print($varBoRs->getMyActivities($obj));
                break;
                case 'get_form_actividad':
                    $obj->id_actividad_response = $_POST['id_actividad_resp'];
                    print($varBoRs->getMyForm($obj));
                break;
                case 'enviar':
                    //$obj->foto1 = $_POST['foto1'];
                    //$obj->foto2 = $_POST['foto2'];
                    $obj->id_actividad = $_POST['id_actividad'];
                    $obj->foto1 = file_get_contents($_FILES['foto1']['tmp_name']);
                    $obj->foto2 = file_get_contents($_FILES['foto2']['tmp_name']);
                    $obj->nombre1 = $_FILES['foto1']['name'];
                    $obj->nombre2 = $_FILES['foto2']['name'];
                    print($varBoRs->setEnviarEvidencia($obj));
                break;
                case 'actualizar':
                    $obj->id_actividad_response = $_POST['id_actividad_resp'];
                    print($varBoRs->getMyForm($obj));
                break;
                case 'getMyImages':
                    $obj->id = $_POST['id_actividad'];
                    print($varBoRs->getImagesAll($obj->id));
                break;
                default:
                    print('No Operation_CONTROL');
                break;
            }
        }else{
            print('No Session RS');
        }   
    }