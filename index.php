<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$title="Regio";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title;?></title>
    <link rel="Shortcut Icon" href="vista/img/ico/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="vista/css/bootstrap.min.css">
    <link rel="stylesheet" href="vista/css/custom.css">
    <link rel='stylesheet' href="vista/libreriasjquery/DataTables/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="vista/libreriasjquery/bootstrap3-dialog/src/css/bootstrap-dialog.css">
    <link rel="stylesheet" href="vista/libreriasjquery/multiple-select-master/multiple-select.css">
    
    <link rel="stylesheet" href="vista/libreriasjquery/datetimepicker/jquery.datetimepicker.css">
    
    <script src="vista/js/jquery.min.js"></script>
    <script src="vista/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="vista/libreriasjquery/DataTables/media/js/jquery.dataTables.js">	
    </script>
    <script src="vista/libreriasjquery/DataTables/dataTables.fixedHeader.min.js">	
    </script>
    <script src="vista/libreriasjquery/DataTables/dataTables.responsive.min.js">	
    </script>
    <script src="vista/libreriasjquery/DataTables/responsive.bootstrap.min.js">	
    </script>
    <script type="text/javascript" src="vista/js/components.js"></script>
    <script type="text/javascript" src="vista/libreriasjquery/bootstrap3-dialog/src/js/bootstrap-dialog.js">
    </script>
    <script src="vista/libreriasjquery/jquery.form-validator.min.js">	
    </script>
    <script src="vista/libreriasjquery/multiple-select-master/multiple-select.js">
    </script>
    
    <script src="vista/libreriasjquery/datetimepicker/build/jquery.datetimepicker.full.min.js">
    </script>
    
    <script src="vista/libreriasjquery/zoom/jquery.zoom.js">
    </script>
  
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
    <div class="container">
	<div class="panel panel-success">
		<div class="loader"></div>
                <div id="especialidad"></div>
				<div id='TableDocumentData'>
				</div>
		</div>
		<div id='FormsGenerate'></div>
	<hr>
	<div class="navbar navbar-default navbar-fixed-bottom" >
    <div class="container">
      <p class="navbar-text pull-left">&copy <?php echo date('Y');?> 
          Tecnologico de Estudios Superiores de Chalco
      </p>
   </div>
</div>
<div id="dos"></div>
</body>
</html>
