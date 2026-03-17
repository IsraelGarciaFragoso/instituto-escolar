<?php
session_start();//se inicia la sesion
require 'cnxbasededatos.php';//extrae la informacion de la conexion al servidor
function notificaToast($mensaje) //metodo que permitira mostrar las notificaciones
{
    echo "<div class='toast'>$mensaje</div>";
    echo "<a href='consultarCE.php'>Regresar a la consulta</a>";//permite redireccionar despues de mostrar el mensaje
    exit;
}

if (!isset($_GET['idasignatura'])) //condicional que permite validar si el id de la asignatura es correcto
{
    notificaToast("El ID no es valido favor de revisarlo");
}

$idasignatura = $_GET['idasignatura'];//get permite identificar que los parametros de la variable este presente al momento de recuperarlos
//consulta con PDO que permite borrar un registro de la base de datos
$consulta = $cnx->prepare("DELETE FROM asignaturas WHERE IDAsignatura = :idasignatura");
//permite vincular en el momento de la llamada las variables correspondientes.
$consulta->bindValue(':idasignatura', $idasignatura, PDO::PARAM_STR);
$consulta->execute();//se ejecuta la consulta
notificaToast("Se ha eliminado el ID correctamente");
header("Location: consultarCE.php");
exit;
?>
