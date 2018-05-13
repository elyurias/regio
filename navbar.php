	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#!">Protegido</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <script src="vista/js/herr/conector.js"></script>
      <?php
        switch($_SESSION['user_type']){
          case 1:     //Administrator Master
      ?>
        <script src="vista/js/herr/admin.js"></script>
        <li id = 'SC_c'><a onclick="menuA.getDataSC('#SC_c');" href="#"><i  class='glyphicon glyphicon-user'></i> SC</a></li>
        <li id = 'RD_c'><a onclick="menuA.getDataRD('#RD_c');" href="#"><i  class='glyphicon glyphicon-user'></i> RD</a></li>
	<li id = 'RS_c'><a onclick="menuA.getDataRS('#RS_c');" href="#"><i  class='glyphicon glyphicon-user'></i> RS</a></li>
      <?php
          break;
          case 2: //Director Academico o Algo de ese nivel          
      ?>
        <script src="vista/js/herr/acad.js"></script>
        <li id = 'SC_c'><a onclick="menuB.getDataAll(1,'#SC_c');" href="#"><i  class='glyphicon glyphicon-user'></i> SC</a></li>
        <li id = 'RD_c'><a onclick="menuB.getDataAll(2,'#RD_c');" href="#"><i  class='glyphicon glyphicon-user'></i> RD</a></li>
      <?php
          break;
          case 3://Garduño...
      ?>
        <script src="vista/js/herr/srb.js"></script>
        <li id = 'Rs_c'><a onclick="menuC.getAllRs('#Rs_c');" href="#"><i  class='glyphicon glyphicon-user'></i> Mis RS</a></li>
      <?php
          break;
          case 4://Docentes
      ?>
        <script src="vista/js/herr/doc.js"></script>
        <li id = 'SC_c'><a onclick="menuD.getDataAll('#SC_c');" href="#"><i  class='glyphicon glyphicon-user'></i> Mis Actividades</a></li>        	      
      <?php    
          break;
        }
      ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" target='_blank'><i class='glyphicon glyphicon-envelope'></i> Soporte</a></li>
        <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>