<ul>
<?php 
if ($authj->rowff['nivel'] >= 4) { ?>
    <li><a href="#">Cursos</a>
       <ul>
          <li><a href="cursos_add.php">Agregar Curso</a></li>
          <li><a href="cursos.php">Gestion de Cursos</a></li>
       </ul>
    </li>
    <li><a href="#">Usuarios</a>
       <ul>
         <li><a href="usuarios.php">Usuarios Participantes</a></li>
         <li><a href="resultados_bus.php">Resultados Examenes</a></li>
         <li><a href="estadisticas.php">Estadisticas</a></li>
         <li><a href="estadisticas_down1.php">Generar reporte</a></li>
       </ul>
    </li>
    <?php }
	if ($authj->rowff['nivel'] >= 2) { ?>
   <!-- <li><a href="#">Estadisticas de Visitas</a>
       <ul>
         <li><a href="visitas.php">Ver Estadisticas</a></li>
         <li><a href="Vvisitas.php">Reporte estadisitcas</a></li>
       </ul>
    </li>-->
   
    <li><a href="#">Opciones Administrativas</a>
        <ul>
          <li><a href="personal.php">Cambiar Password</a></li>
          <?php if ($authj->rowff['nivel'] >= 4) { ?>
          <li><a href="config.php">Configuraciones</a></li>
          <?php }
	?>
        </ul>
    </li>
    <?php }
	?>
</ul>