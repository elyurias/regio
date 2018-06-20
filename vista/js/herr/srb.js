$(function(){
    $(".loader").fadeOut("hide");
    menuC.getAllRs('#Rs_c');
});
var globales_internas = 0;
class toRd extends conector{
    constructor(){
        super();
        this.menu = 0;
        this.i_global = 0;
        globales_internas = 0;
    }
    addToClassLine($classActiveNew){
        var arrayPunt = [
            '#A_c','#Rs_c'
        ];
        for(var $i=0; $i < arrayPunt.length; $i++){
            if($classActiveNew === arrayPunt[$i]){
                $(arrayPunt[$i]).addClass('active');
            }else{
                $(arrayPunt[$i]).removeClass('active');
            }
        }
    }
    getAllRs($punt){
        this.i_global = 1;
        globales_internas = 1;
        this.addToClassLine($punt);
        var a = this.callController(
            "control/rd.php",
            {
                action: 'getMyRsAll'
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
    getEventLineOperation(){
        switch(globales_internas){
            case 1:
                this.getAllRs('#Rs_c');
            break;
            case 2:
                this.getActividades('#A_c');
            break;
        }
    }
    get_formulario_actividad($id){
        var a = this.callController(
            "control/rd.php",
            {
                action: 'getFormToActivity',
                id_rd_rs: $id
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#FormsGenerate').html(data);
                $('#myModal').modal();
                $('#myModal').modal('show');
            }
        );
    }
    get_all_actividades($id, $userName){
        var a = this.callController(
            "control/rd.php",
            {
                action: 'getAllActivitys',
                id_rd_rs: $id,
                username: $userName
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#FormsGenerate').html(data);
                $('#myModal').modal();
                $('#myModal').modal('show');
            }
        );
    }
    insertActividad(){
        var a = this.callController(
            "control/rd.php",
            $('registro_actualiza_actividad').serialize()
            ,
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
            }
        );
    }
    delete_actividad($id){
        var a = function(dialog){
            toRd.prototype.callController(
                "control/rd.php",
                {
                    action:"eliminarActividad",
                    id_actividad: $id
                }
                ,
                function(){
                
                },
                function(data){
                    if(data.trim()==1){
                        toRd.prototype.defin_msg_final(
                                'Aviso!',
                                "La actividad ha sido eliminada",
                                BootstrapDialog.TYPE_SUCCESS
                        );
                        $('#componente_slash'+$id).empty();
                        dialog.close();
                    }else{
                        toRd.prototype.defin_msg_final(
                                'Aviso!',
                                "FATAL ERROR: SYSTEM",
                                BootstrapDialog.TYPE_DANGER
                        );
                    }
                }
            );
        }
        var buttons = [
            {
                label: "Eliminar Actividad",
                icon: 'glyphicon glyphicon-eye-open',
                cssClass: 'btn-primary',
                action: function(dialog){
                    a(dialog);                                        
                }
            }
        ];
        this.btn_config_data(
            buttons, 
            "Desea eliminar la actividad?, una vez eliminada, la actividad no sera mostrada en ninguna parte del sistema", 
            "Eliminar la actividad!", 
            BootstrapDialog.TYPE_SUCCESS
        );
    }
    leer_actividad($id){
        this.callController(
            "control/rd.php",
            {
                action: 'getMyImages',
                id_actividad: $id
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#dos').empty();
                $('#dos').html(data);
                $('#myModalDos').modal();
                $('#myModalDos').modal('show');
            }
        );
    }
}
var menuC = new toRd();