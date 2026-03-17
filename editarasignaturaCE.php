<?php
session_start();//se inicia la sesion
require 'cnxbasededatos.php';//extrae la informacion de la conexion al servidor
function notificaToast($mensaje) //metodo que permitira mostrar las notificaciones
{
    echo "<div class='toast'>$mensaje</div>";
    echo "<a href='consultarCE.php'>Regresar a la consulta</a>";//permite redireccionar despues de mostrar el mensaje
    exit;
}
if ($_SESSION["TipoUsuario"] !== "ce") //condicional que permite impedir que usuarios distintos a ce modifiquen las asignaturas
{
    notificaToast("No tienes autorizado modificar las asignaturas");
}
if (!isset($_GET['idasignatura'])) //condicional que permite validar si el id de la asignatura es correcto
{
    notificaToast("El Id de la asigntura es invalido, favor de verificar");
}

$idasignatura = $_GET['idasignatura'];//get permite identificar que los parametros de la variable este presente al momento de recuperarlos
//consulta con PDO que permite recuperar los datos de la tabla asignaturas
$consulta = $cnx->prepare("SELECT IDAsignatura, NombreAsignatura, Docente, Grupo, Aula  FROM asignaturas WHERE IDAsignatura = :idasignatura");
//permite vincular en el momento de la llamada las variables correspondientes.
$consulta->bindValue(':idasignatura', $idasignatura, PDO::PARAM_INT);
$consulta->execute();//se ejecuta la consulta

$asignatura = $consulta->fetch(PDO::FETCH_ASSOC);//permite recuperar la consulta de la variable

if (!$asignatura) //consulta que permite notificar si la variable fue encontrada o no
{
    notificaToast("La asignatura no ha sido encontrada");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") //permite validar que los envios de post sean correctos en este caso los del formulario
{
    //variables asignadas los campos de la base de datos con el metodo post
$NombreAsignatura = $_POST['NombreAsignatura'];
$Docente = $_POST['Docente'];
$Grupo = $_POST['Grupo'];
$Aula = $_POST['Aula'];
//comando sql que permite actualizar los datos desde el formulario a la base de datos
$update = $cnx->prepare("UPDATE asignaturas SET NombreAsignatura = :NombreAsignatura,Docente = :Docente, Grupo = :Grupo, Aula = :Aula WHERE IDAsignatura = :idasignatura");
//permite ejecutar y comparar los datos de las variables con la base de datos
$update->execute([ ':NombreAsignatura' => $NombreAsignatura, ':Docente' => $Docente, ':Grupo' => $Grupo, ':Aula' => $Aula, ':idasignatura' => $idasignatura ]);
notificaToast("Se ha modificado las asignaturas del alumno correctamente");//notificacion de que el estudiante se insertó correctamente
exit;
}
?>
<!DOCTYPE html><!--inicia codigo html-->
<html lang="es-MX"><!--se establece el idioma español mexico-->
<head><!--inicia la cabecera de la pagina-->
<meta charset="UTF-8"><!--se le indica que se utilizara caracteres especiales para que puedan visualizarse-->
<meta name ="viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no"/>
<title>Editar Asignaturas</title><!--titulo de la pagina-->
<link rel = "stylesheet" href = "css/bootstrap.min.css"><!-- referencia de la hoja de estilo-->
</head><!--termina la cabecera-->
<body style="background-color: #d1e0fc; "><!--inicia el cuerpo de la pagina-->

<nav class ="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #e3f2fd;">
<div class ="container-fluid">
<a class ="navbar-brand" href="#">Asignaturas CE</a><!--esta clase permite establecer un logo o nombre de marca-->
<!--se establece los botones de la barra de navegacion asi como sus atributos-->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<!--se estable las propiedades del menu de hamburguesa-->
<div class="collapse navbar-collapse" id="navbarNav">   
<ul class="navbar-nav">
<!--aqui se establece el nombre de las opciones de la barra a modo de referencia-->
<li class ="nav-item"><a class="nav-link active" aria-current="page" href="index.html">Inicio</a></li>
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
    <header><h3 class="text-center mb-4">Editar Los Datos de La Asignatura Del Alumno</h3></header>

    <form method="POST">
       
              <div class="text-center mt-4" >
              <label class="form-label">Asignatura:</label>
              <input type="text" name="NombreAsignatura" class="form-control" value="<?= htmlspecialchars($asignatura['NombreAsignatura']) ?>" required  data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica tu asignatura."></div>
    
              <div class="text-center mt-4" >
              <label class="form-label">Docente:</label>
              <input type="text" name="Docente" class="form-control" value="<?= htmlspecialchars($asignatura['Docente']) ?>" required  data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica tu Docente."></div>

              <div class="text-center mt-4" >
              <label class="form-label">Grupo:</label>
              <input type="text" name="Grupo" class="form-control" value="<?= htmlspecialchars($asignatura['Grupo']) ?>" required  data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica tu Grupo."></div>

            <div class="text-center mt-4" >
              <label class="form-label">Aula:</label>
              <input type="text" name="Aula" class="form-control" value="<?= htmlspecialchars($asignatura['Aula']) ?>" required  data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica tu Aula."></div>

    <div class="text-center mt-4">
            <button type="submit"  class="btn btn-primary px-5">Actualizar Los Cambios</button>
        </div>
    </div></div></div></div></form>
</body>
</html>
