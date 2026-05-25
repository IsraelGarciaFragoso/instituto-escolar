<?php

require "cnxsisain.php";


$id_usuario=$_POST['id_usuario'];
$nombre=$_POST['nombre'];
$apPat=$_POST['apPat'];
$apMat=$_POST['apMat'];
$sexo=$_POST['sexo'];
$edad=$_POST['edad'];
$celular=$_POST['celular'];
$email=$_POST['email'];
$departamento=$_POST['departamento'];
$tipoUs=$_POST['tipoUs'];
$contrasenia=$_POST['contrasenia'];

$inserta = $cnx ->prepare ("INSERT INTO tbl_usuarios (id_usuario, nombre, apPat, apmMat, sexo, edad, celular, email, departamento, tipoUs, contrasenia)
VALUES(?,?,?,?,?,?,?,?,?,?,?)"
);

$inserta -> bind_param(
"issssisssss",
$id_usuario,
$nombre,
$apPat,
$apMat,
$sexo,
$edad,
$celular,
$email,
$departamento,
$tipoUs,
$contrasenia
);

if($cnx->query($sql)){

echo "success";

}else{

echo "error";

}

?>