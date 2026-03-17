<?php
session_start(); 
require "cnxbasededatos.php";//se invoca el metodo para conectarse a la base de datos

if (!isset($_SESSION["IDUsuario"])) 
{
    header("Location: iniciarsesion.html");//si la condicion es correcta redirecciona a la pagian del menuce
    exit;
}


function notificaToast($mensaje) //metodo que permitira mostrar las notificaciones
{
    echo "<div class='toast'>$mensaje</div>";
    echo "<a href='inscribirCE.html'>Regresar al formulario</a>";//permite redireccionar despues de mostrar el mensaje
    exit;
}

$IDUsuario = $_SESSION["IDUsuario"];


foreach ($_POST as $campo) //ciclo foreach que valida cada campo del registro no esté vacio
{
    if (empty(trim($campo))) 
    {
        notificaToast("Algunos campos estan vacios, favor de validar.");//mensaje de notificacion a usuario
    }
}
//variables que campturan la informacion del formulario
$idasigna  = trim ($_POST["IDAsignatura"]);
$nomasigna = trim ($_POST["NombreAsignatura"]);
$docente = trim ($_POST["Docente"]);
$grupo = trim ($_POST["Grupo"]);
$aula = trim ($_POST["Aula"]);

// Verificar si existe idusuario
$consulta = $cnx->prepare("SELECT 1 FROM asignaturas WHERE IDUsuario = ? AND IDAsignatura= ?");
$consulta->execute([$IDUsuario, $idasigna]);//se ejecuta la consulta

if ($consulta->rowCount() > 0) //condicional que permite validar si el id ya esta registrado
{
    notificaToast("El ID de la asignatura ya esta registrado, favor de ingresar otro.");//notificacin de idi ya registrado
}


// comando para preparar la insercion de usuario
$inserta = $cnx->prepare("INSERT INTO asignaturas (IDAsignatura,IDUsuario, NombreAsignatura, Docente, Grupo, Aula)
    VALUES (?, ?, ?, ?, ?, ?)");

$inserta->execute//comando para insertar los datos del formulario en la base de datos
    ([$idasigna,$IDUsuario, $nomasigna, $docente, $grupo, $aula]);


notificaToast("Se ha registrado sus asignaturas correctamente");//notificacion de que el estudiante se insertó correctamente


?>

