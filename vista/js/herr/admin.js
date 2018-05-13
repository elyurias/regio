$(function(){
    $(".loader").fadeOut("hide");
    menuA.getDataSC('#SC_c');
});
var globales_internas = 0;
class admin_herr extends conector{
    constructor(){
        super();
        this.menu = 0;
        this.i_global = 0;
        globales_internas = 0;
    }
    addToClassLine($classActiveNew){
        var arrayPunt = [
            '#SC_c','#RD_c','#RS_c','#PR_c','#CC_c'
        ];
        for(var $i=0; $i < arrayPunt.length; $i++){
            if($classActiveNew === arrayPunt[$i]){
                $(arrayPunt[$i]).addClass('active');
            }else{
                $(arrayPunt[$i]).removeClass('active');
            }
        }
    }
    getDataPrincipal(){
        this.addToClassLine('#PR_c');
    }
    getCarrera(){
        this.i_global = 4;
        globales_internas = 4;
    }
    getDataRS($id_act){
        this.i_global = 3;
        globales_internas = 3;
        this.addToClassLine($id_act);
        var a = this.callController(
            "control/admin.php",
            {
                action: 'getRSAll',
                id_title:$id_act
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#TableDocumentData').empty();
                $('#TableDocumentData').html(data);
            }
        );
    }
    getDataRD($id_act){
        this.i_global = 2;
        globales_internas = 2;
        this.addToClassLine($id_act);
        var a = this.callController(
            "control/admin.php",
            {
                action: 'getRDAll',
                id_title:$id_act
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#TableDocumentData').empty();
                $('#TableDocumentData').html(data);
            }
        );
    }
    getDataSC($id_act){
        this.i_global = 1;
        globales_internas = 1;
        this.addToClassLine($id_act);
        var a = this.callController(
            "control/admin.php",
            {
                action: 'getAllSRData',
                id_title:$id_act
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#TableDocumentData').empty();
                $('#TableDocumentData').html(data);
            }
        );
    }
    getDataAll($id,$id_act){
        this.addToClassLine($id_act);
        this.i_global = $id;
        globales_internas = $id;
        this.callController('control/admin.php',{action:'getAllSRData'},()=>{
            },(data)=>{
            $('#TableDocumentData').html(data);
        });
    }
    getEventLineOperation(){
        switch(globales_internas){
            case 1:
                this.getDataSC('#SC_c');
            break;
            case 2:
                this.getDataRD('#RD_c');
            break;
            case 3:
                this.getDataRS('#RS_c');
            break;
        }
    }
    isEnabledUser($puntero,$status, $idVal, $idUser){
        var moduleDir = function($idUser){
            conector.prototype.callController(
                'control/admin.php',
                {
                    action:'changeStatusUser',
                    id: $idUser
                },
                ()=>{},
                (data)=>{
                    var id_btn = '#'+$idVal;
                    var id_ico = '#'+$idVal+'2';
                    if(data.trim() == '-1'){
                        admin_herr.prototype.defin_msg_final('Error!',
                            'Operacion Fallida!',
                            BootstrapDialog.TYPE_WARNING);
                    }else if(data.trim() == 1){
                        admin_herr.prototype.defin_msg_final('Aviso!',
                            'El usuario tiene acceso al Sistema!',
                            BootstrapDialog.TYPE_SUCCESS);
                    }else if(data.trim() == 0){
                        admin_herr.prototype.defin_msg_final('Aviso!',
                            'El usuario ha sido bloqueado del Sistema!',
                            BootstrapDialog.TYPE_SUCCESS);
                    }
                }
            );
        };
        this.modulo = $status === 1? [
            {
                label: 'Inhabilitar',
                icon: 'glyphicon glyphicon-check',
                cssClass: 'btn-danger',
                action: function(dialog){
                    moduleDir($idUser);
                    admin_herr.prototype.getEventLineOperation();
                    dialog.close();
                }
            }
        ] : [
            {
                label: 'Habilitar',
                icon: 'glyphicon glyphicon-check',
                cssClass: 'btn-primary',
                action: function(dialog){
                    moduleDir($idUser);
                    admin_herr.prototype.getEventLineOperation();
                    dialog.close();
                }
            }
        ];
        this.type_txt = $status === 1 ? BootstrapDialog.TYPE_WARNING : BootstrapDialog.TYPE_PRIMARY;
        this.msg = $status === 1 ? 'Desea Inhabilitar al usuario, a consecuencia, el usuario no podra acceder al sistéma' 
            : 'Desea Habilitar al usuario, a consecuencia, el usuario podra acceder al sistéma y utilizar las herramientas respectivas de su modulo';
        BootstrapDialog.show({
            title: 'Estado Actual del Usuario',
            message: this.msg,
            type: this.type_txt,
            buttons: this.modulo
        });
    }
    delete_user($id){
        var moduleDir = function($id){
            conector.prototype.callController('control/admin.php',
                        {action:'deleteUser',
                         id: $id},
                        ()=>{},
                        (data)=>{
                            admin_herr.prototype.defin_msg_final('Aviso!!','El usuario ha sido eliminado del sistéma!!',BootstrapDialog.TYPE_SUCCESS);                                                
                        });
           }
        var buttons = [
            {
                label: 'Eliminar Usuario',
                icon: 'glyphicon glyphicon-remove',
                cssClass: 'btn-danger',
                action: function(dialog){
                    moduleDir($id);
                    menuA.getEventLineOperation();
                    dialog.close();
                }
            }
        ];
        var title = "Desea eliminar el usuario?";
        var msg = "Si se elimina el usuario, el administrador perderán toda la información relacionada con la entrega de avances o reportes, también el usuario perderá acceso al sistema.";
        var type = BootstrapDialog.TYPE_DANGER;
        this.btn_config_data(buttons,msg,title,type);     
    }
    generateForm($tipo){
            this.callController('control/admin.php',{
                action: 'FormOrUpdateinsertUser',
                id_tipo: globales_internas+1
            },()=>{

            },(data)=>{
                $('#FormsGenerate').html(data);
                $('#myModal').modal();
                $('#myModal').modal('show');
            });
    }
}
var menuA = new admin_herr();