<?php
class utilidades{
    function getTablaScript($id,$order): String{
            return <<<EOT
            <script>
                $(()=>{
                    $('[data-toggle="tooltip"]').tooltip();
                    var tableLN = $('#$id').DataTable({
                        "language": {
                            "url": "vista/js/json/lenguaje.json"
                        },
                        responsive: true,
                        columnDefs: [
                            { responsivePriority: 1, targets: 0 },
                            { responsivePriority: 2, targets: 0 }
                        ]$order
                    });
                    new $.fn.dataTable.FixedHeader( tableLN );
                })
            </script>
EOT;
    }
    function thead($array,$id): String{
        $cadena = '<thead><tr>';
        for ($i = 0; $i < SIZEOF($array); $i++) {
            $cadena.= <<<EOT
                   <th>
                        {$array[$i]}
                   </th>
EOT;
        }
        $cadena.="</tr></thead>";
        return $cadena;
    }
    function table($script, $id, $thead, $tbody): String{
        return $script.'<table id="'.$id.'" class="table table-striped table-bordered nowrap" style="width:100%">'
                .$thead.$tbody.'</table>';
    }
    function getImages($images){
        return <<<EOT
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title panel-primary" id="myModalLabel">Mi evidencia</h4>
                  </div>
                <script>
                    $('#myModal').on('hidden.bs.modal', function () {
                        $('#FormsGenerate').empty();
                    });
                </script>
                <div class="modal-body">
                    <center>
                        <img src="control/{$images[0]}" height="50%" width="50%">
                        <img src="control/{$images[1]}" height="50%" width="50%">
                    </center>
                </div>
                </div>
              </div>
            </div>
EOT;
    }
    public function get_cadena_vista($limite, $limiteDeCadena, $cadena){
            $procesa = "";
            for($i=0;$i < STRLEN($cadena); $i++){
                $nvar = "";
                if($i==$limite){
                    $valSiguienteLetra = substr($cadena, $i+1,1);
                    if(strcmp($valSiguienteLetra," ")>0){
                        $nvar.="-";
                    }
                    $nvar.= "<br>";
                    $limite = $limite + $limiteDeCadena;
                }
                $procesa.= substr($cadena, $i,1).$nvar;
            }
            return $procesa;
    }
}
