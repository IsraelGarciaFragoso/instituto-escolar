<?php
session_start();//se inicia la sesion
require 'cnxbasededatos.php';//se invoca el metodo para conectarse a la base de datos
function notificaToast($mensaje) //metodo que permitira mostrar las notificaciones
{
echo "<div class='toast'>$mensaje</div>";
echo "<a href='consultarCE.php'>Regresar a la consulta</a>";//permite redireccionar despues de mostrar el mensaje
exit;
}
if ($_SESSION["TipoUsuario"] !== "ce") //condicion que valida si el usuario es ce para evitar que otro usuario modifique las asignaturas
{
notificaToast("No tienes autorizado modificar estos campos");
}
//variables que se implementaran para validar la asignatura y los mensajes
$asignatura = null;
$mensaje1 = "";
$mensaje2 = "";

if (isset($_POST['buscar'])) //esta condicional valida que los datos de la variable pasen por el metodo post
{

$idBuscar = trim($_POST['IDAsignatura']);//esta variable valida que el formato del control de post tenga informacion

if (!empty($idBuscar)) //esta condicional permite validar que la variable no este vacia
{
//consulta con PDO para seleccionar los campos de la tabla asignaturas
$resultado = $cnx->prepare("SELECT IDAsignatura, NombreAsignatura, Docente, Grupo, Aula FROM asignaturas WHERE IDAsignatura = :id");
//permite vincular en el momento de la llamada las variables correspondientes
$resultado->bindValue(':id', $idBuscar, PDO::PARAM_STR);
$resultado->execute();//se ejecuta la consulta
//permite recuperar la consulta de la variable
$asignatura = $resultado->fetch(PDO::FETCH_ASSOC);

if (!$asignatura) //condicional que permite validar si el contenido de la variable no coincide con la busqueda
{
$mensaje1 = "La asignatura no se ha encontrado, favor de validarlo.";
}
}
}

if (isset($_POST['actualizar'])) //condicional que permite asignar a la variable los elementos del formulario para despues ingresarlos al update de mysql
{
    //datos de las variables
$id = $_POST['IDAsignatura'];
$NombreAsignatura = $_POST['NombreAsignatura'];
$Docente = $_POST['Docente'];
$Grupo = $_POST['Grupo'];
$Aula = $_POST['Aula'];
//se asigna la variable para realizar la actualizacion
$actualizar = $cnx->prepare("UPDATE asignaturas SET NombreAsignatura = :NombreAsignatura, Docente = :Docente, Grupo = :Grupo, Aula = :Aula 
WHERE IDAsignatura = :id");
//se ejecuta el comando con los parametros de mysql
$actualizar->execute([':NombreAsignatura' => $NombreAsignatura,':Docente' => $Docente,':Grupo' => $Grupo,':Aula' => $Aula,':id' => $id]);
//despues de ejecutar la actualizacion se muestra el mensaje correspondiente
$mensaje2 = "La asignatura se ha actualizado correctamente.";
}
?>

<!DOCTYPE html><!--inicia codigo html-->
<html lang="es-MX"><!--se establece el idioma español mexico-->
<head><!--inicia la cabecera de la pagina-->
<meta charset="UTF-8"><!--se le indica que se utilizara caracteres especiales para que puedan visualizarse-->
<meta name ="viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no"/>
<title>Registro de Asignaturas</title><!--titulo de la pagina-->
<link rel = "stylesheet" href = "css/bootstrap.min.css"><!-- referencia de la hoja de estilo-->
</head><!--termina la cabecera-->
<body style="background-color: #d1e0fc; "> <!--inicia el cuerpo de la pagina-->
<nav class ="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #e3f2fd;">
<div class ="container-fluid">
<a class ="navbar-brand" href="#">Modificar CE</a><!--esta clase permite establecer un logo o nombre de marca-->
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
<!--se genera el formulario con el metodo post-->

<div class="container my-5" >
    <div class="row justify-content-center">
    <div class="col-12 col-md-6 ">
    <div class="card shadow p-4" style="background-color: #a8bae6;">
    <header><h3 class="text-center mb-4">Busca La Asignatura a Modificar por ID</h3></header>

    <form method="POST">
       
              <div class="text-center mt-4" >
              <label class="form-label">Buscar Asignaturas por ID Alumno:</label>
              <input type="text" name="IDAsignatura" class="form-control" required  minlength="6" maxlength="6" data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Ingresa tu ID de la asignatura minimo y maximo 6 digitos."></div>
    
    <div class="text-center mt-4">
            <button type="submit" name="buscar" class="btn btn-primary px-5">Buscar</button>
        <p style="color:red;"><?= htmlspecialchars($mensaje1) ?></p>
        <p style="color:red;"><?= htmlspecialchars($mensaje2) ?></p></div>
    </div></div></div></div></form>


<?php if ($asignatura): ?>
<!--la condicional permite mostrar la informacion de la consulta anterior con la variable a evaluar y se mostraran dentro de los controles del formulario-->

<div class="container my-5" >
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 ">
    <div class="card shadow p-4" style="background-color: #a8bae6;">
    
    <form method="POST">

    <header><h3 class="text-center mb-4">Se encontro el ID <br>Ahora modifica los datos de la asignatura</h3></header>   
            
            <div class="text-center mt-4" >
              <input type="hidden" name="IDAsignatura" value="<?= htmlspecialchars($asignatura['IDAsignatura']) ?>">
            </div>
    
             
            <div class="text-center mt-4" >
              <label class="form-label">Asignatura:</label>
              <input type="text" name="NombreAsignatura"class="form-control" value="<?= htmlspecialchars($asignatura['NombreAsignatura']) ?>"required data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica la asignatura">
            </div>

    
                <div class="text-center mt-4" >
              <label class="form-label">Docente:</label>
              <input type="text" name="Docente" class="form-control"value="<?= htmlspecialchars($asignatura['Docente']) ?>" required data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica nombre del docente">
            </div><

    
                <div class="text-center mt-4" >
              <label class="form-label">Grupo:</label>
              <input type="text" name="Grupo" class="form-control" value="<?= htmlspecialchars($asignatura['Grupo']) ?>" required data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica el grupo">
            </div>

    
                <div class="text-center mt-4" >
              <label class="form-label">Aula:</label>
              <input type="text" name="Aula" class="form-control" value="<?= htmlspecialchars($asignatura['Aula']) ?>" required data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Modifica el grupo">
            </div>

            <div class="text-center mt-4">
            <button type="submit" name="actualizar"  class="btn btn-primary px-5">Guardar Cambios</button>
          </div>

       </div>
    </div>
</div>
<?php endif; ?><!--termina condicional if-->
</form></body></html>


