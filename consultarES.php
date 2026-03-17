<?php
session_start(); //se inicia la sesion
require 'cnxbasededatos.php';//extrae la informacion de la conexion al servidor


$IDUsuario = $_SESSION["IDUsuario"];//se implementa la variable que contiene el id principal
//consulta sql para mostrar las asignaturas correspondientes
$resultado1 = $cnx->prepare("SELECT IDUsuario, Nombre, ApellidoPaterno, ApellidoMaterno FROM usuarios WHERE IDUsuario = ? ");

$resultado1->execute([$IDUsuario]);//ejecuta los parametros de la variable de la consulta1
$usuario = $resultado1->fetch(PDO::FETCH_ASSOC);//permite recuperar la consulta de la variable
//consulta sql para mostrar las asignaturas correspondientes
$resultado2 = $cnx->prepare("SELECT IDAsignatura, NombreAsignatura, Docente, Grupo, Aula FROM asignaturas WHERE IDUsuario = ? ");
$resultado2->execute([$IDUsuario]);//ejecuta los parametros de la variable de la consulta2
?>

<!DOCTYPE html><!--inicia codigo html -->
<html lang="es-MX"><!--se invoca el idioma de la region-->
<head><!--inicia la cabecera-->
<meta charset="UTF-8"><!--se establece el formato para mostrar caracteres como ñ o acentos-->
<meta name ="viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no"/>
<title>Mis asignaturas</title><!--titulo de la pagina -->
<link rel = "stylesheet" href = "css/bootstrap.min.css"><!-- referencia de la hoja de estilo-->

</head><!--termina cabecera-->
<body style="background-color: #d1e0fc; "><!--inicia cuerpo de la pagina-->

  <!--se implementa la barra de navegacion y los stributos como color o que este fijo al hacer scroll-->
<nav class ="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #e3f2fd;">
<div class ="container-fluid">
<a class ="navbar-brand" href="#">Consultar ES</a><!--esta clase permite establecer un logo o nombre de marca-->
<!--se establece los botones de la barra de navegacion asi como sus atributos-->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<!--se estable las propiedades del menu de hamburguesa-->
<div class="collapse navbar-collapse" id="navbarNav">   
<ul class="navbar-nav">
<!--aqui se establece el nombre de las opciones de la barra a modo de referencia-->
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="menuES.php">Bienvenida</a></li>
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="consultarES.php">Consultar</a></li>
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="inscribirES.html">Inscribir</a></li>
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="cerrarsesion.php">Salir</a></li>
</ul> </div> </div></nav><!--termina contenedores de la barra de navegacion-->
<!--se invoca el archivo js de bootstrap-->
<script src="js/bootstrap.bundle.min.js"></script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>

 <div class="container my-5" >
  <div class="row justify-content-center">
    <div class="col-12 col-md-6 ">
      <div class="card shadow p-4" style="background-color: #a8bae6;">
      <header>  
      <h2 class="text-center mb-4">Asignaturas a las que estoy inscrito</h2></header>
    <img src = aula.png class="img-fluid rounded mx-auto d-block" style="max-height:200px;">    
    </div>
     </div>
  </div></div>

   <div class="container my-5" >
<div class="table-responsive">
    <div class="card shadow p-4" style="background-color: #a8bae6;">
        <header>  
      <h2 class="text-center mb-4">Datos del Alumno</h2></header>
  <table class="table table-bordered table-striped align-middle text-center">
    <thead class="table-primary">
      <tr>
        <th>ID Usuario</th>
        <th>Nombre</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?=htmlspecialchars($usuario['IDUsuario'])?></td>
        <td><?=htmlspecialchars($usuario['Nombre'])?></td>
        <td><?=htmlspecialchars($usuario['ApellidoPaterno'])?></td>
        <td><?=htmlspecialchars($usuario['ApellidoMaterno'])?></td>
      </tr>
    </tbody>
  </table>
</div></div></div>

<div class="container my-5 " >
 <div class="table-responsive">
    <div class="card shadow p-4 " style="background-color: #a8bae6;">
        <header>  
      <h2 class="text-center mb-4 ">Datos de la Asignatura</h2></header>
  <table class="table table-bordered table-striped table-hover align-middle text-center">
    <thead class="table-primary">
      <tr>
        <th>ID Asignatura</th>
        <th>Asignatura</th>
        <th>Docente</th>
        <th>Grupo</th>
        <th>Aula</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
          <td><?= htmlspecialchars($fila['IDAsignatura']) ?></td>
          <td><?= htmlspecialchars($fila['NombreAsignatura']) ?></td>
          <td><?= htmlspecialchars($fila['Docente']) ?></td>
          <td><?= htmlspecialchars($fila['Grupo']) ?></td>
          <td><?= htmlspecialchars($fila['Aula']) ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div></div></div>

  
  
</body>
</html><!--termina el cuerpo y el codigo html -->