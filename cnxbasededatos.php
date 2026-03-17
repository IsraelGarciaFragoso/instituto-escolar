<?php
$host = "127.0.0.1";//nombre del host
$db   = "instituto";//nombre de la base de datos
$user = "root";//nombre del usuario
$pass = "Server@Win32";//contraseña

try 
{
    $cnx = new PDO//conexion a la base de datos con PDO, cnx permitira invocar a las sentencias preparadas cada vez que se invoque en cada consulta
    (
        "mysql:host=$host;dbname=$db;charset=utf8",$user,$pass,//parametros de sql y PDO
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]//validacion PDO
    );
} 
catch (PDOException $e) //errores del try catch
{   //mensaje si la conexion al servidor no fue exitosa
    die("Hubo un problema en la conexion a la base de datos, verifica los parametros e intentalo de nuevo");
}
?>