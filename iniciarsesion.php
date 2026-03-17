<?php
session_start(); //  permite iniciar sesion 
    
require 'cnxbasededatos.php';//extrae la informacion de la conexion al servidor

function notificaToast($mensaje) //metodo que permitira mostrar las notificaciones
{
    echo "<div class='toast'>$mensaje</div>";//clase que permite mostrar el mensaje
    echo "<a href='iniciarsesion.html'>Regresa para iniciar sesion</a>";//permite redireccionar despues de mostrar el mensaje
    exit;
}


//si estan vacios se aplica la siguiente condicion para verificarlos
if (empty($_POST["IDUsuario"]) || empty($_POST["password"])) 
{
    notificaToast("Todos los campos son obligatorios");
}

//verifica que los campos sean correctos
$IDUsuario = trim($_POST['IDUsuario']);
$password = trim($_POST['password']);


//este metodo permite realizar la consulta a la base de datos y validar el idusuario
$consulta = $cnx->prepare("
    SELECT IDUsuario, nombre, ApellidoPaterno, ApellidoMaterno, TipoUsuario, password
    FROM usuarios  WHERE IDUsuario = ?
");
//se ejecutar la consulta con los parametros del idusuario
$consulta->execute([$IDUsuario]);
//esta condicional permite revisar si el usuario esta registrado o no
if ($consulta->rowCount() === 0) 
{
    notificaToast("El usuario no se ha registrado");
}
//consulta segura con PDO
$usuario = $consulta->fetch(PDO::FETCH_ASSOC);

// Verificar contraseña con los parametros de la consulta, permite indicar si la contraseña es incorrecta
if (!password_verify( $password, $usuario["password"])) 
{
    notificaToast("Tu usuario o contraseña son incorrectos, favor de validarlos");
}

//arreglo que permite asginar las variables que permitiran iniciar sesion
$_SESSION["IDUsuario"]     = $usuario["IDUsuario"];
$_SESSION["nombre"] = $usuario["nombre"];
$_SESSION["ApellidoPaterno"]    = $usuario["ApellidoPaterno"];
$_SESSION["ApellidoMaterno"]    = $usuario["ApellidoMaterno"];
$_SESSION["TipoUsuario"]   = $usuario["TipoUsuario"];

//esta es la condicion que permite determinar que usuario esta iniciando sesion y que pagina debe mostrar
if ($usuario["TipoUsuario"] === "es") 
{
    header("Location: menuES.php");//redirecciona a la pgina en caso de que la condicion sea verdadera
} 
else 
{
    header("Location: menuCE.php");//redirecciona a la pagina en caso de que la condicion sea falsa
}
exit;

?>
