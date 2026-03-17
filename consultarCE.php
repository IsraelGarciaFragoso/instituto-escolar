<!DOCTYPE html><!--inicia codigo html -->
<html lang="es-MX"><!--se invoca el idioma de la region-->
<head><!--inicia la cabecera-->
<meta charset="UTF-8"><!--se establece el formato para mostrar caracteres como ñ o acentos-->
<meta name ="viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no"/>
<title>Consultas Control Escolar</title><!--titulo de la pagina -->
<link rel = "stylesheet" href = "css/bootstrap.min.css"><!-- referencia de la hoja de estilo-->

</head><!--termina cabecera-->
<body style="background-color: #d1e0fc; "><!--inicia cuerpo de la pagina-->
<!--se implementa la barra de navegacion y los stributos como color o que este fijo al hacer scroll-->
<nav class ="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #e3f2fd;">
<div class ="container-fluid">
<a class ="navbar-brand" href="#">Consultar CE</a><!--esta clase permite establecer un logo o nombre de marca-->
<!--se establece los botones de la barra de navegacion asi como sus atributos-->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<!--se estable las propiedades del menu de hamburguesa-->
<div class="collapse navbar-collapse" id="navbarNav">   
<ul class="navbar-nav">
<!--aqui se establece el nombre de las opciones de la barra a modo de referencia-->
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="menuCE.php">Bienvenida</a></li>
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="consultarCE.php">Consultar</a></li>
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="inscribirCE.html">Inscribir</a></li>
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="modificarasignaturamenuCE.php">Modificar</a></li>
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="eliminarasignaturamenuCE.php">Eliminar</a></li>
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
      <h2 class="text-center mb-4">Asignaturas</h2></header>
    <img src = asignatura.JPG class="img-fluid rounded mx-auto d-block" style="max-height:200px;">    
    </div>
     </div>
  </div></div>

    <div class="container my-5" >
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 ">
    <div class="card shadow p-4" style="background-color: #a8bae6;">
    <header><h3 class="text-center mb-4">Buscar Alumno:</h3></header>

    <form action="" method="POST">
       
              <div class="text-center mt-4" >
              <label class="form-label">Buscar Asignaturas por ID Alumno:</label>
              <input type="text" name="buscar" class="form-control" required  minlength="4" maxlength="4" data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Ingresa tu ID de estudiante."></div>
    
<div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5">Buscar</button>
           </div></div></div></div>
        </form>

</body></div></html><!--termina el cuerpo y el codigo html -->



<?php
session_start(); //se mantiene la sesion en php

require 'cnxbasededatos.php';//extrae la informacion de la conexion al servidor

if (isset($_POST['buscar']) && !empty($_POST['buscar'])) //condicional que valida si la variable buscar del formulario esta vacia
{
$busqueda = trim($_POST['buscar']);//se integra la variable del formulario a la del codigo php y se implementa trim para que no vayan vacias
//consulta sql con PDO para extraer los datos de la tabla usuarios
$resultado1 = $cnx->prepare("SELECT IDUsuario, Nombre, ApellidoPaterno, ApellidoMaterno FROM usuarios 
WHERE IDUsuario = :busqueda");
$resultado1 ->bindValue(':busqueda', $busqueda, PDO::PARAM_INT);//permite vincular en el momento de la llamada las variables correspondientes.

$resultado1->execute();//ejecuta los parametros de la variable de la consulta

$usuario = $resultado1->fetch(PDO::FETCH_ASSOC);//permite recuperar la consulta de la variable
  
if($usuario)//condicional que valida los parametros de la variable
    {
    //parametros que permiten hacer la consulta a la tabla asignaturas para extraer la informacion
    $resultado2 = $cnx->prepare("SELECT IDAsignatura, NombreAsignatura, Docente, Grupo, Aula FROM asignaturas 
    WHERE IDUsuario = :busqueda");//consulta sql para mostrar las asignaturas correspondientes
    $resultado2 ->bindValue(':busqueda', $busqueda, PDO::PARAM_INT);//permite vincular en el momento de la llamada las variables correspondientes.
    $resultado2->execute();//ejecuta los parametros de la variable de la consulta

//se emplea echo para la salida del texto en este caso de las celdas
echo " <div class='container my-5' >"; 
echo "<div class='table-responsive'>"; 
echo "<div class='card shadow p-4' style='background-color: #a8bae6;'>";
echo "<header>";//Este es el titulo principal y por lo tanto el mas grande
echo "<h2 class='text-center mb-4'>Datos del Alumno</h2></header>";
echo "<table class='table table-bordered table-striped align-middle text-center'>";//se inicia la tabla donde se mostraran los datos de la consulta de citas
echo "<thead class='table-primary'>";
echo "<tr>
<th>ID Usuario</th><th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th></tr></thead>";
//se implementar htmlspecialchars para evitar injecciones por sql se hace el llamado de la variable que contiene el arreglo los datos de las tablas
echo "<tbody><tr>
<td>". htmlspecialchars($usuario['IDUsuario'])."</td>
<td>". htmlspecialchars($usuario['Nombre'])."</td>
<td>". htmlspecialchars($usuario['ApellidoPaterno'])."</td>
<td>". htmlspecialchars($usuario['ApellidoMaterno'])."</td>
</tr></tbody>
  </table>
</div></div></div>"; 

//se emplea echo para la salida del texto en este caso de las celdas
echo " <div class='container my-5' >"; 
echo "<div class='table-responsive'>"; 
echo "<div class='card shadow p-4' style='background-color: #a8bae6;'>";
echo "<header>";//Este es el titulo principal y por lo tanto el mas grande
echo "<h2 class='text-center mb-4'>Asignaturas del Profesor</h2></header>";
echo "<table class='table table-bordered table-striped align-middle text-center'>";//se inicia la tabla donde se mostraran los datos de la consulta de citas
echo "<thead class='table-primary'>";
echo "<tr>
<th>ID de asignatura</th><th>Asignatura</th><th>Docente de asignatura</th><th>Grupo</th><th>Aula</th><th>Editar</th><th>Borrar</th>
</tr>";//se construyen las cabeceras de las tablas
 while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) 
{ //esta ciclo while permite recorrer todas las filas para mostrar la informacion con el arreglo asociado
echo "<tbody><tr> 
<td>". htmlspecialchars($fila['IDAsignatura']). "</td>
<td>". htmlspecialchars($fila['NombreAsignatura'])."</td>
<td>". htmlspecialchars($fila['Docente']). "</td>
<td>". htmlspecialchars($fila['Grupo']). "</td>
<td>". htmlspecialchars($fila['Aula']). "</td>
<td> <a href='editarasignaturaCE.php?idasignatura=".$fila['IDAsignatura']."'><button class='btn btn-primary px-5' >Editar</button></a></td>
<td> <a href='eliminarasignaturaCE.php?idasignatura=".$fila['IDAsignatura']."'onclick='return confirm(\"¿Seguro que deseas eliminar?\")'><button class='btn btn-primary px-5' >Eliminar</button></a></td>
</tr></tbody>";

// <!--termina el ciclo  -->
}
echo "</table></div></div>";
}
else//de lo contrario se mostrara el mensaje de sin resultados
{
    echo " <div class='container my-5' >"; 
    echo "<div class='table-responsive'>"; 
    echo "<div class='card shadow p-4' style='background-color: #a8bae6;'>";
    echo "<header>";
    echo "<h2 class='text-center mb-4'>No hay resultados que mostrar.</h2></header></div></div></div>";
    
}
}?>



