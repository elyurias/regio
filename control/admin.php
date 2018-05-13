<?php
    include_once 'encabezado.php';
    require_once $_SERVER['DOCUMENT_ROOT'].ruta::$ruta.'modelo/bo/admin.class.php';
    $varUser = new session();
    $obj = new obj();
    if(!isset($_POST['action'])){
        header('Location: ../login.php');
    }else{
        if($varUser->isSession() && $varUser->getTipo()==1){
            $varBoAdm = new boadmin(); 
            switch($_POST['action']){
                case 'getRDAll':
                    $obj->titulo = $_POST['id_title'];
                    print($varBoAdm->getRDAll_BO($obj));
                break;
                case 'getRSAll':
                    $obj->titulo = $_POST['id_title'];
                    print($varBoAdm->getRSAll_BO($obj));
                break;
                case 'changeStatusUser':
                    $obj->id_usuario = $_POST['id'];
                    // Si su estado es 1, entonces lo cambia a 0
                    // Si su estado es 0, entonces lo cambia a 1
                    // el mensaje se crea desde el cliente y esta funcion reformula la construccion logica del usuario
                    print($varBoAdm->ChangeStatusUser($obj));
                break;
                case 'deleteUser':
                    $obj->id_usuario = $_POST['id'];
                    // Si su estado es 1, entonces lo cambia a 0
                    // Si su estado es 0, entonces lo cambia a 1
                    // el mensaje se crea desde el cliente y esta funcion reformula la construccion logica del usuario
                    print($varBoAdm->DeleteUser($obj));
                break;
                case 'FormOrUpdateinsertUser':
                    $obj->tipo = $_POST['id_tipo'];
                    // Si su estado es 1, entonces lo cambia a 0
                    // Si su estado es 0, entonces lo cambia a 1
                    // el mensaje se crea desde el cliente y esta funcion reformula la construccion logica del usuario
                    print($varBoAdm->InsertUserForm($obj));
                break;
                case 'getAllSRData':
                    $obj->titulo = $_POST['id_title'];
                    print($varBoAdm->getDataTableSC($obj));
                break;
                case 'Registro':
                    $obj->nombre       = $_POST['nombre'];
                    $obj->paterno      = $_POST['paterno'];
                    $obj->username     = $_POST['username'];
                    $obj->correo       = $_POST['email'];
                    $obj->contraseña   = $_POST['contrasenia'];
                    $obj->tipo_usuario = $_POST['tipo_usuario'];
                    $objCaracteristicas = new obj();
                    if(isset($_POST['extras'])){
                        $objCaracteristicas->extras = $_POST['extras'];
                        print($varBoAdm->insertUser($obj,$objCaracteristicas));
                    }else{
                        print("-3");// Siempre debe estar definido extras, como
                                    //  variable relacionda a la ejecucion de consultas
                                    // y esas cosas... bueno... es como cuando haces algo
                                    // y le das para largo... jaja...
                    }
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