<?php
require "cnxbasededatos.php";//se invoca el metodo para conectarse a la base de datos


function notificaToast($mensaje) //metodo que permitira mostrar las notificaciones
{
    echo "<div class='toast'>$mensaje</div>";
    echo "<a href='registroES.html'>Regresar al formulario</a>";//permite redireccionar despues de mostrar el mensaje
    exit;
}

foreach ($_POST as $campo) //ciclo foreach que valida cada campo del registro no esté vacio
{
    if (empty(trim($campo))) 
    {
        notificaToast("Algunos campos estan vacios, favor de validar.");//mensaje de notificacion a usuario
    }
}
//variables que campturan la informacion del formulario
$id  = trim ($_POST["IDUsuario"]);
$nombre = trim ($_POST["Nombre"]);
$apepat = trim ($_POST["ApellidoPaterno"]);
$apemat = trim ($_POST["ApellidoMaterno"]);
$edad = trim ($_POST["Edad"]);
$sexo = trim ($_POST["Sexo"]);
$email = trim ($_POST["Email"]);
$telefono = trim ($_POST["Telefono"]);
$tipousa = trim ($_POST["TipoUsuario"]);
$pass = trim ($_POST["Password"]);
$confirmar = trim ($_POST["confirmar"]);

if ($pass !== $confirmar) // Validar contraseñas iguales
{
    notificaToast("Las contraseñas deben ser iguales");//mensaje que indica que las contraseñas no son iguales
}

// algoritmo que permite validar que la contraseña cumpla con los criterios solicitados
if (
    strlen($pass) < 8 ||
    !preg_match("/[A-Za-z]/", $pass) ||
    !preg_match("/[0-9]/", $pass) ||
    !preg_match("/[\W]/", $pass)
) 
{//notificacion cuando la contraseña no cumple con los criterios
    notificaToast("La contraseña debe ser minimo 8 caracteres, incluye un  numero, una letra y un caracter especial");
}

// Verificar si existe idusuario
$consulta = $cnx->prepare("SELECT IDUsuario FROM usuarios WHERE IDUsuario= ?");
$consulta->execute([$id]);//se ejecuta la consulta

if ($consulta->rowCount() > 0) //condicional que permite validar si el id ya esta registrado
{
    notificaToast("El ID del estudiante ya esta registrado, favor de ingresar otro.");//notificacin de idi ya registrado
}

//se aplica filtro para validar correo 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
    notificaToast("Formato de correo invalido, favor de verificarlo.");//notificacion que permite validar el formato del email
    }

//se establece la proteccion hash de la contraseña
$hash = password_hash($pass, PASSWORD_BCRYPT);

// comando para preparar la insercion de usuario
$inserta = $cnx->prepare
("INSERT INTO usuarios (IDUsuario, Nombre, ApellidoPaterno, ApellidoMaterno, Edad, Sexo, Email, Telefono, TipoUsuario, Password)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
//comando para insertar los datos del formulario en la base de datos
$inserta->execute([$id, $nombre, $apepat, $apemat, $edad,$sexo, $email, $telefono, $tipousa, $hash]);

notificaToast("El Estudiante se ha registrado correctamente");//notificacion de que el estudiante se insertó correctamente
?>