<?php
session_start();//se inicia la sesion
require 'cnxbasededatos.php';//extrae la informacion de la conexion al servidor
//se aplican variables que permiten identificar el mensaje de las notificaciones, la confirmacion que se ha localizado el id asignatura y para eliminar
$mensaje = "";
$confirmacion = false;
$ideliminar = null;


if (isset($_POST['buscar'])) //condicional que valida si el control contiene el valor del id
{
//se valida que el campo id no este vacio y se asina el arreglo
$idBuscar = trim($_POST['IDAsignatura']);
//condicional que permite evitar una busqueda en un campo vacio si la condicion es verdadera se procede a ejecutar la consulta
if (!empty($idBuscar)) 
{
//variables con parametros de la consulta de seleccion
$consulta = $cnx->prepare("SELECT IDAsignatura, NombreAsignatura, Docente, Grupo, Aula FROM asignaturas WHERE IDAsignatura = :id");
$consulta->bindValue(':id', $idBuscar, PDO::PARAM_INT);//permite vincular en el momento de la llamada las variables correspondientes.
$consulta->execute();//se ejecuta la consulta
//permite recuperar la consulta de la variable
$asignatura = $consulta->fetch(PDO::FETCH_ASSOC);

if ($asignatura) //condicional que permite implementar las variables a los mensajes correspondientes en caso de la asignatura no se encuentre
{
$confirmacion = true;
$ideliminar = $asignatura['IDAsignatura'];
$mensaje = "Se ha encontrado la asignatura";
} 
else 
{
$mensaje = "Asignatura no registrada.";
}
}
}

if (isset($_POST['eliminar'])) //condicional que ejecutara la sentencia para borrar el registro
{
$ideliminar = $_POST['IDAsignatura'];//variable que pasa por post los datos de la asignatura
//variable que guarda los parametros para borrar el registro
$borrar = $cnx->prepare("DELETE FROM asignaturas WHERE IDAsignatura = :id");
//permite vincular en el momento de la llamada las variables correspondientes.
$borrar->bindValue(':id', $ideliminar, PDO::PARAM_STR);
$borrar->execute();//se ejecuta la consulta
//mensaje de confirmacion de que se ha borrado el registro
$mensaje = "La asignatura se ha eliminado correctamente.";
}
?>

<!DOCTYPE html><!--inicia codigo html-->
<html lang="es-MX"><!--se establece el idioma español mexico-->
<head><!--inicia la cabecera de la pagina-->
<meta charset="UTF-8"><!--se le indica que se utilizara caracteres especiales para que puedan visualizarse-->
<meta name ="viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no"/>
<title>Elimina la asignatura</title><!--titulo de la pagina-->
<link rel = "stylesheet" href = "css/bootstrap.min.css"><!-- referencia de la hoja de estilo-->
</head><!--termina la cabecera-->
<body style="background-color: #d1e0fc; "><!--inicia el cuerpo de la pagina-->

<nav class ="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #e3f2fd;">
<div class ="container-fluid">
<a class ="navbar-brand" href="#">Eliminar CE</a><!--esta clase permite establecer un logo o nombre de marca-->
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
    <header><h3 class="text-center mb-4">Busca La Asignatura a Eliminar por ID</h3></header>

    <form method="POST">
       
              <div class="text-center mt-4" >
              <label class="form-label">ID Asignatura:</label>
              <input type="text" name="IDAsignatura" class="form-control" required  minlength="6" maxlength="6" data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-placement="right"
    title="Ingresa tu ID de la asignatura a eliminar."></div>
    
    <div class="text-center mt-4">
            <button type="submit" name="buscar" class="btn btn-primary px-5">Buscar</button>
        <p style="color:red;"><?= htmlspecialchars($mensaje) ?></p></div>
    </div></div></div></div></form>

<?php if ($confirmacion): ?><!--condicional que permite habilitar el formulario con el boton de borrar solo si se encuentra el id de asignatura-->
<!--se implementa el formulario con metodo post-->

<div class="container my-5" >
    <div class="row justify-content-center">
    <div class="col-12 col-md-6 ">
    <div class="card shadow p-4" style="background-color: #a8bae6;">
    <header><h3 class="text-center mb-4">Se encontro el ID</h3>
        <h4 class="text-center mb-4">¿Estás seguro que deseas eliminar la asignatura con ID <?= htmlspecialchars($ideliminar) ?>?</h4></header>

    <form method="POST">
       
              <div class="text-center mt-4" >
              <label class="form-label">ID Asignatura:</label>
                  
    <div class="text-center mt-4">
            <button type="submit" name="eliminar" class="btn btn-primary px-5"onclick="return confirm('¿Seguro que deseas eliminar esta asignatura?')">
Eliminar Asignatura</button>
        </form><?php endif; ?>
        
    </div></div></div></div></form>
</body></html>