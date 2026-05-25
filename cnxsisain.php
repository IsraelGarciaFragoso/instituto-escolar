<?php
$host = "sql104.infinityfree.com";//nombre del host
$db   = "if0_41146546_sisain";//nombre de la base de datos
$user = "if0_41146546";//nombre del usuario
$pass = "Mdllara1";//contraseña

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