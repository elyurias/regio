$(function(){
    $(".loader").fadeOut("hide");
    menuD.getDataAll('#SC_c');
});
global_id_control = 0;
class menuTotalUser extends conector{
    addToClassLine($classActiveNew){
        //La repeti tres veces... se deberia corregir esto y meterlo en control o otra clase
        // no deduje que se utilizaria posteriormente
        var arrayPunt = [
            '#SC_c'
        ];
        for(var $i=0; $i < arrayPunt.length; $i++){
            if($classActiveNew === arrayPunt[$i]){
                $(arrayPunt[$i]).addClass('active');
            }else{
                $(arrayPunt[$i]).removeClass('active');
            }
        }
    }
    getDataAll($id_menu){
        this.addToClassLine($id_menu);
        var a = this.callController(
            "control/rs.php",
            {
                action: 'getMyRd'
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
    get_actividades($id_actividades){
        global_id_control = $id_actividades;
        this.callController(
            "control/rs.php",
            {
                action: 'get_actividades_rs',
                id_rd_rs: $id_actividades
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
    get_actividad_id($id_actividad){
        this.callController(
            "control/rs.php",
            {
                action: 'get_form_actividad',
                id_actividad_resp: $id_actividad
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#FormsGenerate').empty();
                $('#FormsGenerate').html(data);
                $('#myModal').modal();
                $('#myModal').modal('show');
            }
        );
    }
    //getMyImages
    get_actividad_id_rev($id){
        this.callController(
            "control/rs.php",
            {
                action: 'getMyImages',
                id_actividad: $id
            },
            function(){
                $(".loader").fadeOut("slow");
            },
            function(data){
                $(".loader").fadeOut("hide");
                $('#FormsGenerate').empty();
                $('#FormsGenerate').html(data);
                $('#myModal').modal();
                $('#myModal').modal('show');
            }
        );
    }
}
var menuD = new menuTotalUser();